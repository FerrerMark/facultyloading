<?php
session_start();
include_once "../connections/connection.php"; // Include database connection

// Fetch all faculties for the dropdown
$stmt = $conn->prepare("SELECT * FROM faculty");
$stmt->execute();
$faculties = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['faculty_id'])) {
    $faculty_id = $_POST['faculty_id'];

    // Generate schedule logic
    try {
        // Fetch subjects and their assigned time slots for the selected faculty
        $stmt = $conn->prepare("SELECT * FROM subjects WHERE faculty_id = :faculty_id");
        $stmt->bindParam(':faculty_id', $faculty_id);
        $stmt->execute();
        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Example of generating a schedule (this should be customized based on your logic)
        $schedule = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $time_slots = ['8:00-9:00', '9:00-10:00', '10:00-11:00', '11:00-12:00'];

        foreach ($days as $day) {
            foreach ($time_slots as $time_slot) {
                // Randomly assign subjects to time slots (customize this logic as needed)
                $subject = $subjects[array_rand($subjects)]['subject_name'] ?? 'Free';
                $room = 'Room ' . rand(101, 105); // Random room number for demonstration
                $schedule[] = [
                    'day' => $day,
                    'time_slot' => $time_slot,
                    'subject' => $subject,
                    'room' => $room
                ];
            }
        }
    } catch (PDOException $e) {
        echo "Error generating schedule: " . $e->getMessage();
    }
}
?>