<?php

    include_once("../back/dashboard.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/dashstyle.css">
</head>
<body>
    <div class="dashboard">
        <main class="main-content">
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Faculty</h3>
                    <p class="number"><?php echo $faculty_count ?></p>
                    <p class="subtext">+2 from last month</p>
                </div>
                <div class="card">
                    <h3>Sections</h3>
                    <p class="number"><?php echo $section_count?></p>
                    <p class="subtext">Current Sections</p>
                </div>
                <div class="card">
                    <h3>Your Total Teaching Hrs</h3>
                    <p class="number"><?php echo number_format($faculty_teaching_hours, 2); ?> hrs</p>
                    <p class="subtext">Total hours you are scheduled to teach</p>
                </div>
            </div>
            
        </main>
    </div>
</body>
</html>