<?php
include_once("./session/session.php");
include_once("./connections/connection.php");



if (isset($_SESSION['id'])) {
    if ($_SESSION['role'] === 'Department Head') {
        header("Location: ../facultyloading/index.php");
    } elseif ($_SESSION['role'] === 'Instructor') {
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

        echo $department = $row['department'];

        $_SESSION['id'] = $id;
        $_SESSION['role'] = $role;
        $_SESSION['department'] = $department;

        header("Location: /index.php");

       
    } else {
        echo "Invalid username or password";
    }
}else{
    echo "Invalid username or password";
}

?>
