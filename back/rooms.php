<?php

    include_once "../connections/connection.php";

    $role = "department head";
    $dep = $_GET['department'];

if($_SERVER['REQUEST_METHOD'] === 'POST' || $role === 'department head') {
    
    if(isset($_GET['action'])){

        $action = $_GET['action'];
        // $action = "edit";

        if($action === "add"){
            $building = $_POST['building'];
            $room_no = $_POST['room_no'];
            $room_type = $_POST['room_type'];
            $capacity = $_POST['capacity'];
            $section = $_POST['section']; // Capture section

            $stmt = $conn->prepare("SELECT year_level FROM sections WHERE year_section = :section");
            $stmt->bindParam(':section', $section, PDO::PARAM_STR);
            $stmt->execute();
            $year_level = $stmt->fetchColumn();


            // Insert the room data, including the section
            $stmt = $conn->prepare("INSERT INTO rooms (building, room_no, room_type, capacity, section, year_level) VALUES (:building, :room_no, :room_type, :capacity, :section, :year_level)");
            $stmt->bindParam(':building', $building, PDO::PARAM_STR);
            $stmt->bindParam(':room_no', $room_no, PDO::PARAM_STR);
            $stmt->bindParam(':room_type', $room_type, PDO::PARAM_STR);
            $stmt->bindParam(':capacity', $capacity, PDO::PARAM_STR);
            $stmt->bindParam(':section', $section, PDO::PARAM_STR); // Bind section
            $stmt->bindParam(':year_level', $year_level, PDO::PARAM_STR); // Bind year level
            $stmt->execute();

            header("location: ../frame/rooms.php?department=$dep");
            exit;
        }else if($action === "delete"){

            $building = $_GET['building'];
            $room_no = $_GET['room'];

            $sql = "DELETE FROM rooms WHERE building = :building AND room_no = :room_no";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':building', $building, PDO::PARAM_STR);
            $stmt->bindParam(':room_no', $room_no, PDO::PARAM_STR);
            $stmt->execute();

            header("location: ../frame/rooms.php?role=department head&department=$dep");    
            exit;

            echo "triggered";

        }else if ($action === "edit") {
            if (isset($_GET['building'], $_GET['room']) && isset($_POST['building'], $_POST['room_no'], $_POST['room_type'], $_POST['section'])) {
        
                $original_building = $_GET['building'];
                $original_room = $_GET['room'];
        
                $new_building = $_POST['building'];
                $new_room = $_POST['room_no'];
                $room_type = $_POST['room_type'];
                $section = $_POST['section']; // Capture section
        
                try {
                    $sql = "UPDATE rooms 
                            SET building = :new_building, room_no = :new_room, room_type = :room_type, section = :section
                            WHERE building = :original_building AND room_no = :original_room";
        
                    $stmt = $pdo->prepare($sql);
        
                    $stmt->bindParam(':new_building', $new_building, PDO::PARAM_STR);
                    $stmt->bindParam(':new_room', $new_room, PDO::PARAM_STR);
                    $stmt->bindParam(':room_type', $room_type, PDO::PARAM_STR);
                    $stmt->bindParam(':section', $section, PDO::PARAM_STR); // Bind section
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