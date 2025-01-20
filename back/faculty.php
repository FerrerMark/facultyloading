<?php
include_once "../connections/connection.php";

session_start();
$role = $_SESSION['role'];
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'department head') {
//     header("Location: ../login.php"); // Redirect to login if not logged in
//     exit();
// }

// Handle actions
$department = $_GET['department'];

if(!empty($department) && $role !== 'faculty') {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {

            $departmentID = $_GET['department'];
            
            $firstname = trim($_POST['firstname']);
            $middlename = trim($_POST['middlename']);
            $lastname = trim($_POST['lastname']);
            $position = trim($_POST['position']);
            $college = "null";
            $status = trim($_POST['status']);
            $address = trim($_POST['address']);
            $phone_no = trim($_POST['phone_no']);
            $department = $department;
            $department_title = "null";
            $subject = trim($_POST['subject']);
            $role = trim($_POST['role']);
        
            try {
                $sql = "INSERT INTO faculty (firstname, 
                                            middlename, 
                                            lastname, 
                                            college, 
                                            employment_status, 
                                            address, 
                                            phone_no, 
                                            departmentID, 
                                            department_title, 
                                            subject, 
                                            role) 
                        VALUES (:firstname,
                                            :middlename,
                                            :lastname,
                                            :college, 
                                            :status,
                                            :address,
                                            :phone_no, 
                                            :department,
                                            :department_title,
                                            :subject,
                                            :role)";
                
                $stmt = $conn->prepare($sql);
                
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':middlename', $middlename);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':college', $college);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':phone_no', $phone_no);
                $stmt->bindParam(':department', $department);
                $stmt->bindParam(':department_title', $department_title);
                $stmt->bindParam(':subject', $subject);
                $stmt->bindParam(':role', $role);
                
                $stmt->execute();
        
                header("Location: ../frame/faculty.php?department=" . urlencode($departmentID));
                exit(); 

                
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                header("Location: ../frame/faculty.php?error=Failed to add faculty.");
                exit;
            }
        }else if($_GET['action'] === 'edit' && isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Edit faculty
            $id = $_GET['id'];
            $firstname = $_POST['firstname'];
            $middlename = $_POST['middlename'];
            $lastname = $_POST['lastname'];
            $employment_status = $_POST['status'];
            $address = $_POST['address'];
            $phone_no = $_POST['phone_no'];
            $subject = $_POST['subject'];
            $role = $_POST['role'];
            try {
                $sql = "UPDATE faculty SET 
                            firstname = :firstname, 
                            middlename = :middlename, 
                            lastname = :lastname, 
                            employment_status = :status,
                            address = :address, 
                            phone_no = :phone_no, 
                            subject = :subject,
                            role = :role 
                        WHERE faculty_id = :id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':firstname', $firstname);
                            $stmt->bindParam(':middlename', $middlename);
                            $stmt->bindParam(':lastname', $lastname);
                            $stmt->bindParam(':status', $employment_status);
                            $stmt->bindParam(':address', $address);
                            $stmt->bindParam(':phone_no', $phone_no);
                            $stmt->bindParam(':subject', $subject);
                            $stmt->bindParam(':role', $role);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->execute();

                header("Location: ../frame/faculty.php?department=$department&role=$role");
                exit;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

        } else if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
            // Delete faculty
            $id = $_GET['id'];
            $department = $_GET['department'];
            try {
                $sql = "DELETE FROM faculty WHERE faculty_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                header("Location: ../frame/faculty.php?department=" . urlencode($department));
                exit(); 

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    // Fetch faculty list
    $department = $_GET['department'];
    if(!empty($department) && isset($department)) {
        try {
            $sql = "SELECT * FROM faculty where departmentID = '$department'";
            $stmt = $conn->query($sql);
            $facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching faculty list: " . $e->getMessage();
        }

        $selectedFaculty = null;
        if (isset($_GET['id'])) {
                try {
                    
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM faculty WHERE faculty_id = :id"; 
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();

                    $selectedFaculty = $stmt->fetch(PDO::FETCH_ASSOC); 
                
                } catch (PDOException $e) {
                    echo "Error fetching faculty: " . $e->getMessage();
                }
        }

    $conn = null;
}

}else{
    // header("Location: ../back/logout.php");
    echo "home";
    exit();
}



?>
