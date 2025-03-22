<?php
include_once "../back/rooms.php";
include_once "../notif/notif.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>
    <link rel="stylesheet" href="../css/rooms.css">
</head>
<body>
    <!-- Add Room Modal -->
    <div id="openAddRoomModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddRoomModal()">×</span>
            <h2>Add Room</h2>
            <form method="POST" action="../back/rooms.php?action=add&department=<?php echo $_GET['department'] ?>">
                <label for="building">Select Campus:</label>
                <select name="building" id="building" required>
                    <option value="" disabled selected>Select a campus</option>
                    <option value="MV Campus">MV Campus</option>
                    <option value="Bulacan Campus">Bulacan Campus</option>
                    <option value="San Agustin">San Agustin</option>
                    <option value="Main Campus">Main Campus</option>
                </select>
                <label for="room_no">Room No:</label>
                <input type="text" name="room_no" placeholder="Room No" required>
                <label for="room_type">Room Type:</label>
                <input type="text" name="room_type" placeholder="Room Type" required>
                <label for="capacity">Room Capacity:</label>
                <input type="number" name="capacity" placeholder="Room Capacity" required min="1">
                <button type="submit" name="add_room">Add Room</button>
            </form>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div id="openEditRoomModal" class="modal" style="display: <?php echo isset($selectedRoomAndBuilding) ? 'block' : 'none'; ?>;">
        <div class="modal-content">
            <span class="close" onclick="closeEditRoomModal()">×</span>
            <h2>Edit Room</h2>
            <form method="POST" action="../back/rooms.php?action=edit&room=<?php echo urlencode($selectedRoomAndBuilding['room_no']); ?>&building=<?php echo urlencode($selectedRoomAndBuilding['building']); ?>&department=<?php echo urlencode($_GET['department']); ?>">
                <label for="building">Select Campus:</label>
                <select name="building" id="building" required>
                    <option value="<?php echo htmlspecialchars($selectedRoomAndBuilding['building']); ?>" selected>
                        <?php echo htmlspecialchars($selectedRoomAndBuilding['building']); ?>
                    </option>
                    <option value="MV Campus">MV Campus</option>
                    <option value="Bulacan Campus">Bulacan Campus</option>
                    <option value="San Agustin">San Agustin</option>
                    <option value="Main Campus">Main Campus</option>
                </select>
                <label for="room_no">Room No:</label>
                <input type="text" id="room_no" name="room_no" placeholder="Room No" value="<?php echo htmlspecialchars($selectedRoomAndBuilding['room_no']); ?>" required>
                <label for="room_type">Room Type:</label>
                <input type="text" id="room_type" name="room_type" placeholder="Room Type" value="<?php echo htmlspecialchars($selectedRoomAndBuilding['room_type']); ?>" required>
                <label for="capacity">Room Capacity:</label>
                <input type="number" id="capacity" name="capacity" placeholder="Capacity" value="<?php echo htmlspecialchars($selectedRoomAndBuilding['capacity']); ?>" required>
                <button type="submit" name="edit_room">Save Changes</button>
            </form>
        </div>
    </div>

        <div class="header">
            <h1>Rooms</h1>
        </div>

        <button class="add-new" onclick="openAddRoomModal()">Add New</button>
        <button class="add-new" onclick="autoroom()">Auto Room</button>


        <div class="toolbar">
            <h3>ROOMS</h3>
            <form method="POST" action="../back/rooms.php?department=<?php echo $_GET['department'] ?>&role=<?php echo $role?>&action=search" class="search-container">
                <input type="text" name="search" placeholder="Search: Room No" class="search-box" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Building</th>
                    <th>Room No</th>
                    <th>Room Type</th>
                    <th>Capacity</th>
                    <th>Action</th>
                </tr>
            </thead> 
            <tbody>
                <?php if (count($rooms) > 0): ?>
                    <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($room['building']); ?></td>
                            <td><?php echo htmlspecialchars($room['room_no']); ?></td>
                            <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                            <td><?php echo htmlspecialchars($room['capacity']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="rooms.php?building=<?php echo urlencode($room['building']); ?>&room_no=<?php echo urlencode($room['room_no']); ?>&action=select&department=<?php echo $_GET['department']?>">
                                        <button class="btn btn-edit">✎</button>
                                    </a>
                                    <button class="btn btn-delete" onclick="deleteRoomComfirm('<?php echo $room['building'];?>', '<?php echo $room['room_no']; ?>')">🗑</button>

                                    <a href="room_sched_view.php?building=<?php echo urlencode($room['building']); ?>&room_id=<?php echo urlencode($room['room_id']); ?>&department=<?php echo $_GET['department'];?>">
                                        <button class="btn btn-schedule">Schedules</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No results found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="entries-info">Showing 1 to <?php echo count($rooms); ?> of <?php echo count($rooms); ?> entries</span>
            <div class="pagination">
                <button disabled>Previous</button>
                <button class="active">1</button>
                <button disabled>Next</button>
            </div>
        </div>

        <?php

            if(isset($_GET['success'])){
                showNotification("Added successfully", "Green");
            }else if(isset($_GET['delete'])){
                showNotification("Deleted successfully", "Red");
            }elseif (isset($_GET['editted'])) {
                showNotification("Editted successfully", "Yellow");
            }
        
        
        
        ?>

    <script src="../scripts.js"></script>
    <script>
        function autoroom(){
            window.location.href = "../back/auto_room_assigning.php?department=<?php echo $_GET['department'] ?>&role=<?php echo $role?>&action=autoroom";
        }
        
    </script>
</body>
</html>