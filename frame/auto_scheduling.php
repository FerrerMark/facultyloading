<?php
include_once "../back/auto_scheduling.php"; // Include the back-end logic
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Generated Scheduling</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Auto Generated Scheduling</h1>
        <form method="POST" action="../back/auto_scheduling.php">
            <label for="faculty_id">Select Faculty:</label>
            <select name="faculty_id" id="faculty_id" required>
                <?php foreach ($faculties as $faculty): ?>
                    <option value="<?php echo $faculty['faculty_id']; ?>"><?php echo htmlspecialchars($faculty['firstname'] . ' ' . $faculty['lastname']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">Generate Schedule</button>
        </form>

        <?php if (isset($schedule)): ?>
            <h2>Generated Schedule</h2>
            <table>
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Time Slot</th>
                        <th>Subject</th>
                        <th>Room</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedule as $entry): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entry['day']); ?></td>
                            <td><?php echo htmlspecialchars($entry['time_slot']); ?></td>
                            <td><?php echo htmlspecialchars($entry['subject']); ?></td>
                            <td><?php echo htmlspecialchars($entry['room']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>