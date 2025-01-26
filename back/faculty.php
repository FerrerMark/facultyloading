<?php
include_once "../connections/connection.php";

session_start();
$role = $_SESSION['role'];

$id = $_SESSION['id'];
$stmt = $pdo->prepare("SELECT departmentID FROM faculty where faculty_id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

$department = $stmt->fetchColumn();

if(!empty($department) && $role != 'instructor') {
    if (isset($_GET['action'])) {
        if (isset($_GET['action']) && $_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        
            // Sanitize and validate inputs
            $firstname = trim($_POST['firstname'] ?? '');
            $middlename = trim($_POST['middlename'] ?? '');
            $lastname = trim($_POST['lastname'] ?? '');
            $status = trim($_POST['status'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $phone_no = trim($_POST['phone_no'] ?? '');
            $departmentID = trim($_POST['department']);
            $role = trim($_POST['role'] ?? '');
            $master_specialization = trim($_POST['master_specialization'] ?? '');
            $college = !empty($_POST['college']) ? $_POST['college'] : NULL;
        
            try {
                // SQL Insert Query (Removed `subject` since it doesn't exist)
                $sql = "INSERT INTO faculty (
                            firstname, 
                            middlename, 
                            lastname, 
                            employment_status, 
                            address, 
                            phone_no, 
                            departmentID, 
                            role,
                            master_specialization,
                            college
                        ) VALUES (
                            :firstname,
                            :middlename,
                            :lastname,
                            :status,
                            :address,
                            :phone_no, 
                            :departmentID,
                            :role,
                            :master_specialization,
                            :college
                        )";
        
                // Prepare and execute the statement
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':middlename', $middlename);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':phone_no', $phone_no);
                $stmt->bindParam(':departmentID', $departmentID);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':master_specialization', $master_specialization);
                $stmt->bindParam(':college', $college, PDO::PARAM_STR); 

                if ($stmt->execute()) {
                    
                    header("Location: ../frame/faculty.php?department=" . urlencode($departmentID) . "&success=Faculty added successfully");
                    exit();
                } else {
                    throw new Exception("Failed to execute SQL query.");
                }
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                header("Location: ../frame/faculty.php?error=Database error, please try again.");
                exit();
            } catch (Exception $e) {
                header("Location: ../frame/faculty.php?error=" . urlencode($e->getMessage()));
                exit();
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
            $role = $_POST['role'];
            $master_specialization = $_POST['master_specialization'];
        
            try {
                $sql = "UPDATE faculty SET 
                            firstname = :firstname, 
                            middlename = :middlename, 
                            lastname = :lastname, 
                            employment_status = :status,
                            address = :address, 
                            phone_no = :phone_no, 
                            role = :role,
                            master_specialization = :master_specialization
                        WHERE faculty_id = :id";
                        
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':middlename', $middlename);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':status', $employment_status);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':phone_no', $phone_no);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':master_specialization', $master_specialization);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
        
                // Redirect with department ID if available
                header("Location: ../frame/faculty.php?success=Faculty updated successfully");
                exit;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }else if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
            // Sanitize ID and Department
            $id = intval($_GET['id']);
            $department = htmlspecialchars($_GET['department']);
        
            // Confirmation before deletion
            if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'yes') {
                try {
                    // SQL Query to delete faculty
                    $sql = "DELETE FROM faculty WHERE faculty_id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
        
                    // Redirect after successful deletion
                    header("Location: ../frame/faculty.php?department=" . urlencode($department) . "&success=Faculty deleted successfully");
                    exit(); 
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                // Show a confirmation page before deletion
                echo "<form method='POST'>
                        <p>Are you sure you want to delete this faculty?</p>
                        <button type='submit' name='confirm_delete' value='yes'>Yes, Delete</button>
                        <button type='button' onclick='window.history.back();'>Cancel</button>
                      </form>";
            }
        }
        
    }

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
    }else{
    echo "hahaha";
    if($department == null){
        echo "no department";
    }
    exit();
}

}