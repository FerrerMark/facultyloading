<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include_once("../connections/connection.php");

$faculty_id = $_SESSION['id'];
$sql = "SELECT f.role, f.departmentID, p.program_code, p.program_name 
        FROM faculty f 
        JOIN programs p ON f.departmentID = p.program_code 
        WHERE f.faculty_id = :faculty_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user['role'] !== "Department Head") {
    die("Access denied: Only Department Heads can request faculty.");
}

$user_department_code = $user['program_code'];
$user_department_name = $user['program_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Request Management</title>
    <link rel="stylesheet" href="../css/faculty_request_form.css">
</head>
<body>
    <!-- <div class="container"> -->
        <!-- Form Section -->
        <div class="form-container">
            <h2>New Faculty Request (Due to Shortage)</h2>
            <form action="../back/faculty_request_form.php" method="POST">
                <label>Requesting Department *</label>
                <div class="readonly-field"><?php echo htmlspecialchars($user_department_name); ?></div>
                <input type="hidden" name="department" value="<?php echo htmlspecialchars($user_department_code); ?>">

                <label>Role Needed *</label>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="Dean">Dean</option>
                    <option value="Department Head">Department Head</option>
                    <option value="Instructor">Instructor</option>
                </select>

                <label>Employment Status *</label>
                <div class="radio-group">
                    <input type="radio" name="employment_status" value="Full-Time" required> <label>Full-Time</label>
                    <input type="radio" name="employment_status" value="Part-Time"> <label>Part-Time</label>
                </div>

                <label>Specialization Needed</label>
                <input type="text" name="specialization" placeholder="e.g., General Education">

                <label>Reason for Shortage *</label>
                <textarea name="reason" required>Due to lack of faculty</textarea>

                <label>Number of Faculty Needed *</label>
                <input type="number" name="quantity" min="1" value="1" required>

                <label>Urgency *</label>
                <div class="radio-group">
                    <input type="radio" name="urgency" value="Low" required> <label>Low</label>
                    <input type="radio" name="urgency" value="Medium"> <label>Medium</label>
                    <input type="radio" name="urgency" value="High"> <label>High</label>
                </div>

                <label>Requested Start Date *</label>
                <input type="date" name="start_date" required>

                <div class="buttons">
                    <button type="button" class="cancel-btn" onclick="window.location.href='dashboard.php'">Cancel</button>
                    <button type="submit" class="submit-btn">Submit Request</button>
                </div>
            </form>
        </div>

        <!-- Request List Section -->
        <div class="list-container">
            <h2>My Submitted Requests</h2>
            <?php
            $sql = "SELECT request_id, department, role, status, stat, employment_status, submission_date, specialization
            FROM faculty_requests
            WHERE submitted_by = :faculty_id
            AND department = :department
            AND status IS NOT NULL
            AND status != ''
            ORDER BY submission_date DESC";


            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
            $stmt->bindParam(':department', $user_department_code, 
            PDO::PARAM_STR);
            $stmt->execute();
            $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($requests) > 0) {
                echo "<table>";
                echo "<tr><th>Request ID</th>
                <th>Department</th>
                <th>Role</th>
                <th>Employment Status</th>
                <th>Status</th>
                <th>Stat</th>
                <th>Submitted</th>
                <th>Specialization</th>
                <th>Action</th></tr>";
                foreach ($requests as $row) {
                    $status_class = "status-" . strtolower($row['status']);
                    echo "<tr>";
                    echo "<td>FRQ-{$row['request_id']}</td>";
                    echo "<td>{$row['department']}</td>";
                    echo "<td>{$row['role']}</td>";
                    echo "<td>{$row['employment_status']}</td>";
                    echo "<td class='$status_class'>{$row['status']}</td>";
                    echo "<td class='$status_class'>{$row['stat']}</td>";
                    echo "<td>" . date("Y-m-d H:i", strtotime($row['submission_date'])) . "</td>";
                    echo "<td>{$row['specialization']}</td>";
                    echo "<td>";
                    if ($row['status'] === "Pending") {
                        echo "<form action='../back/faculty_request_form.php' method='POST' style='display:inline;'>";
                        echo "<input type='hidden' name='request_id' value='{$row['request_id']}'>";
                        echo "<button type='submit' class='cancel-btn-table'>Cancel</button>";
                        echo "</form>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No requests submitted yet for your department.</p>";
            }
            ?>
        </div>
    </div>

    <?php
    include_once("../notif/notif.php");
    if (isset($_GET['success']) && $_GET['success'] === "true") {
        showNotification("Request submitted successfully", "Green");
    }
    if (isset($_GET['cancelled']) && $_GET['cancelled'] === "true") {
        showNotification("Request cancelled successfully", "Green");
    }
    ?>
</body>
</html>