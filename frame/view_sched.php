<?php
session_start();
include_once "../connections/connection.php";


$faculty_id = $_SESSION['id'];

try {
    $stmt = $conn->prepare("
    SELECT f.*, 
           CONCAT(f.firstname, ' ', f.lastname) AS teacher, 
           section.section_name, 
           sched.day_of_week, 
           sched.start_time,  -- Added Start Time
           sched.end_time,    -- Added End Time
           sched.subject_code, 
           sched.year_level, 
           sched.semester, 
           r.room_no,
           section.program_code,
           section.year_level,
           section.semester 
    FROM faculty f
            LEFT JOIN schedules sched ON f.faculty_id = sched.faculty_id
            LEFT JOIN sections section ON section.section_id = sched.section_id
            LEFT JOIN room_assignments ra ON ra.section_id = section.section_id
            AND ra.subject_code = sched.subject_code
            AND ra.day_of_week = sched.day_of_week
            AND ra.start_time = sched.start_time
            LEFT JOIN rooms r ON ra.room_id = r.room_id
            WHERE f.faculty_id = :faculty_id
    ");


    $stmt->bindParam(':faculty_id', $faculty_id);
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "db_error: " . $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        .faculty-info {
            background: #eef5ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .table thead tr {
                background-color: #007bff;
                color: white;
            }
            .table tbody tr:nth-child(even) {
                background-color: #f2f2f2;
            }
    </style>
</head>
<body>

    <h2>Faculty Schedule</h2>

    <?php if (!empty($schedules)): ?>
        <?php if (!empty($schedules) || isset($schedules[0])): ?>
            <div class="faculty-info">
                <h4 class="text-center">
                    <?php echo htmlspecialchars($schedules[0]['firstname'] ?? 'N/A') . " " . 
                            htmlspecialchars($schedules[0]['middlename'] ?? '') . " " . 
                            htmlspecialchars($schedules[0]['lastname'] ?? ''); ?>
                </h4>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($schedules[0]['role'] ?? 'N/A'); ?></p>
                <p><strong>College:</strong> <?php echo htmlspecialchars($schedules[0]['college'] ?? 'N/A'); ?></p>
                <p><strong>Employment Status:</strong> <?php echo htmlspecialchars($schedules[0]['employment_status'] ?? 'N/A'); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($schedules[0]['phone_no'] ?? 'N/A'); ?></p>
                <p><strong>Department:</strong> <?php echo htmlspecialchars($schedules[0]['department'] ?? 'N/A'); ?></p>
                <p><strong>Max Weekly Hours:</strong> <?php echo htmlspecialchars($schedules[0]['max_weekly_hours'] ?? 'N/A'); ?> hours</p>
            </div>
        <?php endif; ?>


        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Section</th>
                    <th>Program Code</th>
                    <th>Day</th>
                    <th>Start Time</th> 
                    <th>End Time</th> 
                    <th>Subject Code</th>
                    <th>Year Level</th>
                    <th>Semester</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schedules as $schedule): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($schedule['section_name'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['program_code'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['day_of_week'] ?? 'N/A'); ?></td>
                        <td><?php echo date("h:i A", strtotime($schedule['start_time'] ?? '00:00:00')); ?></td>
                        <td><?php echo date("h:i A", strtotime($schedule['end_time'] ?? '00:00:00')); ?></td> 
                        <td><?php echo htmlspecialchars($schedule['subject_code'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['year_level'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['semester'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['room_no'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


    <?php else: ?>
        <p class="text-center text-danger">No schedule found for this faculty member.</p>
    <?php endif; ?>



</body>
</html>
