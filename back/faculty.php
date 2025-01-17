<?php
include_once "../connections/connection.php";

// Handle actions
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Add new faculty
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $position = $_POST['position'];
        $college = $_POST['college'];
        $status = $_POST['status'];

        try {
            $sql = "INSERT INTO teachers (firstname, middlename, lastname, position, college, employment_status) 
                    VALUES (:firstname, :middlename, :lastname, :position, :college, :status)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':middlename', $middlename);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':position', $position);
            $stmt->bindParam(':college', $college);
            $stmt->bindParam(':status', $status);
            $stmt->execute();

            header("Location: ../frame/faculty.php?message=Faculty added successfully.");
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else if($_GET['action'] === 'edit' && isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Edit faculty
        $id = $_GET['id'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $position = $_POST['position'];
        $college = $_POST['college'];
        $status = $_POST['status'];

        try {
            $sql = "UPDATE teachers SET firstname = :firstname, middlename = :middlename, lastname = :lastname, 
                    position = :position, college = :college, employment_status = :status WHERE account_number = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':middlename', $middlename);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':position', $position);
            $stmt->bindParam(':college', $college);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: ../frame/faculty.php?message=Faculty updated successfully.");
            echo "success";
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    } else if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
        // Delete faculty
        $id = $_GET['id'];
        try {
            $sql = "DELETE FROM teachers WHERE account_number = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: ../frame/faculty.php?message=Faculty deleted successfully.");
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Fetch faculty list
try {
    $sql = "SELECT * FROM teachers";
    $stmt = $conn->query($sql);
    $facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching faculty list: " . $e->getMessage();
}

$selectedFaculty = null;
if (isset($_GET['id'])) {
    try {
        $id = $_GET['id'];
        $sql = "SELECT * FROM teachers WHERE account_number = :id"; 
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $selectedFaculty = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching faculty: " . $e->getMessage();
    }
}

$conn = null;
?>
