<?php

include_once "../back/sections.php";

$dep = isset($_GET['department']) ? htmlspecialchars($_GET['department']) : '';
$role = isset($_GET['role']) ? htmlspecialchars($_GET['role']) : '';

$limit = 10; // Number of records per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

try {
    // Count total records for pagination
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM sections WHERE program_code = :department");
    $countStmt->bindParam(':department', $dep);
    $countStmt->execute();
    $totalRecords = $countStmt->fetchColumn();
    $totalPages = ceil($totalRecords / $limit);

    // Fetch sections with pagination
    $stmt = $pdo->prepare("
        SELECT * FROM sections
        WHERE program_code = :department
        ORDER BY section_id ASC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindParam(':department', $dep);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $sections = [];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Section</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px 0px 0px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .table-container {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add New Section</h1>
    <form action="../back/sections.php?role=<?php echo $role?>&department=<?php echo $dep?>&action=add_section" method="POST">

        <input type="hidden" name="action" value="add_section">
        <h3><?php echo $dep?></h3> <br>

        <input type="hidden" id="program_code" name="program_code" placeholder="Enter Program Code" value="<?php echo $dep?>">

        <label for="year_section">Year/Section:</label>
        <input type="text" id="year_section" name="section_name" required placeholder="e.g., 01">

        <label for="semester">Semester:</label>
        <select id="semester" name="semestrial" required>
            <option value="">Select Semester</option>
            <option value="First">First</option>
            <option value="Second">Second</option>
        </select>


        <label for="year_level">Year Level:</label>
        <select id="year_level" name="year_level" required>
            <option value="">Select Year Level</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>

        <button type="submit">Add Section</button>
    </form>
</div>

<div class="container table-container">
    <h2>Sections List</h2>
    <table>
        <tr>
            <th>Program Code</th>
            <th>Year/Section</th>
            <th>Year Level</th>
            <th>Semestrial</th>
            <th>Action</th>
        </tr>
        <?php if (!empty($sections)) : ?>
            <?php foreach ($sections as $section) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($section['program_code']); ?></td>
                    <td><?php echo htmlspecialchars($section['section_name']); ?></td>
                    <td><?php echo htmlspecialchars($section['year_level']); ?></td>
                    <td><?php echo htmlspecialchars($section['semester']); ?></td>
                    <td>
                        <button onclick="window.location.href='manual_scheduling.php?section_id=<?php echo urlencode($section['section_id']); ?>&department=<?php echo urlencode($section['program_code']); ?>'">View Schedule</button>
                    <form method="post" action="../back/sections.php?action=delete&role=<?php echo $role?>&department=<?php echo $dep?>">

                        <input type="hidden" name="section_id" value="<?php echo urlencode($section['section_id']); ?>">

                        <button onclick="window.location.href='sections.php?department=<?php echo urlencode($section['program_code']); ?>&role=<?php echo  $_GET['role']?>'">Delete</button>

                    </form>

                    </td>

                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4" style="text-align:center;">No sections added yet.</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Pagination Links -->
    <div style="text-align:center; margin-top:20px;">
        <?php if ($totalPages > 1) : ?>
            <?php if ($page > 1) : ?>
                <a href="?role=<?php echo $role; ?>&department=<?php echo $dep; ?>&page=1">First</a>
                <a href="?role=<?php echo $role; ?>&department=<?php echo $dep; ?>&page=<?php echo ($page - 1); ?>">Previous</a>
            <?php endif; ?>

            <strong>Page <?php echo $page; ?> of <?php echo $totalPages; ?></strong>

            <?php if ($page < $totalPages) : ?>
                <a href="?role=<?php echo $role; ?>&department=<?php echo $dep; ?>&page=<?php echo ($page + 1); ?>">Next</a>
                <a href="?role=<?php echo $role; ?>&department=<?php echo $dep; ?>&page=<?php echo $totalPages; ?>">Last</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($_GET['error'])): ?>
    <div style="color: red; text-align: center;">
        <?php
        if ($_GET['error'] === 'duplicate_section') {
            echo "This section already exists under the selected program!";
        } elseif ($_GET['error'] === 'invalid_input') {
            echo "Please fill in all fields correctly!";
        } elseif ($_GET['error'] === 'db_error') {
            echo "An error occurred. Please try again!";
        }
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <div style="color: green; text-align: center;">
        Section added successfully!
    </div>
<?php endif; ?>

</body>
</html>