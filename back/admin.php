<?php
include_once "../session/session.php";
include_once "../connections/connection.php";

$query = "SELECT pa.id, f.firstname, f.lastname, pa.availability, pa.courses, pa.submitted_at, pa.status 
          FROM pending_availability pa 
          JOIN faculty f ON pa.faculty_id = f.faculty_id";
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Faculty Name</th>
            <th>Availability</th>
            <th>Courses</th>
            <th>Submitted At</th>
            <th>Status</th>
        </tr>";
foreach ($results as $row) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['firstname']} {$row['lastname']}</td>
            <td>" . ($row['availability'] ?: 'Full-Time') . "</td>
            <td>{$row['courses']}</td>
            <td>{$row['submitted_at']}</td>
            <td>{$row['status']}</td>
          </tr>";
}
echo "</table>";
?>