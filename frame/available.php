<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "../connections/connection.php";
session_start();

$faculty_id = $_SESSION['id'];
$query = "SELECT employment_status, availability, start_time, end_time FROM faculty WHERE faculty_id = :faculty_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
$stmt->execute();
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);
$employment_status = $faculty['employment_status'];
$current_availability = explode(',', $faculty['availability']);
$current_start_time = $faculty['start_time'];
$current_end_time = $faculty['end_time'];

$assigned_courses_query = "SELECT fc.subject_code, c.course_title 
                          FROM faculty_courses fc 
                          JOIN courses c ON fc.subject_code = c.subject_code 
                          WHERE fc.faculty_id = :faculty_id";
$stmt = $conn->prepare($assigned_courses_query);
$stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
$stmt->execute();
$assigned_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$request_history_query = "SELECT ppc.pending_id, ppc.subject_code, c.course_title, ppc.status, ppc.submission_date 
                          FROM pending_preferred_courses ppc 
                          JOIN courses c ON ppc.subject_code = c.subject_code 
                          WHERE ppc.faculty_id = :faculty_id 
                          ORDER BY ppc.submission_date DESC 
                          LIMIT 10";
$stmt = $conn->prepare($request_history_query);
$stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
$stmt->execute();
$request_history = $stmt->fetchAll(PDO::FETCH_ASSOC);

$message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Availability</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px; position: relative; margin: unset;}
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .courses-list { display: flex; flex-wrap: wrap; gap: 8px; }
        .courses-list label { padding: 6px 12px; background: #f0f0f0; border-radius: 5px; cursor: pointer; }
        .courses-list input[type="checkbox"]:checked + label { background: #28a745; color: white; }
        .courses-list input[type="checkbox"] { display: none; }
        button { background: #0a2d53; color: white; padding: 10px; border: none; border-radius: 5px; width: 100%; cursor: pointer; }
        button:hover { background: #0056b3; }
        h4 { color: #2c3e50; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #0a2d53; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .no-data { color: #666; font-style: italic; }
        .delete-btn { background: #dc3545; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; }
        .delete-btn:hover { background: #c82333; }
        .cancel-btn { background: #ffc107; color: #212529; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; }
        .cancel-btn:hover { background: #e0a800; }
        .notification { background: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px;   position: absolute; top: 0; right: 0;}
        td{ color: #555;}
        fieldset{ color: #555;}
        h1{ color: #2c3e50; margin-top: unset;}
    </style>
</head>
<body>
        <h1>Set Your Availability</h1>
        <?php if ($message): ?>
            <div class="notification">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <form action="../back/availability.php" method="POST">
            <fieldset>
                <legend>Select Courses:</legend>
                <div class="courses-list">
                    <?php
                    $course_query = "SELECT subject_code, course_title FROM courses WHERE program_code = 'BSIT'";
                    $stmt = $conn->prepare($course_query);
                    $stmt->execute();
                    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $assigned_subject_codes = array_column($assigned_courses, 'subject_code');
                    foreach ($courses as $course) {
                        $checked = in_array($course['subject_code'], $assigned_subject_codes) ? 'checked' : '';
                        echo "<input type='checkbox' name='courses[]' value='{$course['subject_code']}' id='course_{$course['subject_code']}' $checked>";
                        echo "<label for='course_{$course['subject_code']}'>{$course['course_title']}</label>";
                    }
                    ?>
                </div>
            </fieldset>
            <button type="submit">Save Availability</button>
        </form>

    <h4>My Current Course/s</h4>
    <?php if (!empty($assigned_courses)): ?>
        <table>
            <tr>
                <th>Course Title</th>
                <th>Action</th>
            </tr>
            <?php foreach ($assigned_courses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['course_title']); ?></td>
                    <td>
                        <form action="../back/availability.php" method="POST" style="display:inline;">
                            <input type="hidden" name="subject_code" value="<?php echo htmlspecialchars($course['subject_code']); ?>">
                            <input type="hidden" name="delete_course" value="1">
                            <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars($course['course_title']); ?>?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p class="no-data">No current courses assigned.</p>
    <?php endif; ?>

    <h4>My Request History</h4>
    <?php if (!empty($request_history)): ?>
        <table>
            <tr>
                <th>Course Title</th>
                <th>Status</th>
                <th>Submission Date</th>
                <th>Action</th>
            </tr>
            <?php foreach ($request_history as $request): ?>
                <tr>
                    <td><?php echo htmlspecialchars($request['course_title']); ?></td>
                    <td><?php echo htmlspecialchars($request['status']); ?></td>
                    <td><?php echo htmlspecialchars($request['submission_date']); ?></td>
                    <td>
                        <?php if ($request['status'] === 'Pending'): ?>
                            <form action="../back/availability.php" method="POST" style="display:inline;">
                                <input type="hidden" name="pending_id" value="<?php echo htmlspecialchars($request['pending_id']); ?>">
                                <input type="hidden" name="cancel_request" value="1">
                                <button type="submit" class="cancel-btn" onclick="return confirm('Are you sure you want to cancel the request for <?php echo htmlspecialchars($request['course_title']); ?>?');">Cancel</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p class="no-data">No request history available.</p>
    <?php endif; ?>

    <?php
        function showNotification($message, $color) {
            echo '<div style="color:white; background-color: ' . $color . '; opacity: 1; transition: opacity 1s;" class="notification" id="notification">';
            echo '<p>' . $message . '</p>';
            echo '</div>';
            echo '<script>
                setTimeout(function() {
                    document.getElementById("notification").style.opacity = "0";
                }, 3000);
                setTimeout(function() {
                    document.getElementById("notification").style.display = "none";
                }, 4000);
            </script>';
        }

        if (isset($_GET['cancel_success'])) {
            showNotification('Request cancelled successfully.', 'green');
        }

        if (isset($_GET['delete_success'])) {
            showNotification('delete course successfully.', 'red');
        }

        if (isset($_GET['request_success'])) {
            showNotification('Request successfully.', 'Green');
        }
        
    ?>

</body>
</html>
