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

    $course_query = "SELECT subject_code, course_title, semester, year_level FROM courses WHERE program_code = 'BSIT'";
    $stmt = $conn->prepare($course_query);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
            .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
            .courses-list { display: flex; flex-wrap: wrap; gap: 8px; }
            .course-item { padding: 6px 12px; background: #f0f0f0; border-radius: 5px; transition: background 0.3s ease; }
            .course-item input[type="checkbox"]:checked + label { color: white; }
            .course-item input[type="checkbox"]:checked ~ div { background: #28a745; }
            .courses-list label { padding: 6px 12px; cursor: pointer; display: block; }
            .courses-list input[type="checkbox"] { display: none; }
            button { background: #7b8289; color: white; padding: 10px; border: none; border-radius: 5px; width: 100%; cursor: pointer; }
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
            .notification { background: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px; }
            .toolbar { background: #34495e; padding: 15px; border-radius: 6px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
            .toolbar h3 { color: white; font-size: 16px; font-weight: 500; }
            .toolbar-controls { display: flex; align-items: center; gap: 20px; }
            .filter-section { display: flex; align-items: center; gap: 10px; }
            .filter-title { color: white; font-weight: 500; font-size: 14px; }
            .filter-items { display: flex; gap: 10px; }
            .filter-item { background-color: #e9ecef; padding: 5px 10px; border-radius: 15px; cursor: pointer; transition: all 0.3s ease; font-size: 13px; }
            .filter-item:hover { background-color: #00c4b4; color: white; }
            .filter-item.active { background-color: #00c4b4; color: white; }
            .search-container { display: flex; align-items: center; gap: 10px; }
            .search-box { padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; width: 220px; font-size: 14px; transition: border-color 0.3s ease; }
            .search-box:focus { outline: none; border-color: #00c4b4; }
            h1{ color:#2c3e50; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Set Your Availability</h1>
            <?php if ($message): ?>
                <div class="notification">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            <div class="toolbar">
                <h3>Filter Courses</h3>
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
            <form action="../back/availability.php" method="POST">
                <fieldset>
                    <legend>Select Courses You Want to Teach:</legend>
                    <div class="courses-list" id="coursesList">
                        <?php
                        $assigned_subject_codes = array_column($assigned_courses, 'subject_code');
                        foreach ($courses as $course) {
                            $checked = in_array($course['subject_code'], $assigned_subject_codes) ? 'checked' : '';
                            echo "<div class='course-item' data-semester='{$course['semester']}' data-year='{$course['year_level']}'>";
                            echo "<input type='checkbox' name='courses[]' value='{$course['subject_code']}' id='course_{$course['subject_code']}' $checked>";
                            echo "<label for='course_{$course['subject_code']}'>{$course['course_title']}</label>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </fieldset>
                <button type="submit">Submit</button>
            </form>
        </div>

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
                            <form action="../back/request_delete.php" method="POST" style="display:inline;">
                                <input type="hidden" name="subject_code" value="<?php echo htmlspecialchars($course['subject_code']); ?>">
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to request deletion of <?php echo htmlspecialchars($course['course_title']); ?>? This will require Department Head approval.');">Request Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p class="no-data">No current courses assigned.</p>
        <?php endif; ?>

        <h4>My Pending Deletion Requests</h4>
        <?php
        $pending_query = "SELECT pd.pending_id, c.course_title 
                        FROM pending_deletions pd 
                        JOIN courses c ON pd.subject_code = c.subject_code 
                        WHERE pd.faculty_id = :faculty_id AND pd.status = 'Pending'";
        $stmt = $conn->prepare($pending_query);
        $stmt->bindParam(':faculty_id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
        $pending_deletions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php if (!empty($pending_deletions)): ?>
            <table>
                <tr>
                    <th>Course Title</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($pending_deletions as $deletion): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($deletion['course_title']); ?></td>
                        <td>
                            <form action="../back/cancel_delete.php" method="POST" style="display:inline;">
                                <input type="hidden" name="pending_id" value="<?php echo htmlspecialchars($deletion['pending_id']); ?>">
                                <button type="submit" class="cancel-btn" onclick="return confirm('Are you sure you want to cancel the deletion request for <?php echo htmlspecialchars($deletion['course_title']); ?>?');">Cancel Request</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No pending deletion requests.</p>
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
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-box');
            const courseItems = document.querySelectorAll('.course-item');
            const filterItems = document.querySelectorAll('.filter-item');
            let activeFilters = {
                semester: null,
                year: null
            };

            courseItems.forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    item.style.background = '#28a745';
                    item.querySelector('label').style.color = 'white';
                }
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        item.style.background = '#28a745';
                        item.querySelector('label').style.color = 'white';
                    } else {
                        item.style.background = '#f0f0f0';
                        item.querySelector('label').style.color = ''; // Reset to default
                    }
                });
            });

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                filterCourses(searchTerm, activeFilters);
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

                    filterCourses(searchInput.value.toLowerCase(), activeFilters);
                });
            });

            function filterCourses(searchTerm, filters) {
                courseItems.forEach(item => {
                    const courseTitle = item.querySelector('label').textContent.toLowerCase();
                    const semester = item.getAttribute('data-semester');
                    const yearLevel = item.getAttribute('data-year');

                    const matchesSearch = courseTitle.includes(searchTerm);
                    const matchesSemester = !filters.semester || semester === filters.semester;
                    const matchesYear = !filters.year || yearLevel === filters.year.toString();

                    if (matchesSearch && matchesSemester && matchesYear) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        });
        </script>
    </body>
    </html>