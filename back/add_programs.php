<?php
session_start();
include_once("../connections/connection.php");

if (!$conn) {
    die("Connection failed: ");    
}


try {
    $sql = "SELECT * FROM programs";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}

$conn = null;
?>
