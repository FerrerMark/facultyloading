<?php
session_start();
include_once("./connections/connection.php");

if (!isset($_SESSION['id'])) {
    header("Location: /facultyloading/back/logout.php");
    exit(); 
}

$id = $_SESSION['id'];
$role = $_SESSION['role'];

try {
    $sql = "SELECT * FROM `faculty` WHERE `faculty_id` = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $_SESSION['role'] = $row['role']; // Sync session role with DB role if necessary
        $departmentId = $row['departmentID'];
    } else {
        header("Location: /facultyloading/back/logout.php");
        exit();
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
