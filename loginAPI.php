<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

session_start();
include_once("connections/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        // $username = str_replace("@faculty", "", $username);

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
            // echo json_encode(['success' => true]);

        } else {
            echo "Invalid username or password";
        }
    }else{
        echo "missing username or password fields in the request ";
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit();
}
?>
