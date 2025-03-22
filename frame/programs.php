<?php
include_once("../session/session.php");
include_once "../back/add_programs.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs</title>
    <link rel="stylesheet" href="../css/program.css">
       
</head>
<body>


    <!-- <div class="container"> -->
    <div class="header">
            <h1>Programs</h1>
        </div>
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