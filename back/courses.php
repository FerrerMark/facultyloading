<?php
session_start();
include_once "../connections/connection.php";

// Retrieve program code from GET or POST
$programCode = $_GET['program_code'] ?? $_POST['program_code'] ?? null;

if (!$programCode) {
    // Redirect if no program code is provided
    header("Location: programs.php?error=No program code provided");
    exit;
}

try {
    // Fetch program details
    $stmt = $conn->prepare("SELECT program_name, college FROM programs WHERE program_code = :program_code");
    $stmt->bindParam(':program_code', $programCode, PDO::PARAM_STR);
    $stmt->execute();
    $program = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$program) {
        die("Program not found.");
    }

    // Fetch courses associated with the program
    $stmt = $conn->prepare("SELECT * FROM courses WHERE program_code = :program_code");
    $stmt->bindParam(':program_code', $programCode, PDO::PARAM_STR);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle form submission for adding a new course
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $subjectCode = $_POST['subject_code'];
        $courseTitle = $_POST['course_title'];
        $yearLevel = $_POST['year_level'];
        $semester = $_POST['semester'];
        $lectureHours = $_POST['lecture_hours'];
        $labHours = $_POST['lab_hours'];
        $creditUnits = $_POST['credit_units'];
        $slots = $_POST['slots'];

        $stmt = $conn->prepare("
            INSERT INTO courses (program_code, subject_code, course_title, year_level, semester, lecture_hours, lab_hours, credit_units, slots)
            VALUES (:program_code, :subject_code, :course_title, :year_level, :semester, :lecture_hours, :lab_hours, :credit_units, :slots)
        ");
        $stmt->bindParam(':program_code', $programCode);
        $stmt->bindParam(':subject_code', $subjectCode);
        $stmt->bindParam(':course_title', $courseTitle);
        $stmt->bindParam(':year_level', $yearLevel, PDO::PARAM_INT);
        $stmt->bindParam(':semester', $semester);
        $stmt->bindParam(':lecture_hours', $lectureHours, PDO::PARAM_INT);
        $stmt->bindParam(':lab_hours', $labHours, PDO::PARAM_INT);
        $stmt->bindParam(':credit_units', $creditUnits, PDO::PARAM_INT);
        $stmt->bindParam(':slots', $slots, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the courses page with a success message
        header("Location: courses.php?program_code=" . urlencode($programCode) . "&success=Course added successfully");
        exit;
    }

    // Handle deletion of a course
    if (isset($_GET['delete_course_code'])) {
        $courseCodeToDelete = $_GET['delete_course_code'];

        // Prepare delete query
        $stmt = $conn->prepare("DELETE FROM courses WHERE subject_code = :subject_code AND program_code = :program_code");
        $stmt->bindParam(':subject_code', $courseCodeToDelete, PDO::PARAM_STR);
        $stmt->bindParam(':program_code', $programCode, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect after deletion
        header("Location: courses.php?program_code=" . urlencode($programCode) . "&success=Course deleted successfully");
        exit;
    }

    // Handle form submission for adding a new course or updating if it exists
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $programCode = $_POST['program_code'];
    $subjectCode = $_POST['subject_code'];
    $courseTitle = $_POST['course_title'];
    $yearLevel = $_POST['year_level'];
    $semester = $_POST['semester'];
    $lectureHours = $_POST['lecture_hours'];
    $labHours = $_POST['lab_hours'];
    $creditUnits = $_POST['credit_units'];
    $slots = $_POST['slots'];

    $stmt = $conn->prepare("
        INSERT INTO courses (program_code, subject_code, course_title, year_level, semester, lecture_hours, lab_hours, credit_units, slots)
        VALUES (:program_code, :subject_code, :course_title, :year_level, :semester, :lecture_hours, :lab_hours, :credit_units, :slots)
        ON DUPLICATE KEY UPDATE
        course_title = VALUES(course_title),
        year_level = VALUES(year_level),
        semester = VALUES(semester),
        lecture_hours = VALUES(lecture_hours),
        lab_hours = VALUES(lab_hours),
        credit_units = VALUES(credit_units),
        slots = VALUES(slots)
    ");
    $stmt->bindParam(':program_code', $programCode);
    $stmt->bindParam(':subject_code', $subjectCode);
    $stmt->bindParam(':course_title', $courseTitle);
    $stmt->bindParam(':year_level', $yearLevel, PDO::PARAM_INT);
    $stmt->bindParam(':semester', $semester);
    $stmt->bindParam(':lecture_hours', $lectureHours, PDO::PARAM_INT);
    $stmt->bindParam(':lab_hours', $labHours, PDO::PARAM_INT);
    $stmt->bindParam(':credit_units', $creditUnits, PDO::PARAM_INT);
    $stmt->bindParam(':slots', $slots, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the courses page with a success message
    header("Location: courses.php?program_code=" . urlencode($programCode) . "&success=Course added or updated successfully");
    exit;
}

// Handle editing of a course
// Handle form submission for adding/editing courses
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_code = $_POST['subject_code'];
    $course_title = $_POST['course_title'];
    $year_level = $_POST['year_level'];
    $semester = $_POST['semester'];
    $lecture_hours = $_POST['lecture_hours'];
    $lab_hours = $_POST['lab_hours'];
    $credit_units = $_POST['credit_units'];
    $slots = $_POST['slots'];
    $program_code = $_POST['program_code'];

    // Check if the course code already exists in the database
    $query = "SELECT * FROM courses WHERE subject_code = :subject_code";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['subject_code' => $subject_code]);
    $existingCourse = $stmt->fetch();

    // If the course code exists and this is not an edit, show error
    if ($existingCourse && !isset($_POST['edit_course'])) {
        echo "Course code already exists!";
    } else {
        // If this is an edit request
        if (isset($_POST['edit_course'])) {
            $course_id = $_POST['course_id'];  // Ensure to pass course_id for updating
            $query = "UPDATE courses SET subject_code = :subject_code, course_title = :course_title, 
                      year_level = :year_level, semester = :semester, lecture_hours = :lecture_hours, 
                      lab_hours = :lab_hours, credit_units = :credit_units, slots = :slots
                      WHERE course_id = :course_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'subject_code' => $subject_code,
                'course_title' => $course_title,
                'year_level' => $year_level,
                'semester' => $semester,
                'lecture_hours' => $lecture_hours,
                'lab_hours' => $lab_hours,
                'credit_units' => $credit_units,
                'slots' => $slots,
                'course_id' => $course_id
            ]);
            echo "Course updated successfully!";
        } else {
            // Insert new course if it does not exist
            $query = "INSERT INTO courses (subject_code, course_title, year_level, semester, lecture_hours, lab_hours, credit_units, slots, program_code)
                      VALUES (:subject_code, :course_title, :year_level, :semester, :lecture_hours, :lab_hours, :credit_units, :slots, :program_code)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'subject_code' => $subject_code,
                'course_title' => $course_title,
                'year_level' => $year_level,
                'semester' => $semester,
                'lecture_hours' => $lecture_hours,
                'lab_hours' => $lab_hours,
                'credit_units' => $credit_units,
                'slots' => $slots,
                'program_code' => $program_code
            ]);
            echo "New course added successfully!";
        }
    }
}


} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
