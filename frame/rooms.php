<?php
include_once "../back/rooms.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
            padding: 20px;
        }

        .container {
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
        }

        .add-new {
            background-color: #00c4b4;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-bottom: 25px;
        }

        .add-new:hover {
            background-color: #00a99d;
        }

        .toolbar {
            background: #34495e;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .toolbar h3 {
            color: white;
            font-size: 16px;
            font-weight: 500;
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-direction: row;
        }

        .search-box {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 220px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .search-box:focus {
            outline: none;
            border-color: #00c4b4;
        }

        .toolbar button {
            background-color: #00c4b4;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .toolbar button:hover {
            background-color: #00a99d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
            text-transform: uppercase;
        }

        td {
            font-size: 14px;
            color: #555;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #f1f3f5;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: background-color 0.3s ease;
            min-width: 50px;
            text-align: center;
            color: white;
        }

        .btn-delete {
            background-color: #e74c3c;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .btn-edit {
            background-color: #3498db;
        }

        .btn-edit:hover {
            background-color: #2980b9;
        }

        .btn-schedule {
            background-color: #00c4b4;
        }

        .btn-schedule:hover {
            background-color: #00a99d;
        }

        .pagination {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            align-items: center;
            margin-top: 20px;
        }

        .pagination button {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            background-color: #00c4b4;
            color: white;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .pagination button:hover:not(.active):not(:disabled) {
            background-color: #00a99d;
        }

        .pagination button.active {
            background-color: #34495e;
        }

        .pagination button:disabled {
            background-color: #dfe6e9;
            cursor: not-allowed;
        }

        .entries-info {
            color: #6c757d;
            font-size: 14px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 25px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #e74c3c;
        }

        .modal-content h2 {
            color: #2c3e50;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-weight: 500;
            color: #2c3e50;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #00c4b4;
        }

        button[type="submit"] {
            background-color: #00c4b4;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #00a99d;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            .toolbar {
                flex-direction: column;
                gap: 10px;
            }
            .search-box {
                width: 100%;
            }
            .action-buttons {
                flex-direction: column;
                align-items: flex-start;
            }
            .btn {
                width: 100%;
            }
            th, td {
                padding: 10px;
                font-size: 12px;
            }
            .pagination {
                justify-content: center;
                flex-wrap: wrap;
            }
        }
    </style>
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

    <script src="../scripts.js"></script>
    <script>
        function autoroom(){
            window.location.href = "../back/auto_room_assigning.php?department=<?php echo $_GET['department'] ?>&role=<?php echo $role?>&action=autoroom";
        }
        
    </script>
</body>
</html>