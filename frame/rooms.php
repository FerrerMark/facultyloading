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
            background-color: #f5f5f5;
            padding: 20px;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #2c3e50;
        }

        .container {
            /* max-width: 1200px; */
            width: 100%;
            margin: 0 auto;
        }

        .add-new {
            background-color: #00f2c3;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .toolbar {
            background-color: #6c757d;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toolbar-buttons {
            display: flex;
            gap: 10px;
        }

        .toolbar button {
            background: transparent;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .search-box {
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn {
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-edit {
            background-color: #17a2b8;
        }

        .btn-schedule {
            background-color: #00f2c3;
        }

        .pagination {
            display: flex;
            gap: 5px;
            justify-content: flex-end;
            align-items: center;
        }

        .pagination button {
            padding: 5px 10px;
            border: 1px solid #dee2e6;
            background: white;
            cursor: pointer;
        }

        .pagination button.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .entries-info {
            color: #6c757d;
            font-size: 0.9em;
        }

        // Modal styles
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }

        .close:hover {
            color: red;
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

    <!-- Add Room Modal -->
    <div id="openAddRoomModal" class="modal"  style="display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-content">
            <span class="close" onclick="closeAddRoomModal()">&times;</span>
            <h2>Add Room</h2>
            <form method="POST" action="../back/rooms.php?action=add">
            <label for="building">Select Campus:</label>
            <select name="building" id="building" required>
                <option value="" disabled selected>Select a campus</option>
                <option value="MV Campus">MV Campus</option>
                <option value="Bulacan Campus">Bulacan Campus</option>
                <option value="San Agustin">San Agustin</option>
                <option value="Main Campus">Main Campus</option>
            </select>
                <input type="text" name="room_no" placeholder="Room No" required>
                <input type="text" name="room_type" placeholder="Room Type" required>
                <button type="submit" name="add_room">Add</button>
            </form>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div id="openEditRoomModal" class="modal" 
        style="display: <?php echo isset($selectedRoomAndBuilding) ? 'block' : 'none'; ?>;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-content">
            <span class="close" onclick="closeEditRoomModal()">&times;</span>
            <h2>Edit Room</h2>
            <form method="POST" action="../back/rooms.php?action=edit&room=<?php echo $selectedRoomAndBuilding['room_no']; ?>&building=<?php echo $selectedRoomAndBuilding['building']; ?>&room_type=<?php echo $selectedRoomAndBuilding['room_type']; ?>">
                <label for="building">Select Campus:</label>
                <select name="building" id="building" required>
                    <option value="<?php echo $selectedRoomAndBuilding['building']; ?>" selected><?php echo $selectedRoomAndBuilding['building']; ?></option>
                    <option value="MV Campus">MV Campus</option>
                    <option value="Bulacan Campus">Bulacan Campus</option>
                    <option value="San Agustin">San Agustin</option>
                    <option value="Main Campus">Main Campus</option>
                </select>
                <input type="text" id="room" name="room_no" placeholder="Room No" value="<?php echo $selectedRoomAndBuilding['room_no']; ?>" required>
                <input type="text" id="type" name="room_type" placeholder="Room Type" value="<?php echo $selectedRoomAndBuilding['room_type']; ?>" required>
                <button type="submit" name="edit_room">Save Changes</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1>rooms</h1>
        </div>

        <button onclick="openAddRoomModal()">Add New</button>

        <div class="toolbar">
            <div class="toolbar-buttons">
                <button>Copy</button>
                <button>CSV</button>
                <button>Excel</button>
                <button>PDF</button>
                <button>Print</button>
                <button>Column visibility ▼</button>
            </div>
            <input type="text" placeholder="Search:" class="search-box">
        </div>

        <table>
            <thead>
                <tr>
                    <th>Building</th>
                    <th>Room_no</th>
                    <th>Room Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $room) { ?>
                    <tr>
                        <td><?php echo $room['building']; ?></td>
                        <td><?php echo $room['room_no']; ?></td>
                        <td><?php echo $room['room_type']; ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="rooms.php?building=<?php echo urlencode($room['building']); ?>&room_no=<?php echo urlencode($room['room_no']); ?>&action=select">
                                <button>✎</button></a>

                                <button class="btn btn-delete" onclick="deleteRoomComfirm('<?php echo $room['building'];?>','<?php echo $room['room_no']; ?>')">🗑</button>

                                <a href="manual_scheduling.php?building=<?php echo urlencode($room['building']); ?>&room_no=<?php echo urlencode($room['room_no']); ?>&department=<?php echo $_GET['department']; ?>"><button class="btn btn-schedule">Schedules</button></a>

                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="entries-info">Showing 1 to 6 of 6 entries</span>
            <div class="pagination">
                <button disabled>Previous</button>
                <button class="active">1</button>
                <button disabled>Next</button>
            </div>
        </div>
    </div>
    <script src="../scripts.js"></script>
</body>
</html>