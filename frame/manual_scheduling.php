<?php


include_once "../back/manual_scheduling.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Scheduling</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        .container { display: flex; padding: 1rem; gap: 2rem; }
        .schedule-container { flex: 1; }
        .form-container { width: 300px; }
        .header { margin-bottom: 1rem; }
        .header h2 { margin-bottom: 1rem; }
        .buttons { display: flex; gap: 0.5rem; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 4px; color: white; cursor: pointer; }
        .btn-teacher { background-color: #3498db; }
        .btn-class { background-color: #2ecc71; }
        .btn-room { background-color: #e67e22; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border: 1px solid #ddd; padding: 0.5rem; text-align: left; }
        th { background-color: #f5f5f5; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-control { width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; }
        textarea.form-control { height: 100px; resize: vertical; }
        .form-actions { display: flex; gap: 0.5rem; }
        .btn-save { background-color: #3498db; flex: 1; }
        .btn-uncheck { background-color: #2ecc71; flex: 1; }
    </style>
</head>
<body>
    <h2>Manual Scheduling</h2>
    <form method="POST">
        <label>Teacher:</label>
        <input type="text" name="teacher" required><br>

        <label>Subject:</label>
        <input type="text" name="subject" required><br>

        <label>Course:</label>
        <input type="text" name="course" required><br>

        <label>Room:</label>
        <input type="text" name="room" required><br>

        <label>Remarks:</label>
        <input type="text" name="remarks"><br>

        <h3>Select Schedule:</h3>
        <table border="1">
            <tr>
                <th>Time Slot</th>
                <?php foreach ($days_of_week as $day_num => $day_name) { ?>
                    <th><?php echo $day_name; ?></th>
                <?php } ?>
            </tr>
            <?php foreach ($time_slots as $slot_num => $slot_label) { ?>
                <tr>
                    <td><?php echo $slot_label; ?></td>
                    <?php foreach ($days_of_week as $day_num => $day_name) { ?>
                        <td>
                            <?php
                            $checkbox_name = $slot_num . '-' . $day_num;
                            echo renderCheckbox($checkbox_name, isset($schedule_data[$checkbox_name]));
                            ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>

        <button type="submit">Save Schedule</button>
    </form>

    <h3>Existing Schedules</h3>
    <table border="1">
        <tr>
            <th>Teacher</th>
            <th>Subject</th>
            <th>Course</th>
            <th>Room</th>
            <th>Time Slot</th>
            <th>Day</th>
        </tr>
        <?php foreach ($schedules as $schedule) { ?>
            <tr>
                <td><?php echo htmlspecialchars($schedule['teacher']); ?></td>
                <td><?php echo htmlspecialchars($schedule['subject']); ?></td>
                <td><?php echo htmlspecialchars($schedule['course']); ?></td>
                <td><?php echo htmlspecialchars($schedule['room']); ?></td>
                <td><?php echo $time_slots[$schedule['time_slot']] ?? "Unknown"; ?></td>
                <td><?php echo $days_of_week[$schedule['day_of_week']] ?? "Unknown"; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>