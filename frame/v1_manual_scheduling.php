<?php
include_once "../connections/connection.php";

$sectionStmt = $pdo->query("SELECT section_id, section_name FROM sections ORDER BY section_name");
$sections = $sectionStmt->fetchAll(PDO::FETCH_ASSOC);

$section_id = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;

$stmt = $pdo->prepare("
    SELECT 
        ss.schedule_id, 
        ss.section_id, 
        ss.subject_code, 
        ss.day_of_week, 
        ss.start_time, 
        ss.end_time, 
        ss.semester, 
        ss.program_code, 
        ss.section_name,
        ra.room_id,
        r.room_no,
        f.firstname, 
        f.middlename, 
        f.lastname 
    FROM section_schedules ss
    LEFT JOIN room_assignments ra ON ss.section_id = ra.section_id 
        AND ss.subject_code = ra.subject_code 
        AND ss.day_of_week = ra.day_of_week 
        AND ss.start_time = ra.start_time 
        AND ss.end_time = ra.end_time
    LEFT JOIN rooms r ON ra.room_id = r.room_id
    LEFT JOIN schedules s ON ss.section_id = s.section_id 
        AND ss.subject_code = s.subject_code 
        AND ss.day_of_week = s.day_of_week
        AND ss.start_time = s.start_time 
        AND ss.end_time = s.end_time
    LEFT JOIN faculty f ON s.faculty_id = f.faculty_id
    WHERE ss.section_id = :section_id
    ORDER BY FIELD(ss.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), 
             ss.start_time, 
             ss.subject_code
");
$stmt->bindParam(':section_id', $section_id);
$stmt->execute();
$scheduleData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Modify the time slots generation to check for scheduled classes
$startTime = strtotime('06:00 AM');
$endTime = strtotime('09:00 PM');
$interval = 15 * 60;
$time_slots = [];

while ($startTime <= $endTime) {
    $current_time = date('H:i:s', $startTime);
    $next_time = date('H:i:s', $startTime + $interval);
    
    $has_schedule = false;
    foreach ($scheduleData as $schedule) {
        if (strtotime($schedule['start_time']) <= strtotime($current_time) &&
            strtotime($schedule['end_time']) > strtotime($current_time)) {
            $has_schedule = true;
            break;
        }
    }
    
    if ($has_schedule) {
        $time_slots[] = [
            'start' => $current_time,
            'end' => $next_time
        ];
    }
    
    $startTime += $interval;
}

$days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

function formatTime($time) {
    return date('h:i A', strtotime($time));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Scheduling</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: aliceblue;}
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
        select, button { padding: 5px; }
        td { min-width: 120px; height: 40px; }
    </style>
</head>
<body>

<h2>Schedule</h2>

<form method="GET">
    <label for="section_id"><strong>Select Section:</strong></label>
    <select name="section_id" id="section_id" required>
        <option value="">-- Select Section --</option>
        <?php foreach ($sections as $section): ?>
            <option value="<?= $section['section_id'] ?>" <?= ($section_id == $section['section_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($section['section_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Load Schedule</button>
</form>

<?php if ($section_id > 0): ?>
    <table>
        <tr>
            <th>Time Slot</th>
            <?php foreach ($days_of_week as $day_name): ?>
                <th><?= $day_name ?></th>
            <?php endforeach; ?>
        </tr>

        <?php
        $current_schedules = array_fill(0, count($days_of_week), null);
        
        foreach ($time_slots as $index => $slot):
            $slot_start = $slot['start'];
            $slot_end = $slot['end'];
            $has_content = false;
            
            foreach ($days_of_week as $day_name) {
                foreach ($scheduleData as $schedule) {
                    if ($schedule['day_of_week'] == $day_name &&
                        $schedule['start_time'] <= $slot_start &&
                        $schedule['end_time'] > $slot_start) {
                        $has_content = true;
                        break 2;
                    }
                }
            }
            
            if ($has_content):
        ?>
            <tr>
                <td><?= formatTime($slot_start) ?> - <?= formatTime($slot_end) ?></td>
                <?php foreach ($days_of_week as $day_index => $day_name):
                    $cell_content = "";
                    $cell_style = ""; 
                    foreach ($scheduleData as $schedule):
                        if ($schedule['day_of_week'] == $day_name &&
                            $schedule['start_time'] <= $slot_start &&
                            $schedule['end_time'] > $slot_start):

                            $teacher_name = trim("{$schedule['firstname']} {$schedule['middlename']} {$schedule['lastname']}");
                            $teacher_display = !empty($teacher_name) ? $teacher_name : "<small style='color: gray;'>No Faculty</small>";
                            $room_display = !empty($schedule['room_no']) ? $schedule['room_no'] : "<small style='color: gray;'>No Room</small>";

                            $new_content = "<strong style='color: black;'>{$schedule['subject_code']}</strong><br>" .
                                           "<small>Teacher: $teacher_display</small><br>" .
                                           "<small>Room: $room_display</small>";

                            if (!empty($teacher_name)) {
                                $cell_style = "style='background-color: #90ee90a8;'"; 
                            } else {
                                $cell_style = "style='background-color: #f08080d9;'"; 
                            }

                            if ($current_schedules[$day_index] !== $new_content):
                                $current_schedules[$day_index] = $new_content;
                                $cell_content = $new_content;
                                $row_span = ceil((strtotime($schedule['end_time']) - strtotime($slot_start)) / $interval);
                            endif;
                            break;
                        endif;
                    endforeach;

                    if (empty($cell_content) && $current_schedules[$day_index] === null):
                        echo "<td><small style='color: gray;'>-</small></td>";
                    elseif (!empty($cell_content)):
                        echo "<td rowspan='$row_span' $cell_style>$cell_content</td>";
                    endif;

                    if (isset($schedule) && strtotime($slot_end) >= strtotime($schedule['end_time'])):
                        $current_schedules[$day_index] = null;
                    endif;
                endforeach; ?>
            </tr>
        <?php 
            endif;
        endforeach; 
        ?>
    </table>
<?php else: ?>
    <p>Please select a section to view the schedule.</p>
<?php endif; ?>

</body>
</html>