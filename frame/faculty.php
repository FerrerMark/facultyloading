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
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #2c3e50;
        }

        .add-new {
            background-color: #00f2c3;
            color: white;
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

        .btn-loading {
            background-color: #00f2c3;
        }

        .position-badge {
            background-color: #f1c40f;
            color: #2c3e50;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .status-badge {
            color: #2c3e50;
            font-weight: 500;
        }

        /* Styles for the modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            margin-bottom: 20px;
        }

        .modal-header h2 {
            color: #2c3e50;
        }

        .modal-body form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-body label {
            font-weight: bold;
            color: #2c3e50;
        }

        .modal-body input[type="text"],
        .modal-body input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .modal-body input[type="submit"] {
            background-color: #00f2c3;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal-body input[type="submit"]:hover {
            background-color: #00d6ab;
        }
    </style>
</head>
<body>

    <!-- Add New Modal -->
    <div id="newFacultyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddNewModal()">&times;</span>
            <div class="modal-header">
                <h2>Add New Faculty Attachment</h2>
            </div>
            <div class="modal-body">
                <form id="newFacultyForm" action="../back/faculty.php?action=add" method="post" enctype="multipart/form-data">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required placeholder="Enter first name">

                    <label for="middlename">Middle Name:</label>
                    <input type="text" id="middlename" name="middlename" placeholder="Enter middle name">

                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required placeholder="Enter last name">

                    <label for="position">Position:</label>
                    <input type="text" id="position" name="position" required placeholder="Enter position">

                    <label for="college">College:</label>
                    <input type="text" id="college" name="college" required placeholder="Enter college name">

                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="">Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>

                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Faculty Modal -->
    <div id="editFacultyModal" class="modal" style="display: <?php echo isset($selectedFaculty) ? 'block' : 'none'; ?>;">
        <div class="modal-content">
            <span class="close" onclick="window.location.href='faculty.php';">&times;</span>
            <div class="modal-header">
                <h2>Edit Faculty Attachment</h2>
            </div>
            <div class="modal-body">

                <h4><?php echo $selectedFaculty['firstname'] . ' ' . $selectedFaculty['lastname']; ?></h4>

                <form id="editFacultyForm" action="../back/faculty.php?action=edit&id=<?php echo $selectedFaculty['account_number']; ?>" method="POST">

                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required placeholder="Enter first name"
                        value="<?php echo htmlspecialchars($selectedFaculty['firstname'] ?? ''); ?>">

                    <label for="middlename">Middle Name:</label>
                    <input type="text" id="middlename" name="middlename" placeholder="Enter middle name"
                        value="<?php echo htmlspecialchars($selectedFaculty['middlename'] ?? ''); ?>">

                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required placeholder="Enter last name"
                        value="<?php echo htmlspecialchars($selectedFaculty['lastname'] ?? ''); ?>">

                    <label for="position">Position:</label>
                    <input type="text" id="position" name="position" required placeholder="Enter position"
                        value="<?php echo htmlspecialchars($selectedFaculty['position'] ?? ''); ?>">

                    <label for="college">College:</label>
                    <input type="text" id="college" name="college" required placeholder="Enter college name"
                        value="<?php echo htmlspecialchars($selectedFaculty['college'] ?? ''); ?>">

                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="Active" <?php echo ($selectedFaculty['employment_status'] ?? '') === 'Active' ? 'selected' : ''; ?>>Active</option>
                        <option value="Inactive" <?php echo ($selectedFaculty['employment_status'] ?? '') === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>

                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>





    <div class="main-content">
        <div class="header">
            <h1>Faculty</h1>
        </div>

        <button onclick="openAddNewModal()">Add New</button>

        <div class="toolbar">
            <div class="toolbar-buttons">
                <h6>faculty list</h6>
            </div>
            <input type="text" placeholder="Search:" class="search-box">
        </div>

        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facultyList as $faculty): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($faculty['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['position']); ?></td>
                        <td>
                            
                            <a href="faculty.php?id=<?php echo $faculty['account_number']; ?>"><button>Edit</button></a>

                            <button class="delete-btn" onclick="confirmDeleteFaculty('<?php echo $faculty['account_number']; ?>')">🗑Delete</button>

                            <button class="delete-btn">View schedule</button>
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
    </table>


    </div>
    <script src="../scripts.js"></script>
</body>
</html>