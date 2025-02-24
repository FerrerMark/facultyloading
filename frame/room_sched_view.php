<?php
include_once "../connections/connection.php";

$roomStmt = $pdo->query("SELECT room_id, room_no FROM rooms ORDER BY room_no");
$rooms = $roomStmt->fetchAll(PDO::FETCH_ASSOC);

$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

$stmt = $pdo->prepare("
    SELECT 
        ra.room_id,
        r.room_no,
        ra.day_of_week,
        ra.start_time,
        ra.end_time,
        ra.subject_code,
        ra.section_id,
        s.section_name
    FROM room_assignments ra
    JOIN rooms r ON ra.room_id = r.room_id
    JOIN sections s ON ra.section_id = s.section_id
    WHERE ra.room_id = :room_id
    ORDER BY FIELD(ra.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), 
             ra.start_time
");
$stmt->bindParam(':room_id', $room_id);
$stmt->execute();
$scheduleData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$startTime = strtotime('06:00 AM');
$endTime = strtotime('09:00 PM');
$interval = 30 * 60; 
$time_slots = [];  

while ($startTime < $endTime) {
    $current_time = date('H:i:s', $startTime);
    $next_time = date('H:i:s', $startTime + $interval);
    $time_slots[] = [
        'start' => $current_time,
        'end' => $next_time
    ];
    $startTime += $interval;
}

$days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

function formatTime($time) {
    return date('h:i A', strtotime($time));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Schedule</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: aliceblue; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
        select, button { padding: 5px; }
        td { min-width: 120px; height: 60px; position: relative; }
        .occupied { background-color: #90ee90a8; }
        .empty { color: gray; }
        .delete-btn, .add-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            border: none;
            background: none;
            padding: 0;
            display: none; /* Hidden by default */
        }
        .delete-btn {
            color: red;
        }
        .add-btn {
            color: green;
        }
        .delete-btn:hover {
            color: darkred;
        }
        .add-btn:hover {
            color: darkgreen;
        }
        td:hover .delete-btn, td:hover .add-btn {
            display: block; /* Show on hover */
        }
    </style>
</head>
<body>

<h2>Room Schedule</h2>

<form method="GET">
    <label for="room_id"><strong>Select Room:</strong></label>
    <select name="room_id" id="room_id" required>
        <option value="">-- Select Room --</option>
        <?php foreach ($rooms as $room): ?>
            <option value="<?= $room['room_id'] ?>" <?= ($room_id == $room['room_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($room['room_no']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Load Schedule</button>
</form>

<?php if ($room_id > 0): ?>
    <table>
        <tr>
            <th>Time Slot</th>
            <?php foreach ($days_of_week as $day_name): ?>
                <th><?= $day_name ?></th>
            <?php endforeach; ?>
        </tr>

        <?php foreach ($time_slots as $slot): ?>
            <tr>
                <td><?= formatTime($slot['start']) ?> - <?= formatTime($slot['end']) ?></td>
                <?php foreach ($days_of_week as $day_name):
                    $cell_content = "<small class='empty'>-</small>";
                    $cell_class = "";
                    $action_button = "";
                    
                    foreach ($scheduleData as $schedule):
                        if ($schedule['day_of_week'] == $day_name &&
                            $schedule['start_time'] <= $slot['start'] &&
                            $schedule['end_time'] > $slot['start']):
                            
                            $cell_content = "<strong>{$schedule['section_name']}</strong><br>" .
                                          "<small>{$schedule['subject_code']}</small>";
                            $cell_class = "class='occupied'";
                            $action_button = "<button class='delete-btn' onclick='deleteRoomAssignment({$schedule['room_id']}, \"{$schedule['day_of_week']}\", \"{$schedule['start_time']}\")'>×</button>";
                            break;
                        endif;
                    endforeach;
                    
                    if (empty($cell_class)) {
                        $action_button = "<button class='add-btn' onclick='addRoomAssignment($room_id, \"$day_name\", \"{$slot['start']}\", \"{$slot['end']}\")'>+</button>";
                    }
                ?>
                    <td <?= $cell_class ?>>
                        <?= $cell_content ?>
                        <?= $action_button ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Please select a room to view the schedule.</p>
<?php endif; ?>

<script>
function deleteRoomAssignment(roomId, dayOfWeek, startTime) {
    if (confirm('Are you sure you want to remove this room assignment?')) {
        console.log(`Deleting room assignment for Room ID: ${roomId}, Day: ${dayOfWeek}, Start: ${startTime}`);
        
        // Example AJAX call (uncomment and modify according to your setup):
        /*
        fetch('delete_room_assignment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ 
                room_id: roomId,
                day_of_week: dayOfWeek,
                start_time: startTime
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting room assignment: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the room assignment');
        });
        */
    }
}

function addRoomAssignment(roomId, dayOfWeek, startTime, endTime) {
    if (confirm('Do you want to assign a section to this time slot?')) {
        console.log(`Adding room assignment for Room ID: ${roomId}, Day: ${dayOfWeek}, Start: ${startTime}, End: ${endTime}`);
        
        // Example redirect or AJAX call (uncomment and modify according to your setup):
        /*
        // Option 1: Redirect to an assignment page
        window.location.href = `assign_room.php?room_id=${roomId}&day=${dayOfWeek}&start=${startTime}&end=${endTime}`;
        
        // Option 2: AJAX call to get available sections
        fetch('get_available_sections.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ 
                room_id: roomId,
                day_of_week: dayOfWeek,
                start_time: startTime,
                end_time: endTime
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Available sections:', data);
            // Handle section selection logic here
        });
        */
    }
}
</script>

</body>
</html>