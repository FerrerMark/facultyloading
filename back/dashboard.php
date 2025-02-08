<?php
// Fetch JSON response
$response = file_get_contents('http://localhost/Hr/HRfacultyAPI.php');
$data = json_decode($response, true);

// Display the count
// echo $data['FacultyCount'];
?>
