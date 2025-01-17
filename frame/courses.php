<?php

include_once "../back/courses.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - BSIT</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding: 20px;
        }

        .header {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .program-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .program-subtitle {
            color: #666;
            margin: 5px 0;
        }

        .action-buttons {
            margin: 20px 0;
        }

        .btn {
            padding: 8px 16px;
            margin-right: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #28a745;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .filters {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }

        .filter-section {
            flex: 1;
        }

        .filter-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .filter-items {
            display: flex;
            gap: 10px;
        }

        .filter-item {
            background-color: #e9ecef;
            padding: 5px 10px;
            border-radius: 15px;
        }

        .table-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .action-icons {
            display: flex;
            gap: 8px;
        }

        .action-icon {
            padding: 6px;
            border-radius: 4px;
            cursor: pointer;
        }

        .edit-icon {
            background-color: #17a2b8;
            color: white;
        }

        .delete-icon {
            background-color: #dc3545;
            color: white;
        }

        .search-box {
            float: right;
            margin-bottom: 20px;
        }

        .search-box input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
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

        /* Add these new styles for the edit modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Style for the form inside the modal */
        .modal-content form {
            display: flex;
            flex-direction: column;
        }

        .modal-content form input,
        .modal-content form button {
            margin-bottom: 10px;
            padding: 5px;
        }

    </style>
</head>
<body>


      <!-- Edit Course Modal -->
<!-- Edit Course Modal -->
<div id="editCourseModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditCourseModal()">&times;</span>
        <h2>Edit Course</h2>
        <form action="courses.php" method="POST">
            <input type="hidden" id="edit_course_id" name="course_id">
            <input type="hidden" name="program_code" value="<?php echo htmlspecialchars($programCode); ?>">

            <label for="edit_subject_code">Subject Code:</label>
            <input type="text" id="edit_subject_code" name="subject_code" required>

            <label for="edit_course_title">Course Title:</label>
            <input type="text" id="edit_course_title" name="course_title" required>

            <label for="edit_year_level">Year Level:</label>
            <input type="number" id="edit_year_level" name="year_level" required>

            <label for="edit_semester">Semester:</label>
            <input type="text" id="edit_semester" name="semester" required>

            <label for="edit_lecture_hours">Lecture Hours:</label>
            <input type="number" id="edit_lecture_hours" name="lecture_hours" required>

            <label for="edit_lab_hours">Lab Hours:</label>
            <input type="number" id="edit_lab_hours" name="lab_hours" required>

            <label for="edit_credit_units">Credit Units:</label>
            <input type="number" id="edit_credit_units" name="credit_units" required>

            <label for="edit_slots">Slots:</label>
            <input type="number" id="edit_slots" name="slots" required>

            <button type="submit" name="edit_course">Update Course</button>
        </form>
    </div>
</div>

    

    <!--aad modal-->
    <div id="addCourseModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeAddCourseModal()">&times;</span>
            <h2>Add New Course</h2>
                <form action="courses.php" method="POST">
                    <input type="hidden" name="program_code" value="<?php echo htmlspecialchars($programCode); ?>">
                    
                    <label for="subject_code">Subject Code:</label>
                    <input type="text" id="subject_code" name="subject_code" required>

                    <label for="course_title">Course Title:</label>
                    <input type="text" id="course_title" name="course_title" required>

                    <label for="year_level">Year Level:</label>
                    <input type="number" id="year_level" name="year_level" required>

                    <label for="semester">Semester:</label>
                    <input type="text" id="semester" name="semester" required>

                    <label for="lecture_hours">Lecture Hours:</label>
                    <input type="number" id="lecture_hours" name="lecture_hours" required>

                    <label for="lab_hours">Lab Hours:</label>
                    <input type="number" id="lab_hours" name="lab_hours" required>

                    <label for="credit_units">Credit Units:</label>
                    <input type="number" id="credit_units" name="credit_units" required>

                    <label for="slots">Slots:</label>
                    <input type="number" id="slots" name="slots" required>

                    <button type="submit">Add Course</button>
                </form>
            </div>
        </div>

    <div class="header">
        <!-- <div class="program-title">BSIT</div>
        <div class="program-subtitle">BS Information Technology</div>
        <div class="program-subtitle">College: College of Computer Studies</div> -->
        

        <div class="header">
            <div class="program-title"><?php echo htmlspecialchars($programCode); ?></div>
            <div class="program-subtitle"><?php echo htmlspecialchars($program['program_name']); ?></div>
            <div class="program-subtitle">College: <?php echo htmlspecialchars($program['college']); ?></div>
        </div>
        <div class="action-buttons">
            <h5>courses</h5>
        </div>

        <div class="action-buttons">
            <button class="btn btn-primary" onclick="openAddCourseModal()">Add New Course</button>
        </div>

        <div class="filters">
            <div class="filter-section">
                <div class="filter-title">Semester</div>
                <div class="filter-items">
                    <span class="filter-item">First (28)</span>
                    <span class="filter-item">Second (22)</span>
                    <span class="filter-item">Summer (0)</span>
                </div>
            </div>
            <div class="filter-section">
                <div class="filter-title">Year Level</div>
                <div class="filter-items">
                    <span class="filter-item">1 (16)</span>
                    <span class="filter-item">2 (17)</span>
                    <span class="filter-item">3 (14)</span>
                    <span class="filter-item">4 (3)</span>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="search-box">
            <input type="text" placeholder="Search:">
        </div>
        <table>
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Course Title</th>
                    <th>Program</th>
                    <th>Year Level</th>
                    <th>Semester</th>
                    <th>Lecture/Lab Hrs</th>
                    <th>Credit Units</th>
                    <th>Slots</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($course['subject_code']); ?></td>
                        <td><?php echo htmlspecialchars($course['course_title']); ?></td>
                        <td><?php echo htmlspecialchars($course['program_code']); ?></td>
                        <td><?php echo htmlspecialchars($course['year_level']); ?></td>
                        <td><?php echo htmlspecialchars($course['semester']); ?></td>
                        <td><?php echo htmlspecialchars($course['lecture_hours']) . '/' . htmlspecialchars($course['lab_hours']); ?></td>
                        <td><?php echo htmlspecialchars($course['credit_units']); ?></td>
                        <td><?php echo htmlspecialchars($course['slots']); ?></td>
                        <td>
                            <div class="action-icons">
                                

                                <a href="courses.php?delete_course_code=<?php echo urlencode($course['subject_code']); ?>&program_code=<?php echo urlencode($programCode); ?>" class="action-icon delete-icon">🗑</a>

                                


                                <span class="action-icon edit-icon" onclick="openEditCourseModal('<?php echo htmlspecialchars(json_encode($course)); ?>')">✎</span>


                                
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="../scripts.js"></script>
</body>
</html>