<?php
session_start();
include_once("./connections/connection.php");

if (isset($_SESSION['id'])) {
    if ($_SESSION['role'] === 'department head') {
        header("Location: ../facultyloading/index.php");
    } elseif ($_SESSION['role'] === 'faculty') {
        header("Location: ../faculty/index.php");
    }
}

if (isset($_POST['submit'])) {
    $username = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `users` WHERE username = ? AND password = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $password]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        $id = $row['faculty_id'];
        $role = $row['role']; 
        $_SESSION['id'] = $id;
        $_SESSION['role'] = $role;


        header("Location: /facultyloading/index.php");

        // if ($role === 'department head') {
        //     header("Location: ../faculty/head/headDashboard.php");
        // } elseif ($role === 'faculty') {
        //     header("Location: ../faculty/index.php");
        // } else {
        //     echo "Unknown role. Please contact the administrator.";
        // }
    } else {
        echo "Invalid username or password";
    }
}

?>
