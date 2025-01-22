<?php

    session_start();
    include_once("./connections/connection.php");
    
    $id = $_SESSION['id'];
    $role = $_SESSION['role'];
    if(!isset($id)){
        header("location: /facultyloading/back/logout.php");
    }

    $sql = "SELECT * FROM `faculty` WHERE `faculty_id` = ?";
    $stmt = $pdo->prepare($sql);    
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    $role = $row['role'];
    $departmentId = $row['departmentID'];


?>