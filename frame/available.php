<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Availability</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Container */
.container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
}

/* Form Styling */
h2 {
    text-align: center;
    color: #007bff;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    font-weight: bold;
    margin: 10px 0 5px;
}

input[type="checkbox"], input[type="number"], select {
    margin-right: 10px;
}

input[type="number"], select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.available-days, .available-time-slots {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 10px;
}

/* Button Styling */
button {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 10px;
}

button:hover {
    background: #0056b3;
}

    </style>
</head>
<body>

<div class="container">
    <h2>Set Your Availability</h2>
    <form action="" method="POST">
        <label for="available_days">Select Available Days:</label>
        <div class="available-days">
            <?php 
            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
            foreach ($days as $day) { 
                $checked = strpos($availability['available_days'] ?? '', $day) !== false ? 'checked' : ''; 
                echo "<label><input type='checkbox' name='available_days[]' value='$day' $checked> $day</label>";
            }
            ?>
        </div>

        <label for="available_time_slots">Available Time Slots:</label>
        <div class="available-time-slots">
            <?php 
            $time_slots = ["08:00-12:00", "14:00-17:00"];
            foreach ($time_slots as $time) { 
                $checked = strpos($availability['available_time_slots'] ?? '', $time) !== false ? 'checked' : ''; 
                echo "<label><input type='checkbox' name='available_time_slots[]' value='$time' $checked> $time</label>";
            }
            ?>
        </div>

        <label for="max_weekly_hours">Max Weekly Hours:</label>
        <input type="number" name="max_weekly_hours" value="<?= htmlspecialchars($availability['max_weekly_hours'] ?? '') ?>" required>

        <label for="teaching_mode">Preferred Teaching Mode:</label>
        <select name="teaching_mode">
            <option value="Face-to-Face" <?= ($availability['teaching_mode'] ?? '') === 'Face-to-Face' ? 'selected' : '' ?>>Face-to-Face</option>
            <option value="Online" <?= ($availability['teaching_mode'] ?? '') === 'Online' ? 'selected' : '' ?>>Online</option>
            <option value="Hybrid" <?= ($availability['teaching_mode'] ?? '') === 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
        </select>

        <button type="submit">Save Availability</button>
    </form>
</div>

</body>
</html>
