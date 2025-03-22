<?php
include_once "../session/session.php";
include_once "../connections/connection.php";

$api_url = "http://localhost/registrar/sectionsAPI.php";
$response = file_get_contents($api_url);
$sections = json_decode($response, true);

if (!empty($sections['sections'])) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO sections (section_id, program_code, year_level, section_name, semester, start_time, end_time) 
            VALUES (:section_id, :program_code, :year_level, :section_name, :semester, :start_time, :end_time)
            ON DUPLICATE KEY UPDATE 
                program_code = VALUES(program_code),
                year_level = VALUES(year_level),
                section_name = VALUES(section_name),
                semester = VALUES(semester),
                start_time = VALUES(start_time),
                end_time = VALUES(end_time)
        ");

        foreach ($sections['sections'] as $section) {
            $stmt->execute([
                ':section_id' => $section['section_id'],
                ':program_code' => $section['program_code'],
                ':year_level' => $section['year_level'],
                ':section_name' => $section['section_name'],
                ':semester' => $section['semester'],
                ':start_time' => $section['start_time'],
                ':end_time' => $section['end_time'],
            ]);
        }

        // echo json_encode([
        //     "status" => "success",
        //     "message" => "Sync completed successfully",
        // ]);
    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "❌ Sync failed: " . $e->getMessage(),
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "❌ Failed to fetch data from API.",
    ]);
}
?>
