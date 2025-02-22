<?php
include_once("../back/faculty.php");
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="../fetchfaculty.js"></script>
</head>
<body>
    <!-- Add New Faculty Modal -->
    <div id="newFacultyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddNewModal()">×</span>
            <div class="modal-header">
                <h2>Add New Faculty</h2>
            </div>
            <div class="modal-body">
                <form id="newFacultyForm" action="../back/faculty.php?action=add&department=<?php echo $_GET['department']?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="department" name="department" value="<?php echo $_GET['department']?>">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required placeholder="Enter first name">
                    <label for="middlename">Middle Name:</label>
                    <input type="text" id="middlename" name="middlename" placeholder="Enter middle name">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required placeholder="Enter last name">
                    <label for="status">Employment Status:</label>
                    <select id="status" name="status" required>
                        <option value="">Select Employment Status</option>
                        <option value="Full-time">Full-time</option>
                        <option value="Part-time">Part-time</option>
                        <option value="Contract">Contract</option>
                    </select>
                    <label for="master_specialization">Master's Specialization:</label>
                    <select name="master_specialization" id="master_specialization">
                        <option value="general_education">General Education</option>
                        <option value="computer_science">Computer Science</option>
                    </select>
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" placeholder="Enter address"></textarea>
                    <label for="phone_no">Phone Number:</label>
                    <input type="text" id="phone_no" name="phone_no" required placeholder="Enter phone number">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="Dean">Dean</option>
                        <option value="Department Head">Department Head</option>
                        <option value="Instructor">Instructor</option>
                    </select>
                    <input type="hidden" name="department" value="<?php echo $_GET['department']; ?>">
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Faculty Modal -->
    <div id="editFacultyModal" class="modal" style="display: <?php echo isset($selectedFaculty) ? 'block' : 'none'; ?>;">
        <div class="modal-content">
            <span class="close" onclick="window.location.href='faculty.php?department=<?php echo $_GET['department']?>'">×</span>
            <div class="modal-header">
                <h2>Edit Faculty Attachment</h2>
            </div>
            <div class="modal-body">
                <h4><?php echo $selectedFaculty['firstname'] . ' ' . $selectedFaculty['lastname']; ?></h4>
                <form id="newFacultyForm" action="../back/faculty.php?action=edit&id=<?php echo $selectedFaculty['faculty_id']; ?>" method="post" enctype="multipart/form-data">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required placeholder="Enter first name" value="<?php echo htmlspecialchars($selectedFaculty['firstname']); ?>">
                    <label for="middlename">Middle Name:</label>
                    <input type="text" id="middlename" name="middlename" placeholder="Enter middle name" value="<?php echo htmlspecialchars($selectedFaculty['middlename']); ?>">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required placeholder="Enter last name" value="<?php echo htmlspecialchars($selectedFaculty['lastname']); ?>">
                    <label for="master_specialization">Master's Specialization:</label>
                    <select name="master_specialization" id="master_specialization">
                        <option value="general_education" <?php echo ($selectedFaculty['master_specialization'] == 'general_education') ? 'selected' : ''; ?>>General Education</option>
                        <option value="computer_science" <?php echo ($selectedFaculty['master_specialization'] == 'computer_science') ? 'selected' : ''; ?>>Computer Science</option>
                    </select>
                    <label for="status">Employment Status:</label>
                    <select id="status" name="status" required>
                        <option value="">Select Employment Status</option>
                        <option value="Full-time" <?php echo ($selectedFaculty['employment_status'] == 'Full-time') ? 'selected' : ''; ?>>Full-time</option>
                        <option value="Part-time" <?php echo ($selectedFaculty['employment_status'] == 'Part-time') ? 'selected' : ''; ?>>Part-time</option>
                        <option value="Contract" <?php echo ($selectedFaculty['employment_status'] == 'Contract') ? 'selected' : ''; ?>>Contract</option>
                    </select>
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" placeholder="Enter address"><?php echo htmlspecialchars($selectedFaculty['address']); ?></textarea>
                    <label for="phone_no">Phone Number:</label>
                    <input type="text" id="phone_no" name="phone_no" required placeholder="Enter phone number" value="<?php echo htmlspecialchars($selectedFaculty['phone_no']); ?>">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="Instructor" <?php echo ($selectedFaculty['role'] == 'Instructor') ? 'selected' : ''; ?>>Instructor</option>
                        <option value="Department Head" <?php echo ($selectedFaculty['role'] == 'Department Head') ? 'selected' : ''; ?>>Department Head</option>
                        <option value="Dean" <?php echo ($selectedFaculty['role'] == 'Dean') ? 'selected' : ''; ?>>Dean</option>
                    </select>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><?php echo $_GET['department']?> Faculty</h1>  
        </div>
        
        <div class="toolbar">
            <div class="toolbar-buttons">
                <h6>Faculty List</h6>
            </div>
            <div class="search-container">
                <input type="text" placeholder="Search: Last Name" class="search-box">
                <button class="search-btn" onclick="searchFaculty()">Search</button>
            </div>
        </div>

        <table border="1" id="faculty-table">
            <thead>
                <tr>
                    <th>Faculty ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>College</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Department ID</th>
                    <th>Department Title</th>
                    <th>Subject</th>
                    <th>Role</th>
                    <th>Master Specialization</th>
                </tr>
            </thead>
            <tbody id="faculty-table-body">
            </tbody>
        </table>

        <div id="pagination" style="text-align: center; margin-top: 20px;"></div>

        <button onclick="downloadExcel()">Download Faculty List</button>
    </div>

    <script src="../scripts.js"></script>
    <script>
        addEventListener("load", function () {
            fetch("../HR/HRtofaculty.php")
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        // Handle success if needed
                    }
                })
                .catch(error => alert("❌ Sync failed: " + error));
        });

        async function assignSchedule(facultyId) {
            try {
                let response = await fetch("../back/assign_schedule.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ faculty_id: facultyId }), 
                });

                let text = await response.text();
                console.log("Raw response:", text);

                if (!response.ok) {
                    throw new Error(`HTTP Error ${response.status}: ${response.statusText}`);
                }

                let result;
                try {
                    result = JSON.parse(text);
                } catch (jsonError) {
                    throw new Error("Invalid JSON response from server");
                }

                if (result.success) {
                    alert("Schedule assigned successfully!");
                    fetchFacultyData();
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