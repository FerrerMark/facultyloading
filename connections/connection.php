<?php

$host = "localhost";
$dbname = "facultyloading";
$dbusername = "root";
$dbpass = "";

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn = $pdo;

} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();
    exit();
}

?>