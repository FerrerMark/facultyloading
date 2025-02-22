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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #000000;
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

        select, input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .available-days {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        }

        button {
            background: #0a2d53;
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

        label {
            font-weight: bold;
            margin: 10px 0 5px;
            display: flex;
            flex-direction: column;
            align-content: center;
            justify-content: center;
            align-items: center;
        }

        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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

        <label for="start_time">Start Time:</label>
        <select name="start_time" required>
            <?php 
            for ($hour = 6; $hour <= 22; $hour++) {
                $time = sprintf("%02d:00", $hour);
                echo "<option value='$time'>$time</option>";
            }
            ?>
        </select>

        <label for="end_time">End Time:</label>
        <select name="end_time" required>
            <?php 
            for ($hour = 7; $hour <= 23; $hour++) {
                $time = sprintf("%02d:00", $hour);
                echo "<option value='$time'>$time</option>";
            }
            ?>
        </select>

        <button type="submit">Save Availability</button>
    </form>
</div>

</body>
</html>
