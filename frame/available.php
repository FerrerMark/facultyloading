<?php
session_start();
try {
    include_once("../connections/connection.php");

    $faculty_id = $_SESSION['id'];

    $query = "SELECT availability, start_time, end_time FROM faculty WHERE faculty_id = :faculty_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['faculty_id' => $faculty_id]);
    $availability = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['available_days' => '', 'start_time' => '06:00', 'end_time' => '17:00'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $days = implode(',', $_POST['available_days'] ?? []);
        $start_time = $_POST['start_time'] . ':00';
        $end_time = $_POST['end_time'] . ':00';

        $update = "UPDATE faculty SET availability = :availability, start_time = :start_time, end_time = :end_time WHERE faculty_id = :faculty_id";
        $stmt = $pdo->prepare($update);
        $stmt->execute([
            'availability' => $days,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'faculty_id' => $faculty_id
        ]);

        header("Location: availability.php");
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Availability</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .container {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        box-sizing: border-box;
    }

    h1 {
        text-align: left;
        color: #2c3e50;
        margin-bottom: 26px;
        font-size: 2rem;
    }

    .availability-section {
        margin-bottom: 40px;
    }

    .availability-section h3 {
        color: #555;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .current-availability {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #ddd;
        color: #555;
    }

    .current-availability p {
        margin: 10px 0;
        font-size: 1.1rem;
    }

    .current-availability span {
        font-weight: bold;
        color: #555;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 20px;
        color: #555;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    select, input {
        width: 12%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .available-days {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 10px;
    }

    .available-days label {
        font-weight: normal;
        padding: 8px 15px;
        border-radius: 5px;
        background: #f0f0f0;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .available-days input[type="checkbox"] {
        display: none;
    }

    .available-days input[type="checkbox"]:checked + label {
        background: #28a745;
        color: white;
    }

    button {
        background: #0a2d53;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1.2rem;
        margin-top: 20px;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #0056b3;
    }

    @media (max-width: 768px) {
        .container {
            padding: 20px;
            margin: 10px;
        }
        h1 {
            font-size: 1.5rem;
        }
        .availability-section h3 {
            font-size: 1.2rem;
        }
        button {
            font-size: 1rem;
        }
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Set Your Availability</h1>

        <div class="availability-section">
            <h3>Current Availability</h3>
            <div class="current-availability">
                <?php
                $days = !empty($availability['availability']) ? explode(',', $availability['availability']) : [];
                $start_time = $availability['start_time'] ?? 'Not set';
                $end_time = $availability['end_time'] ?? 'Not set';
                ?>
                <p><span>Available Days:</span> <?= !empty($days) ? implode(', ', $days) : 'None selected'; ?></p>
                <p><span>Start Time:</span> <?= date("h:i A", strtotime($start_time)); ?></p>
                <p><span>End Time:</span> <?= date("h:i A", strtotime($end_time)); ?></p>
            </div>
        </div>

        <form action="" method="POST">
            <label for="available_days">Select Available Days:</label>
            <div class="available-days">
                <?php
                $all_days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                foreach ($all_days as $day) {
                    $checked = in_array($day, $days) ? 'checked' : '';
                    echo "<input type='checkbox' name='available_days[]' value='$day' $checked id='$day'>";
                    echo "<label for='$day'>$day</label>";
                }
                ?>
            </div>

            <label for="start_time">Start Time:</label>
            <select name="start_time" required>
                <?php
                for ($hour = 6; $hour <= 22; $hour++) {
                    $time = sprintf("%02d:00", $hour);
                    $selected = ($time === substr($start_time, 0, 5)) ? 'selected' : '';
                    echo "<option value='$time' $selected>$time</option>";
                }
                ?>
            </select>

            <label for="end_time">End Time:</label>
            <select name="end_time" required>
                <?php
                for ($hour = 7; $hour <= 23; $hour++) {
                    $time = sprintf("%02d:00", $hour);
                    $selected = ($time === substr($end_time, 0, 5)) ? 'selected' : '';
                    echo "<option value='$time' $selected>$time</option>";
                }
                ?>
            </select>

            <button type="submit">Save Availability</button>
        </form>
    </div>
</body>
</html>
