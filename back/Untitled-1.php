<?php
include_once "../connections/connection.php";

$sectionStmt = $pdo->query("SELECT section_id, section_name FROM sections ORDER BY section_name");
$sections = $sectionStmt->fetchAll(PDO::FETCH_ASSOC);

$section_id = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;

$stmt = $pdo->prepare("
    SELECT ss.schedule_id, ss.section_id, ss.subject_code, ss.day_of_week, ss.start_time, ss.end_time, 
           ss.semester, ss.program_code, ss.section_name,
           s.room_id, 
           f.firstname, f.middlename, f.lastname 
    FROM section_schedules ss
    LEFT JOIN schedules s ON ss.section_id = s.section_id AND ss.subject_code = s.subject_code 
                           AND ss.day_of_week = s.day_of_week
    LEFT JOIN faculty f ON s.faculty_id = f.faculty_id
    WHERE ss.section_id = :section_id
    ORDER BY FIELD(ss.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), ss.start_time
");
$stmt->bindParam(':section_id', $section_id);
$stmt->execute();
$scheduleData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$startTime = strtotime('06:00 AM');
$endTime = strtotime('09:00 PM');
$interval = 30 * 60;
$time_slots = [];

while ($startTime <= $endTime) {
    $time_slots[] = [
        'start' => date('h:i A', $startTime),
        'end' => date('h:i A', $startTime + $interval)
    ];
    $startTime += $interval;
}

$days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Scheduling</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
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

        <?php foreach ($time_slots as $slot): ?>
            <?php
            $hasSchedule = false;
            foreach ($days_of_week as $day_name) {
                foreach ($scheduleData as $schedule) {
                    if ($schedule['day_of_week'] == $day_name &&
                        strtotime($schedule['start_time']) <= strtotime($slot['start']) &&
                        strtotime($schedule['end_time']) > strtotime($slot['start'])) {
                        $hasSchedule = true;
                        break 2;
                    }
                }
            }
            ?>

            <?php if ($hasSchedule):?>
                <tr>
                    <td><?= $slot['start'] ?> - <?= $slot['end'] ?></td>
                    <?php foreach ($days_of_week as $day_name): ?>
                        <td>
                            <?php
                            $schedule_found = false;
                            foreach ($scheduleData as $schedule) {
                                if ($schedule['day_of_week'] == $day_name &&
                                    strtotime($schedule['start_time']) <= strtotime($slot['start']) &&
                                    strtotime($schedule['end_time']) > strtotime($slot['start'])) {
                                    
                                    $teacher_name = trim("{$schedule['firstname']} {$schedule['middlename']} {$schedule['lastname']}");
                                    $teacher_display = !empty($teacher_name) ? $teacher_name : "<small style='color: gray;'>No Faculty</small>";
                                    $room_display = !empty($schedule['room_id']) ? $schedule['room_id'] : "<small style='color: gray;'>No Room</small>";

                                    echo "<strong style='color: red;'>{$schedule['subject_code']}</strong><br>";
                                    echo "<small>Teacher: $teacher_display</small><br>";
                                    echo "<small>Room: $room_display</small>";
                                    $schedule_found = true;
                                    break;
                                }   
                            }

                            if (!$schedule_found) {
                                echo "<small style='color: gray;'>-</small>";
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endif; ?>

        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Please select a section to view the schedule.</p>
<?php endif; ?>

</body>
</html>
