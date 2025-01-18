<?php

    include_once "../back/add_programs.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colleges</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .container {
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .add-new {
            background: #00d1b2;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .actions-bar {
            background: #4a4a4a;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .actions-bar button {
            background: transparent;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .search-box {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: white;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background: #f5f5f5;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .delete-btn {
            background: #ff3860;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .edit-btn {
            background: #3e8ed0;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .programs-btn {
            background: #00d1b2;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Modal Styles */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            box-sizing: border-box;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

    </style>    
</head>
<body>
    <!--  Adding New Program -->
        <div id="addProgramModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2>Add NNew Program</h2>
                <form action="/facultyloading/back/actions.php?action=add&department=<?php echo $_SESSION['departmentID']?>" method="POST">
                
                    <label for="programCode">Program Code:</label>
                    <input type="text" id="programCode" name="programCode" required>
                    
                    <label for="program">Program:</label>
                    <input type="text" id="program" name="program" required>

                    <label for="college">College:</label>
                    <input type="text" id="college" name="college" required>

                    <button type="submit" name="submit">Add Program</button>
                </form>
            </div>
        </div>

    <!-- Edit Program Modal -->
    <div id="editProgramModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <h2>Edit Program</h2>
            <form action="/facultyloading/back/actions.php?action=edit" method="POST">
                <label for="editProgramCode">Program Code:</label>
                <input type="text" id="editProgramCode" name="program_code">

                <label for="editProgramName">Program:</label>
                <input type="text" id="editProgramName" name="program_name" >

                <label for="editCollege">College:</label>
                <input type="text" id="editCollege" name="college" >

                <button type="submit">Update Program</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h1>Programs</h1>
        
        <button class="add-new">Add New</button>

        <div class="actions-bar">
            <div>
                <h6>lists of programs</h6>
            </div>
            <div>
                <input type="text" placeholder="Search:" class="search-box">
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>program code</th>
                    <th>program</th>
                    <th>college</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($programs as $row) { ?>
                    <tr>
                        <td><?php echo $row['program_code']; ?></td>
                        <td><?php echo $row['program_name']; ?></td>
                        <td><?php echo $row['college']; ?></td>
                        <td>
                            <div class="action-buttons">
                                <?php if ($_GET['department'] === $row['program_code']) { ?>
                                    <!-- Show buttons only if the user's department matches -->
                                    <button class="delete-btn" onclick="confirmDelete('<?php echo $row['program_code']; ?>')">🗑</button>

                                    <button class="edit-btn" onclick="openEditProgramModal('<?php echo htmlspecialchars($row['program_code'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['program_name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['college'], ENT_QUOTES); ?>')">✎</button>
                                <?php } else { ?>
                                    <!-- Show disabled buttons for unauthorized users -->
                                    <button class="delete-btn" disabled style="opacity: 0.5; cursor: not-allowed;">🗑</button>
                                    <button class="edit-btn" disabled style="opacity: 0.5; cursor: not-allowed;">✎</button>
                                <?php } ?>

                                <!-- These buttons are always accessible -->
                                <a href="class.php?program_code=<?php echo urlencode($row['program_code']); ?>">
                                    <button class="programs-btn">Class</button>
                                </a>
                                <a href="courses.php?program_code=<?php echo urlencode($row['program_code']); ?>">
                                    <button class="programs-btn">Courses</button>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="../scripts.js"></script>
</body>
</html>