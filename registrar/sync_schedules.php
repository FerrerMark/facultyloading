<?php
include_once "../connections/connection.php";
$api_url = "http://localhost/registrar/scheduleAPI.php";
$response = file_get_contents($api_url);
$scheduleData = json_decode($response, true);

if ($scheduleData['status'] === "success") {
    try {
        $pdo->query("DELETE FROM section_schedules");
        $stmt = $pdo->prepare("INSERT INTO section_schedules 
            (schedule_id, section_id, subject_code, day_of_week, start_time, end_time, semester) 
            VALUES (:schedule_id, :section_id, :subject_code, :day_of_week, :start_time, :end_time, :semester)
        ");

        foreach ($scheduleData['data'] as $schedule) {
            $stmt->execute([
                ':schedule_id' => $schedule['schedule_id'],
                ':section_id' => $schedule['section_id'],
                ':subject_code' => $schedule['subject_code'],
                ':day_of_week' => $schedule['day_of_week'],
                ':start_time' => $schedule['start_time'],
                ':end_time' => $schedule['end_time'],
                ':semester' => $schedule['semester']
            ]);
        }
        echo "✅ Section schedules synced successfully!";
    } catch (PDOException $e) {
        echo "❌ Sync failed: " . $e->getMessage();
    }
} else {
    echo "❌ Failed to fetch data from API.";
}
?>

