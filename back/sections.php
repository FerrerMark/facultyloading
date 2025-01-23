<?php

include_once "../connections/connection.php";

$dep = isset($_GET['department']) ? htmlspecialchars($_GET['department']) : '';
$role = isset($_GET['role']) ? htmlspecialchars($_GET['role']) : '';

try {
    $stmt = $pdo->prepare("
        SELECT * FROM sections
        WHERE program_code = :department
        ORDER BY id DESC
    ");
    $stmt->bindParam(':department', $dep);
    $stmt->execute();
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $sections = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_section') {
    $program_code = htmlspecialchars(trim($_POST['program_code']));
    $year_section = htmlspecialchars(trim($_POST['year_section']));
    $year_level = filter_var($_POST['year_level'], FILTER_VALIDATE_INT);

    $orig_section = $program_code . "" . $year_section;

    if (empty($program_code) || empty($year_section) || !$year_level) {
        header("Location: ../frame/sections.php?role=$role&department=$dep&error=invalid_input");
        exit();
    }

    try {
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM sections WHERE program_code = :program_code AND year_section = :year_section");
        $checkStmt->bindParam(':program_code', $program_code);
        $checkStmt->bindParam(':year_section', $year_section);
        $checkStmt->execute();
        $existingCount = $checkStmt->fetchColumn();

        if ($existingCount > 0) {
            header("Location: ../frame/sections.php?role=$role&department=$dep&error=duplicate_section");
            exit();
        }

        $stmt = $pdo->prepare("INSERT INTO sections (program_code, year_section, year_level) VALUES (:program_code, :year_section, :year_level)");
        $stmt->bindParam(':program_code', $program_code);
        $stmt->bindParam(':year_section', $orig_section);
        $stmt->bindParam(':year_level', $year_level, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ../frame/sections.php?role=$role&department=$dep&success=1");
        exit();
    } catch (PDOException $e) {
        error_log("Database Insert Error: " . $e->getMessage());
        die("Error inserting section: " . $e->getMessage());
    }
}


