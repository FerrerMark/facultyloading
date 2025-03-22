<?php
include_once("../back/faculty.php");


try {

    $department = isset($_GET['department']) ? $_GET['department'] : 'BSIT';
    $stmt = $pdo->prepare("
        SELECT f.*, GROUP_CONCAT(fc.subject_code) as subjects
        FROM faculty f
        LEFT JOIN faculty_courses fc ON f.faculty_id = fc.faculty_id
        WHERE f.departmentID = :department
        GROUP BY f.faculty_id
    ");
    $stmt->execute(['department' => $department]);
    $facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $facultyList = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f6f9;
            color: #333;
        }

        .main-content {
            flex: 1;
            padding: 30px;
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
        }

        .add-new:hover {
            background-color: #00a99d;
        }

        .toolbar {
            background-color: #34495e;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .toolbar-buttons h6 {
            color: white;
            font-size: 16px;
            font-weight: 500;
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
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

        .search-btn {
            background-color: #00c4b4;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .search-btn:hover {
            background-color: #00a99d;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
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
            flex-direction: column;
            gap: 8px;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: background-color 0.3s ease;
            width: 100%;
            color: black;
        }

        .delete-btn {
            background-color: #e74c3c;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .edit-btn {
            background-color: #7dd700;
        }

        .edit-btn:hover {
            background-color: #6ab900;
        }

        .schedule-btn {
            background-color: #00c4b4;
        }

        .schedule-btn:hover {
            background-color: #00a99d;
        }

        .add-btn, .btn {
            background-color: #00c4b4;
        }

        .position-badge {
            background-color: #f1c40f;
            color: #2c3e50;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge.full-time {
            background-color: #dfe6e9;
            color: #2c3e50;
        }

        .status-badge.part-time {
            background-color: #ffeaa7;
            color: #2c3e50;
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
            max-width: 550px;
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

        .close:hover,
        .close:focus {
            color: #333;
        }

        .modal-header {
            margin-bottom: 20px;
        }

        .modal-header h2 {
            color: #2c3e50;
            font-size: 22px;
            font-weight: 600;
        }

        .modal-body form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .modal-body label {
            font-weight: 500;
            color: #2c3e50;
            font-size: 14px;
        }

        .modal-body input[type="text"],
        .modal-body textarea,
        .modal-body select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .modal-body input[type="text"]:focus,
        .modal-body textarea:focus,
        .modal-body select:focus {
            outline: none;
            border-color: #00c4b4;
        }

        .modal-body textarea {
            min-height: 80px;
            resize: vertical;
        }

        .modal-body input[type="submit"] {
            background-color: #00c4b4;
            color: white;
            padding: 12px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .modal-body input[type="submit"]:hover {
            background-color: #00a99d;
        }

        #pagination {
            margin-top: 25px;
            text-align: center;
        }

        #pagination button {
            background-color: #00c4b4;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            margin: 0 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        #pagination button:hover:not(:disabled) {
            background-color: #00a99d;
        }

        #pagination button:disabled {
            background-color: #dfe6e9;
            cursor: not-allowed;
        }

        #pagination button.active {
            background-color: #34495e;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }
            .toolbar {
                flex-direction: column;
                gap: 10px;
            }
            .search-box {
                width: 100%;
            }
            table {
                font-size: 12px;
            }
            th, td {
                padding: 10px;
            }
            .action-buttons {
                flex-direction: row;
                flex-wrap: wrap;
            }
            button {
                width: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Edit Faculty Modal (unchanged) -->
    <div id="editFacultyModal" class="modal" style="display: <?php echo isset($selectedFaculty) ? 'block' : 'none'; ?>;">
        <div class="modal-content">
            <span class="close" onclick="window.location.href='faculty.php?department=<?php echo $_GET['department']?>'">×</span>
            <div class="modal-header">
                <h2>Edit Faculty Attachment</h2>
            </div>
            <div class="modal-body">
                
                <h4><?php echo isset($selectedFaculty) ? $selectedFaculty['firstname'] . ' ' . $selectedFaculty['lastname'] : ''; ?></h4>

                <form id="newFacultyForm" action="../back/faculty.php?action=edit&id=<?php echo isset($selectedFaculty) ? $selectedFaculty['faculty_id'] : ''; ?>" method="post" enctype="multipart/form-data">
                    <!-- Your form fields remain unchanged -->
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><?php echo htmlspecialchars($department); ?> Faculty</h1>  
        </div>
        
        <div class="toolbar">
            <div class="toolbar-buttons">
                <h6>Faculty List</h6>
            </div>
            <div class="search-container">
                <input type="text" placeholder="Search: Last Name" class="search-box" id="searchInput">
                <button class="search-btn" onclick="searchFaculty()">Search</button>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>College</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Department ID</th>
                    <th>Subject</th>
                    <th>Role</th>
                    <th>Master Specialization</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facultyList as $faculty): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($faculty['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['middlename'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars($faculty['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['college']); ?></td>
                        <td><span class="status-badge <?php echo strtolower($faculty['employment_status']); ?>-time"><?php echo htmlspecialchars($faculty['employment_status']); ?></span></td>
                        <td><?php echo htmlspecialchars($faculty['address']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['phone_no']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['departmentID']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['subjects'] ?: 'None'); ?></td>
                        <td><span class="position-badge"><?php echo htmlspecialchars($faculty['role']); ?></span></td>
                        <td><?php echo htmlspecialchars($faculty['master_specialization']); ?></td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn" onclick="window.location.href='faculty.php?department=<?php echo $department; ?>&id=<?php echo $faculty['faculty_id']; ?>'">Edit</button>
                                <button class="schedule-btn" onclick="viewSchedule(<?php echo $faculty['faculty_id']; ?>)">View Schedule</button>
                                <button class="schedule-btn" onclick="assignSchedule(<?php echo $faculty['faculty_id']; ?>)">Assign Schedule</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($facultyList)): ?>
                    <tr>
                        <td colspan="14" style="text-align: center;">No faculty found for this department.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div id="pagination" style="text-align: center; margin-top: 20px;"></div>
    </div>

    <script>
        function searchFaculty() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const lastName = row.cells[3].textContent.toLowerCase();
                row.style.display = lastName.includes(searchValue) ? '' : 'none';
            });
        }

        function viewSchedule(facultyId) {
            window.location.href = "../frame/info.php?id=" + facultyId;
        }

        async function assignSchedule(facultyId) {
            try {
                let response = await fetch("../back/assign_schedule.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ faculty_id: facultyId }), 
                });

                let result = await response.json();
                if (result.success) {
                    alert("Schedule assigned successfully!");
                    location.reload();
                } else {
                    alert("Failed to assign schedule: " + (result.message || "Unknown error"));
                }
            } catch (error) {
                console.error("Error assigning schedule:", error);
                alert("An error occurred while assigning the schedule. Please try again.");
            }
        }
    </script>
</body>
</html>