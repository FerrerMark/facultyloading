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

        button {
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .edit-btn {
            background-color:#7dd700;
        }

        .schedule-btn {
            background-color: #00f2c3;
            color:black;
        }

        .add-btn{
            background-color: #00f2c3;
            color: black;   
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

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="../fetchfaculty.js"></script>

</head>
<body>

    <!-- Add New Faculty Modal -->
    <div id="newFacultyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddNewModal()">&times;</span>
            <div class="modal-header">
                <h2>Add New Faculty</h2>
            </div>
            <div class="modal-body">
                <form id="newFacultyForm" action="../back/faculty.php?action=add&department=<?php echo $_GET['department']?>" method="post" enctype="multipart/form-data">

                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required placeholder="Enter first name">

                    <label for="middlename">Middle Name:</label>
                    <input type="text" id="middlename" name="middlename" placeholder="Enter middle name">

                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required placeholder="Enter last name">

                    <!-- <label for="college">College:</label>
                    <select id="college" name="college" required>
                        <option value="">Select College</option>
                        <option value="College of Computing">College of Computing</option>
                        <option value="College of Engineering">College of Engineering</option>
                        <option value="College of Education">College of Education</option>
                        <option value="College of Criminal Justice">College of Criminal Justice</option>
                    </select> -->

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

                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required placeholder="Enter subject taught">

                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Department Head">Department Head</option>
                        <option value="Dean">Dean</option>
                    </select>

                    <input type="hidden" name="department" value="<?php echo $_GET['department']; ?>">

                    <input type="hidden" name="college" value="">


                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>



    <!-- Edit Faculty Modal -->
    <div id="editFacultyModal" class="modal" style="display: <?php echo isset($selectedFaculty) ? 'block' : 'none'; ?>;">
        <div class="modal-content">
            <span class="close" onclick="window.location.href='faculty.php?department=<?php echo $_GET['department']?>'">&times;</span>
            <div class="modal-header">
                <h2>Edit Faculty Attachment</h2>
            </div>
            <div class="modal-body">

                <h4><?php echo $selectedFaculty['firstname'] . ' ' . $selectedFaculty['lastname']; ?></h4>

                <form id="newFacultyForm" action="../back/faculty.php?action=edit&id=<?php echo $selectedFaculty['faculty_id']?>" method="post" enctype="multipart/form-data">

                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required placeholder="Enter first name" value="<?php  echo $selectedFaculty['firstname']?>">

                    <label for="middlename">Middle Name:</label>
                    <input type="text" id="middlename" name="middlename" placeholder="Enter middle name">

                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required placeholder="Enter last name">

                    <label for="master_specialization">Master's Specialization:</label>
                    <select name="master_specialization" id="master_specialization">
                        <option value="general_education">General Education</option>
                        <option value="computer_science">computer_science</option>
                    </select>

                    <!-- <label for="college">College:</label>
                    <select id="college" name="college" required>
                        <option value="">Select College</option>
                        <option value="College of Computing">College of Computing</option>
                        <option value="College of Engineering">College of Engineering</option>
                        <option value="College of Education">College of Education</option>
                        <option value="College of Criminal Justice">College of Criminal Justice</option>
                    </select> -->

                    <label for="status">Employment Status:</label>
                    <select id="status" name="status" required>
                        <option value="">Select Employment Status</option>
                        <option value="Full-time">Full-time</option>
                        <option value="Part-time">Part-time</option>
                        <option value="Contract">Contract</option>
                    </select>

                    <label for="address">Address:</label>
                    <textarea id="address" name="address" placeholder="Enter address"></textarea>

                    <label for="phone_no">Phone Number:</label>
                    <input type="text" id="phone_no" name="phone_no" required placeholder="Enter phone number">

                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required placeholder="Enter subject taught">

                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Department Head">Department Head</option>
                        <option value="Dean">Dean</option>
                    </select>

                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><?php echo $_GET['department']?>&nbsp;Faculty</h1>  
        </div>

        <button class="add-btn" onclick="openAddNewModal()">Add New</button>

        <div class="toolbar">
            <div class="toolbar-buttons">
                <h6>faculty list</h6>
            </div>
            <input type="text" placeholder="Search:" class="search-box">
        </div>

        <table id="faculty-table">
            <thead>
                <tr>
                    <th>Faculty ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>College</th>
                    <th>Employment Status</th>
                    <th>Address</th>
                    <th>Phone No</th>
                    <th>Department ID</th>
                    <th>Department Title</th>
                    <th>Subject</th>
                    <th>Role</th>
                    <th>Specialization</th>
                </tr>
            </thead>
            <tbody id="faculty-table-body">
                <!-- Data rows will be added here dynamically by JavaScript -->
            </tbody>
        </table>



    <button onclick="downloadExcel()">Download Faculty List</button>

    </div>
    <script src="../scripts.js"></script>


</body>
</html>