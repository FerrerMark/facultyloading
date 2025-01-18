<?php

    session_start();
    if (!isset($_SESSION['role'])){
        header("Location: ../login.php");
        exit();
    }

    include_once("../connections/connection.php");

    $sql = "SELECT * FROM `faculty` WHERE `faculty_id` = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['id']]);
    $row = $stmt->fetch();


    $_SESSION['departmentID'] = $row['departmentID'];

?>