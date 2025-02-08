<?php
$api_url = "http://localhost/registrar/scheduleAPI.php";

$section_id = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;

if ($section_id > 0) {
    $api_url .= "?section_id=" . $section_id;
}

$response = file_get_contents($api_url);
$scheduleData = json_decode($response, true);

$startTime = strtotime('06:00 AM');
$endTime = strtotime('08:30 PM');
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
        body {font-family: Arial, sans-serif;padding: 20px;}
        h2 {text-align: center;}
        table {width: 100%;border-collapse: collapse;margin-top: 20px;}
        th, td {border: 1px solid black;padding: 10px;text-align: center;}
        th {background-color: #f4f4f4;}
        select, button {padding: 5px;}
    </style>
</head>
<body>

<h2>Manual Scheduling for Section: <?= htmlspecialchars($section_id) ?></h2>

<form method="GET">
    <label for="section_id"><strong>Select Section:</strong></label>
    <input type="number" name="section_id" id="section_id" required value="<?= $section_id ?>">
    <button type="submit">Load Schedule</button>
</form>

<form method="POST" action="../back/manual_scheduling.php?action=assign&section_id=<?= $section_id ?>">

    <label for="">Faculty Name:</label><br>
    <input type="text" name="faculty_name" required><br>

    <label>Course:</label><br>
    <input type="text" name="course_code"></input><br>


    <?php if ($scheduleData['status'] === "success" && !empty($scheduleData['data'])): ?>
            <table>
                <tr>
                    <th>Time Slot</th>
                    <?php foreach ($days_of_week as $day_name): ?>
                        <th><?= $day_name ?></th>
                    <?php endforeach; ?>
                </tr>

                <?php foreach ($time_slots as $slot): ?>
                    <tr>
                        <td><?= $slot['start'] ?> - <?= $slot['end'] ?></td>
                        <?php foreach ($days_of_week as $day_name): ?>
                            <td>
                                <?php
                                
                                $schedule_found = false;
                                foreach ($scheduleData['data'] as $schedule) {
                                    if ($schedule['day_of_week'] == $day_name &&
                                        strtotime($schedule['start_time']) <= strtotime($slot['start']) &&
                                        strtotime($schedule['end_time']) > strtotime($slot['start'])) {

                                        echo "<strong style='color: red;'>{$schedule['course_title']} ({$schedule['subject_code']})</strong><br>";
                                        echo "<small>No teacher yet</small>";
                                        $schedule_found = true;
                                        break;
                                    }
                                }
                                if (!$schedule_found) {
                                    echo "<input type='checkbox' name='schedule_data[{$slot['start']}-{$day_name}]'>";
                                }
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <button type="submit">Assign Faculty</button>
    <?php else: ?>
        <p style="color: red; text-align: center;">No schedules found.</p>
    <?php endif; ?>
</form>
</body>
</html>
