<?php

    include_once("../back/manual_scheduling.php");

    $building = $_GET['building'] ?? null;
    $room_no = $_GET['room_no'] ?? null;

    // if (!$building || !$room_no) {
    //     die("Error: No room selected. Please go back and select a room.");
    // }

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
        .btn-uncheck { background-color: #2ecc71; flex: 1;}
        .hidden-checkbox { position: absolute; opacity: 0; }
        .td{box-shadow: 0px -1px 4px 0px #5f4b4b;}
            .checkbox-label {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    /* Default background when unchecked */
    .hidden-checkbox:not(:checked) + .checkbox-label {
        background-color: white;
    }

    /* Change color when checked */
    .hidden-checkbox:checked + .checkbox-label {
        background-color: #2ecc71; /* Green */
        border-color: #27ae60;
    }
       
    </style>
</head>
<body>
    <h2>Manual Scheduling for Section: <?php echo htmlspecialchars($section_id); ?> (Department: <?php echo htmlspecialchars($department); ?>)</h2>

    <form action="../back/manual_scheduling.php?section_id=<?php echo $_GET['section_id'];?>&department=<?php echo $_GET['department']; ?>&action=add" method="POST">

        <input type="hidden" name="section" value="<?php echo htmlspecialchars($section_id); ?>">

        <input type="hidden" name="department" value="<?php echo htmlspecialchars($department); ?>" >

        <label for="faculty">Select Faculty:</label>    
        <select name="teacher" id="faculty" required>
            <option value="">Select a faculty</option>
            <?php foreach ($facultyList as $faculty): ?>
                <option value="<?php echo htmlspecialchars($faculty['faculty_id'])?>">
                    <?php echo htmlspecialchars($faculty['firstname'] . ' ' . ($faculty['middlename'] ?? '') . ' ' . $faculty['lastname']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="courses">courses</label>
        <select name="course" id="courses" required>
            <option value="">Select a course</option>
            <?php foreach ($courseList as $course): ?>
                <option value="<?php echo htmlspecialchars($course['subject_code'])?>">
                    <?php echo htmlspecialchars($course['subject_code']); ?>
                </option>
            <?php endforeach ; ?>
        </select><br>

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
                            <td style="text-align: center;">
                                <?php
                                $schedule_key = $slot_num . '-' . $day_num;

                                $existing_schedule = null;
                                foreach ($schedules as $schedule) {
                                    if ($schedule['section_id'] == $section_id && 
                                        $schedule['time_slot'] == $slot_num && $schedule['day_of_week'] == $day_name) {
                                        $existing_schedule = $schedule;
                                        break;
                                    }   
                                }

                                if ($existing_schedule) {
                                    echo '<div style="color: red; font-weight: bold;">' . htmlspecialchars($existing_schedule['facultyName'] . ' - ' . $existing_schedule['subject_code']) . '</div>';
                                    echo '<input type="checkbox" name="schedule_data[' . htmlspecialchars($schedule_key) . ']" Hidden>';
                                } else {
                                    echo '<input class="hidden-checkbox" type="checkbox" name="schedule_data[' . htmlspecialchars($schedule_key) . ']"><label for="schedule_<?php echo $schedule_key; ?>" class="checkbox-label"></label>';
                                }
                                ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>

        <button type="submit">Save Schedule</button>
    </form>

    <h3>Existing Schedules for Section <?php echo htmlspecialchars($section_id); ?></h3>
    <table border="1">
        <tr>
            <th>Teacher</th>
            <th>Course</th>
            <th>Time Slot</th>
            <th>Day</th>
        </tr>
        <?php
        $filtered_schedules = array_filter($schedules, function($schedule) use ($section_id) {
            return $schedule['section_id'] == $section_id;
        });

        foreach ($filtered_schedules as $schedule) { ?>
            <tr>
                <td><?php echo htmlspecialchars($schedule['faculty_id']); ?></td>
                <td><?php echo htmlspecialchars($schedule['subject_code']); ?></td>
                <td><?php echo $time_slots[$schedule['time_slot']] ?? "Unknown"; ?></td>
                <td><?php echo $schedule['day_of_week'] ?? "Unknown"; ?></td>
                <td>
                    <form action="../back/manual_scheduling.php?section_id=<?php echo $_GET['section_id'];?>&department=<?php echo $_GET['department']; ?>&action=delete" method="POST">
                        
                        <input type="hidden" name="schedule_id" value="<?php echo htmlspecialchars($schedule['schedule_id']); ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
