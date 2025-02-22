<?php


include_once("../connections/connection.php");

    $sql = "SELECT * FROM `faculty` WHERE `faculty_id` = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $result = $stmt->fetch();

    if ($result !== false) {
        $row = $result;
    } else {
        $row = [];
    }


    try {
        $stmt = $conn->prepare("
            SELECT section.section_name, 
                   CONCAT(f.firstname, ' ', f.lastname) AS teacher, 
                   sched.*, f.*, 
                   section.program_code,
                   section.year_level,
                   sched.end_time,
                sched.start_time,
                section.semester
            FROM faculty f
            LEFT JOIN schedules sched ON f.faculty_id = sched.faculty_id
            LEFT JOIN sections section ON section.section_id = sched.section_id
            WHERE f.faculty_id = :faculty_id
        ");
    
        $stmt->bindParam(':faculty_id', $_GET['id']);
        $stmt->execute();
    
        $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    } catch (PDOException $e) {
        echo "db_error: " . $e->getMessage();
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile</title>
    <style>
       

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 17px;
            padding: 0px;
        }

        
        .container {
            width: 100%;
            margin: auto;
            background: white;
            padding: inherit;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            padding: 19px 0;
        }

        .profile-card {
            background: #ffffff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .profile-card h3 {
            color: #007bff;
            margin-bottom: 10px;
        }

        .profile-card p {
            margin: 5px 0;
            color: #555;
        }

        .profile-card strong {
            color: #000;
        }

        .profile-card .line {
            border-bottom: 2px solid #ccc;
            margin: 10px 0;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>Faculty Profiles</h2>
    <?php if (count($row) > 0): ?>
        <div class="profile-card">
            <h3><?php echo htmlspecialchars($row['firstname'] . " " . $row['middlename'] . " " . $row['lastname']); ?></h3>
            <p><strong>Faculty ID:</strong> <?php echo htmlspecialchars($row['faculty_id']); ?></p>
            <div class="line"></div>
            <p><strong>College:</strong> <?php echo htmlspecialchars($row['college']); ?></p>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($row['departmentID']); ?></p>
            <div class="line"></div>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($row['role']); ?></p>
            <p><strong>Employment Status:</strong> <?php echo htmlspecialchars($row['employment_status']); ?></p>
            <div class="line"></div>
            <p><strong>Specialization:</strong> <?php echo htmlspecialchars($row['master_specialization']); ?></p>
            <p><strong>Max Weekly Hours:</strong> <?php echo htmlspecialchars($row['max_weekly_hours']); ?> hours</p>
            <div class="line"></div>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone_no']); ?></p>
            <p><strong>Joined:</strong> <?php echo htmlspecialchars($row['created_at']); ?></p>
        </div>
    <?php else: ?>
        <p>No faculty records found.</p>
    <?php endif; ?>

    <style>

        .table-info {
            border-collapse: collapse;
            width: 100%;
        }

        .table-info td, .table-info th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table-info tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-info th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #777777;
            color: white;
        }
    </style>

    <table class="table-info">
        <thead>
            <tr>
                <th>Section</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Subject Code</th>
                <th>Program</th>
                <th>Year Level</th>
                <th>Semester</th>
                <th>Room</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($schedules) && $schedules[0]['subject_code'] !== null): ?>
                <?php foreach ($schedules as $schedule): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($schedule['section_name'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['day_of_week'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['start_time'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['end_time'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['subject_code'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['program_code'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['year_level'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['semester'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($schedule['room_id'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-danger">No schedule yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>


