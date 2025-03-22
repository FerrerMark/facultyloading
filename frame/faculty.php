<?php
include_once("../back/faculty.php");


try {

    $department = isset($_GET['department']) ? $_GET['department'] : 'BSIT';
    $stmt = $pdo->prepare("
        SELECT f.*, GROUP_CONCAT(fc.subject_code) as subjects
        FROM faculty f
        LEFT JOIN faculty_courses fc ON f.faculty_id = fc.faculty_id
        WHERE f.departmentID = :department
        GROUP BY f.faculty_id
    ");
    $stmt->execute(['department' => $department]);
    $facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $facultyList = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management</title>
    <link rel="stylesheet" href="../css/faculty.css">
</head>
<body>
    <!-- Edit Faculty Modal (unchanged) -->
    <div id="editFacultyModal" class="modal" style="display: <?php echo isset($selectedFaculty) ? 'block' : 'none'; ?>;">
        <div class="modal-content">
            <span class="close" onclick="window.location.href='faculty.php?department=<?php echo $_GET['department']?>'">×</span>
            <div class="modal-header">
                <h2>Edit Faculty Attachment</h2>
            </div>
            <div class="modal-body">
                
                <h4><?php echo isset($selectedFaculty) ? $selectedFaculty['firstname'] . ' ' . $selectedFaculty['lastname'] : ''; ?></h4>

                <form id="newFacultyForm" action="../back/faculty.php?action=edit&id=<?php echo isset($selectedFaculty) ? $selectedFaculty['faculty_id'] : ''; ?>" method="post" enctype="multipart/form-data">
                    <!-- Your form fields remain unchanged -->
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><?php echo htmlspecialchars($department); ?> Faculty</h1>  
        </div>
        
        <div class="toolbar">
            <div class="toolbar-buttons">
                <h6>Faculty List</h6>
            </div>
            <div class="search-container">
                <input type="text" placeholder="Search: Last Name" class="search-box" id="searchInput">
                <button class="search-btn" onclick="searchFaculty()">Search</button>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>College</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Department ID</th>
                    <th>Subject</th>
                    <th>Role</th>
                    <th>Master Specialization</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facultyList as $faculty): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($faculty['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['middlename'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars($faculty['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['college']); ?></td>
                        <td><span class="status-badge <?php echo strtolower($faculty['employment_status']); ?>-time"><?php echo htmlspecialchars($faculty['employment_status']); ?></span></td>
                        <td><?php echo htmlspecialchars($faculty['address']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['phone_no']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['departmentID']); ?></td>
                        <td><?php echo htmlspecialchars($faculty['subjects'] ?: 'None'); ?></td>
                        <td><span class="position-badge"><?php echo htmlspecialchars($faculty['role']); ?></span></td>
                        <td><?php echo htmlspecialchars($faculty['master_specialization']); ?></td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn" onclick="window.location.href='faculty.php?department=<?php echo $department; ?>&id=<?php echo $faculty['faculty_id']; ?>'">Edit</button>
                                <button class="schedule-btn" onclick="viewSchedule(<?php echo $faculty['faculty_id']; ?>)">View Schedule</button>
                                <button class="schedule-btn" onclick="assignSchedule(<?php echo $faculty['faculty_id']; ?>)">Assign Schedule</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($facultyList)): ?>
                    <tr>
                        <td colspan="14" style="text-align: center;">No faculty found for this department.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div id="pagination" style="text-align: center; margin-top: 20px;"></div>
    </div>

    <script>
        function searchFaculty() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const lastName = row.cells[3].textContent.toLowerCase();
                row.style.display = lastName.includes(searchValue) ? '' : 'none';
            });
        }

        function viewSchedule(facultyId) {
            window.location.href = "../frame/info.php?id=" + facultyId;
        }

        async function assignSchedule(facultyId) {
            try {
                let response = await fetch("../back/assign_schedule.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ faculty_id: facultyId }), 
                });

                let result = await response.json();
                if (result.success) {
                    alert("Schedule assigned successfully!");
                    location.reload();
                } else {
                    alert("Failed to assign schedule: " + (result.message || "Unknown error"));
                }
            } catch (error) {
                console.error("Error assigning schedule:", error);
                alert("An error occurred while assigning the schedule. Please try again.");
            }
        }
    </script>
</body>
</html>