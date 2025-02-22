<?php
include_once "../connections/connection.php";
$db = $conn;

function assignRoomToSection($db, $section_id) {
    try {
        // Get all schedules for this section
        $schedules_query = "
            SELECT 
                ss.schedule_id,
                ss.section_id,
                ss.subject_code,
                ss.day_of_week,
                ss.start_time,
                ss.end_time,
                s.section_name
            FROM section_schedules ss
            JOIN sections s ON ss.section_id = s.section_id
            WHERE ss.section_id = :section_id";
        
        $stmt = $db->prepare($schedules_query);
        $stmt->execute([':section_id' => $section_id]);
        $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($schedules)) {
            echo "No schedules found for Section ID $section_id\n";
            return;
        }

        $required_capacity = 50;
        $section_name = $schedules[0]['section_name'];

        foreach ($schedules as $schedule) {
            // Find an available room
            $room_query = "
                SELECT r.room_id, r.room_no
                FROM rooms r
                WHERE r.capacity >= :capacity
                AND r.room_id NOT IN (
                    SELECT ra.room_id 
                    FROM room_assignments ra 
                    WHERE ra.day_of_week = :day_of_week
                    AND (
                        (:start_time < ra.end_time AND :end_time > ra.start_time)
                    )
                )
                AND r.room_type = 'Lecture'
                LIMIT 1";
            
            $room_stmt = $db->prepare($room_query);
            $room_stmt->execute([
                ':capacity' => $required_capacity,
                ':day_of_week' => $schedule['day_of_week'],
                ':start_time' => $schedule['start_time'],
                ':end_time' => $schedule['end_time']
            ]);
            
            $room = $room_stmt->fetch(PDO::FETCH_ASSOC);

            if ($room) {
                // Check if room is already assigned for this schedule
                $check_query = "
                    SELECT assignment_id 
                    FROM room_assignments 
                    WHERE section_id = :section_id 
                    AND subject_code = :subject_code 
                    AND day_of_week = :day_of_week 
                    AND start_time = :start_time 
                    AND end_time = :end_time 
                    LIMIT 1";
                
                $check_stmt = $db->prepare($check_query);
                $check_stmt->execute([
                    ':section_id' => $schedule['section_id'],
                    ':subject_code' => $schedule['subject_code'],
                    ':day_of_week' => $schedule['day_of_week'],
                    ':start_time' => $schedule['start_time'],
                    ':end_time' => $schedule['end_time']
                ]);
                
                $existing = $check_stmt->fetch();

                if ($existing) {
                    // Update existing assignment
                    $update_query = "
                        UPDATE room_assignments 
                        SET room_id = :room_id
                        WHERE assignment_id = :assignment_id";
                    
                    $update_stmt = $db->prepare($update_query);
                    $update_stmt->execute([
                        ':room_id' => $room['room_id'],
                        ':assignment_id' => $existing['assignment_id']
                    ]);
                } else {
                    // Insert new assignment
                    $insert_query = "
                        INSERT INTO room_assignments 
                        (section_id, subject_code, day_of_week, start_time, end_time, room_id)
                        VALUES 
                        (:section_id, :subject_code, :day_of_week, :start_time, :end_time, :room_id)";
                    
                    $insert_stmt = $db->prepare($insert_query);
                    $insert_stmt->execute([
                        ':section_id' => $schedule['section_id'],
                        ':subject_code' => $schedule['subject_code'],
                        ':day_of_week' => $schedule['day_of_week'],
                        ':start_time' => $schedule['start_time'],
                        ':end_time' => $schedule['end_time'],
                        ':room_id' => $room['room_id']
                    ]);
                }
                
                echo "Assigned room {$room['room_no']} to {$section_name} for {$schedule['subject_code']} on {$schedule['day_of_week']} {$schedule['start_time']}-{$schedule['end_time']}\n";
            } else {
                echo "No available room found for {$section_name} - {$schedule['subject_code']} on {$schedule['day_of_week']} {$schedule['start_time']}-{$schedule['end_time']}\n";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

function getSectionReport($db, $section_id) {
    $query = "
        SELECT 
            ss.schedule_id,
            ss.day_of_week,
            ss.start_time,
            ss.end_time,
            ss.subject_code,
            sec.section_name,
            ra.room_id,
            r.room_no,
            r.capacity
        FROM section_schedules ss
        LEFT JOIN room_assignments ra ON ss.section_id = ra.section_id 
            AND ss.subject_code = ra.subject_code 
            AND ss.day_of_week = ra.day_of_week 
            AND ss.start_time = ra.start_time 
            AND ss.end_time = ra.end_time
        LEFT JOIN rooms r ON ra.room_id = r.room_id
        JOIN sections sec ON ss.section_id = sec.section_id
        WHERE ss.section_id = :section_id
        ORDER BY ss.day_of_week, ss.start_time";
    
    $stmt = $db->prepare($query);
    $stmt->execute([':section_id' => $section_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Usage example
$section_id = 4;
assignRoomToSection($db, $section_id);

$report = getSectionReport($db, $section_id);
foreach ($report as $assignment) {
    echo "Section: {$assignment['section_name']}, ";
    echo "Subject: {$assignment['subject_code']}, ";
    echo "Day: {$assignment['day_of_week']}, ";
    echo "Time: {$assignment['start_time']}-{$assignment['end_time']}, ";
    echo "Room: " . ($assignment['room_no'] ?? 'Not Assigned') . "\n";
}