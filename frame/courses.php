<?php
include_once "../back/courses.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - <?php echo htmlspecialchars($programCode); ?></title>
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

        .header {
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 100%;
            margin: 0 auto 25px;
        }

        .program-title {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .program-subtitle {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
        }

        .action-buttons {
            margin: 20px 0;
        }

        .action-buttons h5 {
            font-size: 16px;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #00c4b4;
            color: white;
        }

        .btn-primary:hover {
            background-color: #00a99d;
        }

        .toolbar {
            background: #34495e;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 100%;
            margin: 0 auto 25px;
        }

        .toolbar h3 {
            color: white;
            font-size: 16px;
            font-weight: 500;
        }

        .toolbar-controls {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .filter-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-title {
            color: white;
            font-weight: 500;
            font-size: 14px;
        }

        .filter-items {
            display: flex;
            gap: 10px;
        }

        .filter-item {
            background-color: #e9ecef;
            padding: 5px 10px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 13px;
        }

        .filter-item:hover {
            background-color: #00c4b4;
            color: white;
        }

        .filter-item.active {
            background-color: #00c4b4;
            color: white;
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

        .table-container {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 100%;
            margin: 0 auto;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .action-icons {
            display: flex;
            gap: 8px;
        }

        .action-icon {
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: background-color 0.3s ease;
            width: 32px;
            text-align: center;
        }

        .edit-icon {
            background-color: #3498db;
            color: white;
        }

        .edit-icon:hover {
            background-color: #2980b9;
        }

        .delete-icon {
            background-color: #e74c3c;
            color: white;
        }

        .delete-icon:hover {
            background-color: #c0392b;
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

        .close, .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover, .close-btn:hover,
        .close:focus, .close-btn:focus {
            color: #e74c3c;
        }

        .modal-content h2 {
            color: #2c3e50;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .modal-content label {
            font-weight: 500;
            color: #2c3e50;
            font-size: 14px;
        }

        .modal-content input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .modal-content input:focus {
            outline: none;
            border-color: #00c4b4;
        }

        .modal-content button {
            background-color: #00c4b4;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-content button:hover {
            background-color: #00a99d;
        }

        .disabled-btn {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #dfe6e9;
            color: #888;
            position: relative;
            pointer-events: none;
        }

        .disabled-btn:hover::after {
            content: "Only for Dean of this department";
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
            .header, .toolbar, .table-container {
                padding: 15px;
            }
            .toolbar {
                flex-direction: column;
                gap: 15px;
            }
            .toolbar-controls {
                flex-direction: column;
                width: 100%;
                gap: 15px;
            }
            .filter-section {
                flex-direction: column;
                align-items: flex-start;
            }
            .search-box {
                width: 100%;
            }
            .action-buttons {
                text-align: center;
            }
            .btn {
                width: 100%;
            }
            .action-icons {
                flex-direction: column;
                align-items: flex-start;
            }
            .action-icon {
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
    <!-- Edit Course Modal -->
    <div id="editCourseModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditCourseModal()">×</span>
            <h2>Edit Course</h2>
            <form action="courses.php?role=<?php echo $_GET['role']; ?>&department=<?php echo $_GET['department']; ?>&action=edit" method="POST">
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

    <!-- Add Course Modal -->
    <div id="addCourseModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeAddCourseModal()">×</span>
            <h2>Add New Course</h2>
            <form action="courses.php?role=<?php echo $_GET['role']; ?>&program_code=<?php echo $_GET['department']; ?>&action=add" method="POST">
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
        <div class="program-title"><?php echo htmlspecialchars($programCode); ?></div>
        <div class="program-subtitle"><?php echo htmlspecialchars($program['program_name']); ?></div>
        <div class="program-subtitle">College: <?php echo htmlspecialchars($program['college']); ?></div>
        <div class="action-buttons">
            <h5>Courses</h5>
            <?php if ($_GET['role'] == 'Dean' && $_GET['department'] === $_GET['program_code']) { ?>
                <button class="btn btn-primary" onclick="openAddCourseModal()">Add New Course</button>
            <?php } else { ?>
                <button class="btn btn-primary disabled-btn">Add New Course</button>
            <?php } ?>
        </div>
    </div>

    <div class="toolbar">
        <h3>Courses</h3>
        <div class="toolbar-controls">
            <div class="filter-section">
                <span class="filter-title">Semester:</span>
                <div class="filter-items" id="semesterFilter">
                    <?php
                    $semesters = ['First', 'Second'];
                    foreach ($semesters as $sem) {
                        $count = array_reduce($courses, function($carry, $course) use ($sem) {
                            return $carry + ($course['semester'] === $sem ? 1 : 0);
                        }, 0);
                        echo "<span class='filter-item' data-filter='semester' data-value='$sem'>$sem ($count)</span>";
                    }
                    ?>
                </div>
            </div>
            <div class="filter-section">
                <span class="filter-title">Year Level:</span>
                <div class="filter-items" id="yearFilter">
                    <?php
                    $years = [1, 2, 3, 4];
                    foreach ($years as $year) {
                        $count = array_reduce($courses, function($carry, $course) use ($year) {
                            return $carry + ($course['year_level'] === $year ? 1 : 0);
                        }, 0);
                        echo "<span class='filter-item' data-filter='year' data-value='$year'>$year ($count)</span>";
                    }
                    ?>
                </div>
            </div>
            <div class="search-container">
                <input type="text" placeholder="Search..." class="search-box">
            </div>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Course Code</th>
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
                                <?php if ($_GET['role'] == 'Dean' && $_GET['department'] === $course['program_code']) { ?>
                                    <a href="courses.php?delete_course_code=<?php echo urlencode($course['subject_code']); ?>&program_code=<?php echo urlencode($programCode); ?>&role=<?php echo $_GET['role']; ?>" class="action-icon delete-icon">🗑</a>
                                    <span class="action-icon edit-icon" onclick="openEditCourseModal('<?php echo htmlspecialchars(json_encode($course)); ?>')">✎</span>
                                <?php } else { ?>
                                    <span class="action-icon delete-icon disabled-btn">🗑</span>
                                    <span class="action-icon edit-icon disabled-btn">✎</span>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="../scripts.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.search-box');
        const tableRows = document.querySelectorAll('tbody tr');
        const filterItems = document.querySelectorAll('.filter-item');
        let activeFilters = {
            semester: null,
            year: null
        };

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterTable(searchTerm, activeFilters);
        });

        filterItems.forEach(item => {
            item.addEventListener('click', function() {
                const filterType = this.getAttribute('data-filter');
                const filterValue = this.getAttribute('data-value');

                if (activeFilters[filterType] === filterValue) {
                    activeFilters[filterType] = null;
                    this.classList.remove('active');
                } else {
                    document.querySelectorAll(`[data-filter="${filterType}"]`).forEach(el => {
                        el.classList.remove('active');
                    });
                    activeFilters[filterType] = filterValue;
                    this.classList.add('active');
                }

                filterTable(searchInput.value.toLowerCase(), activeFilters);
            });
        });

        function filterTable(searchTerm, filters) {
            tableRows.forEach(row => {
                const courseCode = row.cells[0].textContent.toLowerCase();
                const courseTitle = row.cells[1].textContent.toLowerCase();
                const semester = row.cells[4].textContent;
                const yearLevel = row.cells[3].textContent;

                const matchesSearch = courseCode.includes(searchTerm) || courseTitle.includes(searchTerm);
                const matchesSemester = !filters.semester || semester === filters.semester;
                const matchesYear = !filters.year || yearLevel === filters.year.toString();

                if (matchesSearch && matchesSemester && matchesYear) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        window.openAddCourseModal = function() {
            document.getElementById('addCourseModal').style.display = 'block';
        }

        window.closeAddCourseModal = function() {
            document.getElementById('addCourseModal').style.display = 'none';
        }

        window.openEditCourseModal = function(courseJson) {
            const course = JSON.parse(courseJson);
            document.getElementById('edit_course_id').value = course.course_id || '';
            document.getElementById('edit_subject_code').value = course.subject_code;
            document.getElementById('edit_course_title').value = course.course_title;
            document.getElementById('edit_year_level').value = course.year_level;
            document.getElementById('edit_semester').value = course.semester;
            document.getElementById('edit_lecture_hours').value = course.lecture_hours;
            document.getElementById('edit_lab_hours').value = course.lab_hours;
            document.getElementById('edit_credit_units').value = course.credit_units;
            document.getElementById('edit_slots').value = course.slots;
            document.getElementById('editCourseModal').style.display = 'block';
        }

        window.closeEditCourseModal = function() {
            document.getElementById('editCourseModal').style.display = 'none';
        }
    });
    </script>
</body>
</html>