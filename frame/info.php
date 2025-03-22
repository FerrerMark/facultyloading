<?php
include_once("../session/session.php");
include_once("../connections/connection.php");

$sql = "SELECT * FROM `faculty` WHERE `faculty_id` = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$result = $stmt->fetch();

if ($result !== false) {
    $row = $result;
} else {
    $row = [];
}

try {
    $stmt = $conn->prepare("
        SELECT section.section_name, 
               CONCAT(f.firstname, ' ', f.lastname) AS teacher, 
               sched.*, f.*, 
               section.program_code,
               section.year_level,
               sched.end_time,
               sched.start_time,
               section.semester,
               r.room_no
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
    $stmt->bindParam(':faculty_id', $_GET['id']);
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "db_error: " . $e->getMessage();
}

// Calculate total teaching hours
$total_hours = 0;
foreach ($schedules as $schedule) {
    if ($schedule['start_time'] && $schedule['end_time']) {
        $start = new DateTime($schedule['start_time']);
        $end = new DateTime($schedule['end_time']);
        $interval = $start->diff($end);
        $hours = $interval->h + ($interval->i / 60);
        $total_hours += $hours;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile</title>
    <link rel="stylesheet" href="../css/info.css">
</head>
<body>

    <h1>Faculty Profiles</h1>
    <?php if (count($row) > 0): ?>
        <div class="profile-card">
            <h3><?php echo htmlspecialchars($row['firstname'] . " " . $row['middlename'] . " " . $row['lastname']); ?></h3>
            <p><strong>Faculty ID:</strong> <?php echo htmlspecialchars($row['faculty_id']); ?></p>
            <div class="line"></div>
            <p><strong>College:</strong> <?php echo htmlspecialchars($row['college']); ?></p>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($row['departmentID']); ?></p>
            <div class="line"></div>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($row['role']); ?></p>
            <p><strong>Employment Status:</strong> <?php echo htmlspecialchars($row['employment_status']); ?></p>
            <div class="line"></div>
            <p><strong>Specialization:</strong> <?php echo htmlspecialchars($row['master_specialization']); ?></p>
            <p><strong>Max Weekly Hours:</strong> <?php echo htmlspecialchars($row['max_weekly_hours']); ?> hours</p>
            <p><strong>Current Teaching Hours per Week:</strong> <?php echo number_format($total_hours, 2); ?> hours</p>
            <div class="line"></div>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone_no']); ?></p>
            <p><strong>Joined:</strong> <?php echo htmlspecialchars($row['created_at']); ?></p>
        </div>
    <?php else: ?>
        <p>No faculty records found.</p>
    <?php endif; ?>

    <table class="table-info">
        <thead>
            <tr>
                <th>Section</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Subject Code</th>
                <th>Program</th>
                <th>Year Level</th>
                <th>Semester</th>
                <th>Room</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($schedules) && $schedules[0]['subject_code'] !== null): ?>
                <?php foreach ($schedules as $schedule): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($schedule['section_name'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['day_of_week'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['start_time'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['end_time'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['subject_code'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['program_code'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['year_level'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['semester'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['room_no'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-danger">No schedule yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>