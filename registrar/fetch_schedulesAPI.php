<?php
// API URL (Change this to your actual API URL)
$api_url = "http://localhost/registrar/scheduleAPI.php";

// Fetch section_id from GET request (for filtering)
$section_id = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;


if ($section_id > 0) {
    $api_url .= "?section_id=" . $section_id;
}

// Fetch data from API
$response = file_get_contents($api_url);
$scheduleData = json_decode($response, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Section Schedules</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

<h2>Section Schedules</h2>

<form method="GET">
    <label for="section_id">Select Section:</label>
    <input type="number" name="section_id" id="section_id" required>
    <button type="submit">Filter</button>
</form>

<?php if ($scheduleData['status'] === "success" && !empty($scheduleData['data'])): ?>
    <table>
        <tr>
            <th>Section</th>
            <th>Program</th>
            <th>Year</th>
            <th>Subject</th>
            <th>Course Type</th>
            <th>Day</th>
            <th>Time</th>
            <th>Semester</th>
        </tr>
        <?php foreach ($scheduleData['data'] as $schedule): ?>
            <tr>
                <td><?= htmlspecialchars($schedule['section_name']) ?></td>
                <td><?= htmlspecialchars($schedule['program_code']) ?></td>
                <td><?= htmlspecialchars($schedule['year_level']) ?></td>
                <td><?= htmlspecialchars($schedule['course_title']) ?> (<?= htmlspecialchars($schedule['subject_code']) ?>)</td>
                <td><?= htmlspecialchars($schedule['course_type']) ?></td>
                <td><?= htmlspecialchars($schedule['day_of_week']) ?></td>
                <td><?= htmlspecialchars($schedule['start_time']) ?> - <?= htmlspecialchars($schedule['end_time']) ?></td>
                <td><?= htmlspecialchars($schedule['semester']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No schedules found.</p>
<?php endif; ?>

</body>
</html>
