<?php
include_once "../back/add_programs.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs</title>
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

        h1 {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 25px;
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

        .actions-bar {
            background: #34495e;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .actions-bar h6 {
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

        .delete-btn, .edit-btn, .programs-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: background-color 0.3s ease;
            min-width: 50px;
            text-align: center;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .edit-btn {
            background-color: #3498db;
            color: white;
        }

        .edit-btn:hover {
            background-color: #2980b9;
        }

        .programs-btn {
            background-color: #00c4b4;
            color: white;
        }

        .programs-btn:hover {
            background-color: #00a99d;
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

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: #333;
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

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
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

        .disabled-btn {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #dfe6e9;
            color: #888;
            position: relative;
        }

        .disabled-btn:hover::after {
            content: "Only for Dean";
            position: absolute;
            background: #34495e;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            .actions-bar {
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
            .delete-btn, .edit-btn, .programs-btn {
                width: 100%;
            }
            th, td {
                padding: 10px;
                font-size: 12px;
            }
        }
    </style>    
</head>
<body>
    <!-- Add New Program Modal -->
    <div id="addProgramModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">×</span>
            <h2>Add New Program</h2>
            <form action="/facultyloading/back/actions.php?action=add&department=<?php echo $_GET['department']?>&role=<?php echo $_GET['role']?>" method="POST">
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
            <span class="close-btn" onclick="closeEditModal()">×</span>
            <h2>Edit Program</h2>
            <form action="/facultyloading/back/actions.php?action=edit" method="POST">
                <label for="editProgramCode">Program Code:</label>
                <input type="text" id="editProgramCode" name="program_code">
                <label for="editProgramName">Program:</label>
                <input type="text" id="editProgramName" name="program_name">
                <label for="editCollege">College:</label>
                <input type="text" id="editCollege" name="college">
                <button type="submit">Update Program</button>
            </form>
        </div>
    </div>

    <!-- <div class="container"> -->
        <h1>Programs</h1>
        <?php if ($_GET['role'] == 'Dean'){?>   
            <button class="add-new">Add New</button>
        <?php }?>
        <div class="actions-bar">
            <div>
                <h6>Lists of Programs</h6>
            </div>
            <div class="search-container">
                <input type="text" placeholder="Search:" class="search-box" id="searchBox" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="search-btn" id="searchButton">Search</button>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Program Code</th>
                    <th>Program</th>
                    <th>College</th>
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
                                <?php if ($_GET['role'] == 'Dean' && $_GET['department'] === $row['program_code']) { ?>
                                    <button class="delete-btn" onclick="confirmDelete('<?php echo $row['program_code']; ?>')">🗑</button>
                                    <button class="edit-btn" onclick="openEditProgramModal('<?php echo htmlspecialchars($row['program_code'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['program_name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['college'], ENT_QUOTES); ?>')">✎</button>
                                <?php } else { ?>
                                    <button class="delete-btn disabled-btn">🗑</button>
                                    <button class="edit-btn disabled-btn">✎</button>
                                <?php } ?>
                                <a href="sections.php?department=<?php echo urlencode($row['program_code']); ?>&role=<?php echo urlencode($_GET['role']); ?>">
                                    <button class="programs-btn">Class</button>
                                </a>
                                <a href="courses.php?program_code=<?php echo urlencode($row['program_code']); ?>&role=<?php echo urlencode($_GET['role']); ?>&department=<?php echo urlencode($_GET['department']); ?>">
                                    <button class="programs-btn">Courses</button>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <!-- </div> -->

    <script src="../scripts.js"></script>
    <script>
        document.getElementById("searchButton").addEventListener("click", function() {
            let searchQuery = document.getElementById("searchBox").value;
            window.location.href = "?search=" + encodeURIComponent(searchQuery) + "&role=<?php echo urlencode($_GET['role']); ?>&department=<?php echo urlencode($_GET['department']); ?>";
        });
    </script>
</body>
</html>