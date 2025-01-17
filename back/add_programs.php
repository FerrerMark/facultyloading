<?php
session_start();
include_once("../connections/connection.php");

if (!$conn) {
    die("Connection failed: ");    
}

// adding a program
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $programCode = $_POST['programCode'] ?? '';
    $program = $_POST['program'] ?? '';
    $college = $_POST['college'] ?? '';

    if (!empty($programCode) && !empty($program) && !empty($college)) {
        try {
            $sql = "INSERT INTO programs (program_code, program_name, college) 
                    VALUES (:programCode, :program, :college)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':programCode', $programCode);
            $stmt->bindParam(':program', $program);
            $stmt->bindParam(':college', $college);

            if ($stmt->execute()) {
                $_SESSION['message'] = "New program added successfully.";
            } else {
                $_SESSION['error'] = "Error: Could not execute the query.";
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "All fields are required.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
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
