<?php
include_once "../connections/connection.php";
session_start();

if ($_SESSION['role'] !== 'Department Head') {
    header("Location: ../unauthorized.php");
    exit();
}

$dept_head_id = $_SESSION['id'];
$query = "SELECT departmentID FROM faculty WHERE faculty_id = :dept_head_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':dept_head_id', $dept_head_id, PDO::PARAM_INT);
$stmt->execute();
$dept_head_department = $stmt->fetch(PDO::FETCH_ASSOC)['departmentID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pending_id = $_POST['pending_id'];
    $action = $_POST['action'];
    $type = $_POST['type'] ?? 'add';

    if ($type === 'delete') {
        $query = "SELECT pd.faculty_id, pd.subject_code 
                  FROM pending_deletions pd 
                  JOIN faculty f ON pd.faculty_id = f.faculty_id 
                  WHERE pd.pending_id = :pending_id AND f.departmentID = :dept_head_department";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':pending_id', $pending_id, PDO::PARAM_INT);
        $stmt->bindParam(':dept_head_department', $dept_head_department, PDO::PARAM_STR);
        $stmt->execute();
        $deletion = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$deletion) {
            $_SESSION['message'] = "Invalid request or you do not have permission.";
            header("Location: review_availability.php");
            exit();
        }

        if ($action === 'accept') {
            $query = "DELETE FROM faculty_courses WHERE faculty_id = :faculty_id AND subject_code = :subject_code";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':faculty_id', $deletion['faculty_id'], PDO::PARAM_INT);
            $stmt->bindParam(':subject_code', $deletion['subject_code'], PDO::PARAM_STR);
            $stmt->execute();

            $query = "UPDATE pending_deletions SET status = 'Accepted' WHERE pending_id = :pending_id";
        } else {
            $query = "UPDATE pending_deletions SET status = 'Rejected' WHERE pending_id = :pending_id";
        }
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':pending_id', $pending_id, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $query = "SELECT ppc.faculty_id, ppc.subject_code, ppc.available_days, ppc.start_time, ppc.end_time 
                  FROM pending_preferred_courses ppc 
                  JOIN faculty f ON ppc.faculty_id = f.faculty_id 
                  WHERE ppc.pending_id = :pending_id AND f.departmentID = :dept_head_department";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':pending_id', $pending_id, PDO::PARAM_INT);
        $stmt->bindParam(':dept_head_department', $dept_head_department, PDO::PARAM_STR);
        $stmt->execute();
        $submission = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$submission) {
            $_SESSION['message'] = "Invalid request or you do not have permission.";
            header("Location: review_availability.php");
            exit();
        }

        if ($action === 'accept') {
            $query = "INSERT INTO faculty_courses (faculty_id, subject_code) 
                      VALUES (:faculty_id, :subject_code)
                      ON DUPLICATE KEY UPDATE subject_code = subject_code";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':faculty_id', $submission['faculty_id'], PDO::PARAM_INT);
            $stmt->bindParam(':subject_code', $submission['subject_code'], PDO::PARAM_STR);
            $stmt->execute();

            if ($submission['available_days']) {
                $query = "UPDATE faculty SET availability = :available_days, start_time = :start_time, end_time = :end_time 
                          WHERE faculty_id = :faculty_id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':faculty_id', $submission['faculty_id'], PDO::PARAM_INT);
                $stmt->bindParam(':available_days', $submission['available_days'], PDO::PARAM_STR);
                $stmt->bindParam(':start_time', $submission['start_time'], PDO::PARAM_STR);
                $stmt->bindParam(':end_time', $submission['end_time'], PDO::PARAM_STR);
                $stmt->execute();
            }

            $query = "UPDATE pending_preferred_courses SET status = 'Accepted' WHERE pending_id = :pending_id";
        } else {
            $query = "UPDATE pending_preferred_courses SET status = 'Rejected' WHERE pending_id = :pending_id";
        }
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':pending_id', $pending_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    header("Location: review_availability.php");
    exit();
}

