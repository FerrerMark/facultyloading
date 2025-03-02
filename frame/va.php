<?php
session_start();
require_once '../connections/connection.php'; // Adjust path as needed

$faculty_id = $_SESSION['faculty_id'] ?? null;
if (!$faculty_id) {
    header("Location: ../login.php"); // Redirect if not logged in
    exit();
}

// Fetch available courses
$course_query = "SELECT subject_code, course_title FROM courses ORDER BY course_title ASC";
$course_stmt = $conn->prepare($course_query);
$course_stmt->execute();
$courses = $course_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch request history
$history_query = "SELECT ppc.pending_id, ppc.subject_code, c.course_title, ppc.status, ppc.submission_date 
                  FROM pending_preferred_courses ppc
                  LEFT JOIN courses c ON ppc.subject_code = c.subject_code
                  WHERE ppc.faculty_id = :faculty_id 
                  ORDER BY ppc.submission_date DESC";
$history_stmt = $conn->prepare($history_query);
$history_stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
$history_stmt->execute();
$request_history = $history_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Availability</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #003087; color: white; }
        .delete-btn { background-color: #ff0000; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; }
        .cancel-btn { background-color: #ffcc00; color: black; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Course Availability</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <p><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
    <?php endif; ?>

    <h4>Courses</h4>
    <table>
        <tr><th>Course Title</th><th>Action</th></tr>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo htmlspecialchars($course['course_title']); ?></td>
                <td>
                    <form action="../back/availability.php" method="POST" style="display:inline;">
                        <input type="hidden" name="subject_code" value="<?php echo htmlspecialchars($course['subject_code']); ?>">
                        <input type="hidden" name="request_delete" value="1">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h4>My Request History</h4>
    <?php if (!empty($request_history)): ?>
        <table>
            <tr><th>Course Title</th><th>Status</th><th>Submission Date</th><th>Action</th></tr>
            <?php foreach ($request_history as $request): ?>
                <tr>
                    <td><?php echo htmlspecialchars($request['course_title'] ?? $request['subject_code']); ?></td>
                    <td><?php echo htmlspecialchars($request['status'] ?? 'Unknown'); ?></td>
                    <td><?php echo htmlspecialchars($request['submission_date']); ?></td>
                    <td>
                        <?php if ($request['status'] === 'Pending Deletion'): ?>
                            <form action="../back/availability.php" method="POST" style="display:inline;">
                                <input type="hidden" name="pending_id" value="<?php echo htmlspecialchars($request['pending_id']); ?>">
                                <input type="hidden" name="cancel_request" value="1">
                                <button type="submit" class="cancel-btn">Cancel</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No request history available.</p>
    <?php endif; ?>
</body>
</html>