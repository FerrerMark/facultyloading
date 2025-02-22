<?php

    include_once "../connections/connection.php";

    $role = "Department Head";
    $dep = $_GET['department'];

if($_SERVER['REQUEST_METHOD'] === 'POST' || $role === 'Department Head') {
    
    if(isset($_GET['action'])){

        $action = $_GET['action'];
        // $action = "edit";

        if ($action === "add") {
            $building = $_POST['building'];
            $room_no = $_POST['room_no'];
            $room_type = $_POST['room_type'];
            $capacity = $_POST['capacity'];
        
            try {
                // Insert the room data (excluding section)
                $stmt = $conn->prepare("
                    INSERT INTO rooms (building, room_no, room_type, capacity) 
                    VALUES (:building, :room_no, :room_type, :capacity)
                ");
                $stmt->bindParam(':building', $building, PDO::PARAM_STR);
                $stmt->bindParam(':room_no', $room_no, PDO::PARAM_STR);
                $stmt->bindParam(':room_type', $room_type, PDO::PARAM_STR);
                $stmt->bindParam(':capacity', $capacity, PDO::PARAM_INT);
                $stmt->execute();
        
                // Redirect to rooms page with department parameter
                header("Location: ../frame/rooms.php?department=$dep");
                exit;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }else if($action === "delete"){

            $building = $_GET['building'];
            $room_no = $_GET['room'];

            $sql = "DELETE FROM rooms WHERE building = :building AND room_no = :room_no";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':building', $building, PDO::PARAM_STR);
            $stmt->bindParam(':room_no', $room_no, PDO::PARAM_STR);
            $stmt->execute();

            header("location: ../frame/rooms.php?role=Department Head&department=$dep");    
            exit;

            echo "triggered";

        }else if ($action === "edit") {
            if (isset($_GET['building'], $_GET['room']) && isset($_POST['building'], $_POST['room_no'], $_POST['room_type'], $_POST['capacity'])) {
        
                $original_building = $_GET['building'];
                $original_room = $_GET['room'];
        
                $new_building = $_POST['building'];
                $new_room = $_POST['room_no'];
                $room_type = $_POST['room_type'];
                $capacity = $_POST['capacity']; // Use capacity instead of section
        
                try {
                    $sql = "UPDATE rooms 
                            SET building = :new_building, room_no = :new_room, room_type = :room_type, capacity = :capacity
                            WHERE building = :original_building AND room_no = :original_room";
        
                    $stmt = $pdo->prepare($sql);
        
                    $stmt->bindParam(':new_building', $new_building, PDO::PARAM_STR);
                    $stmt->bindParam(':new_room', $new_room, PDO::PARAM_STR);
                    $stmt->bindParam(':room_type', $room_type, PDO::PARAM_STR);
                    $stmt->bindParam(':capacity', $capacity, PDO::PARAM_INT); // Updated binding to match column
                    $stmt->bindParam(':original_building', $original_building, PDO::PARAM_STR);
                    $stmt->bindParam(':original_room', $original_room, PDO::PARAM_STR);
        
                    $stmt->execute();
        
                    if ($stmt->rowCount() > 0) {
                        header("location: ../frame/rooms.php?department=$dep");
                    } else {
                        echo "No changes made or record not found.";
                    }
                } catch (PDOException $e) {
                    echo "Error updating room: " . $e->getMessage();
                }
            } else {
                echo "Missing required parameters.";
            }
            exit;
        }
        
    }
}else{
    echo "nothing";
}

    $stmt = $conn->prepare("SELECT * FROM rooms");
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);



    $selectedRoomAndBuilding = null;
    if (isset($_GET['action'])) {

        $action = $_GET['action'];

        if($action === "select"){

            $room = $_GET['room_no'];
            $building = $_GET['building'];

            try {

                $sql = "SELECT * FROM rooms WHERE building = :building AND room_no = :room_no"; 
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':building', $building, PDO::PARAM_INT);
                $stmt->bindParam(':room_no', $room, PDO::PARAM_INT);
                $stmt->execute();
                $selectedRoomAndBuilding = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Error fetching faculty: " . $e->getMessage();
            }
        }

    }

?>