$query = "SELECT ppc.pending_id, f.firstname, f.lastname, f.faculty_id, ppc.subject_code, c.course_title, ppc.available_days, ppc.start_time, ppc.end_time, ppc.status
          FROM pending_preferred_courses ppc
          JOIN faculty f ON ppc.faculty_id = f.faculty_id
          JOIN courses c ON ppc.subject_code = c.subject_code
          WHERE ppc.status = 'Pending' AND f.departmentID = :dept_head_department";
$stmt = $conn->prepare($query);
$stmt->bindParam(':dept_head_department', $dept_head_department, PDO::PARAM_STR);
$stmt->execute();
$submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$deletion_query = "SELECT pd.pending_id, f.firstname, f.lastname, pd.subject_code, c.course_title
                   FROM pending_deletions pd
                   JOIN faculty f ON pd.faculty_id = f.faculty_id
                   JOIN courses c ON pd.subject_code = c.subject_code
                   WHERE pd.status = 'Pending' AND f.departmentID = :dept_head_department";
$stmt = $conn->prepare($deletion_query);
$stmt->bindParam(':dept_head_department', $dept_head_department, PDO::PARAM_STR);
$stmt->execute();
$deletion_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Faculty Availability</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .accept { background-color: #5cb85c; color: white; border: none; padding: 5px 10px; cursor: pointer; }
        .reject { background-color: #d9534f; color: white; border: none; padding: 5px 10px; cursor: pointer; }
        .accept:hover { background-color: #4cae4c; }
        .reject:hover { background-color: #c9302c; }
    </style>
</head>
<body>
    <h1>Review Faculty Availability Submissions</h1>
    <table>
        <tr>
            <th>Faculty Name</th>
            <th>Requested Course</th>
            <th>Available Days</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Action</th>
        </tr>
        <?php foreach ($submissions as $submission): ?>
            <tr>
                <td><?php echo htmlspecialchars($submission['firstname'] . ' ' . $submission['lastname']); ?></td>
                <td><?php echo htmlspecialchars($submission['course_title']); ?></td>
                <td><?php echo htmlspecialchars($submission['available_days'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($submission['start_time'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($submission['end_time'] ?? 'N/A'); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="pending_id" value="<?php echo $submission['pending_id']; ?>">
                        <input type="hidden" name="type" value="add">
                        <button type="submit" name="action" value="accept" class="accept" onclick="return confirm('Are you sure you want to accept the request for <?php echo htmlspecialchars($submission['course_title']); ?> by <?php echo htmlspecialchars($submission['firstname'] . ' ' . $submission['lastname']); ?>?');">Accept</button>
                        <button type="submit" name="action" value="reject" class="reject" onclick="return confirm('Are you sure you want to reject the request for <?php echo htmlspecialchars($submission['course_title']); ?> by <?php echo htmlspecialchars($submission['firstname'] . ' ' . $submission['lastname']); ?>?');">Reject</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Review Faculty Deletion Requests</h2>
    <table>
        <tr>
            <th>Faculty Name</th>
            <th>Course to Delete</th>
            <th>Action</th>
        </tr>
        <?php foreach ($deletion_requests as $request): ?>
            <tr>
                <td><?php echo htmlspecialchars($request['firstname'] . ' ' . $request['lastname']); ?></td>
                <td><?php echo htmlspecialchars($request['course_title']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="pending_id" value="<?php echo $request['pending_id']; ?>">
                        <input type="hidden" name="type" value="delete">
                        <button type="submit" name="action" value="accept" class="accept" onclick="return confirm('Are you sure you want to approve the deletion of <?php echo htmlspecialchars($request['course_title']); ?> for <?php echo htmlspecialchars($request['firstname'] . ' ' . $request['lastname']); ?>?');">Approve</button>
                        <button type="submit" name="action" value="reject" class="reject" onclick="return confirm('Are you sure you want to reject the deletion request for <?php echo htmlspecialchars($request['course_title']); ?> for <?php echo htmlspecialchars($request['firstname'] . ' ' . $request['lastname']); ?>?');">Reject</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>