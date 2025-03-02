<?php
include_once "../session/session.php";
$url = 'http://localhost/registrar/sectionsApi.php';
$response = json_decode(file_get_contents($url), true);

$data = $response;

// echo json_encode($data);
// echo json_encode($response['faculty_count']);


?>