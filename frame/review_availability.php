<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Faculty Availability</title>
    <script type="importmap">
      {
        "imports": {
          "@google/generative-ai": "https://esm.run/@google/generative-ai"
        }
      }
    </script>
    <script type="module">
        import { GoogleGenerativeAI } from '@google/generative-ai';

        function cleanAndFormatText(text) {
            return text.replace(/\*\*(.*?)\*\*/g, '<strong style="color: red;">$1</strong>')
                       .replace(/\*(.*?)\*/g, '<em>$1</em>')
                       .replace(/\n-\s/g, '<p>')
                       .replace(/\n/g, '</p><p>');
        }

        async function generateSuggestion(action, type, courseTitle, facultyName, teachingHours) {
            const apiKey = "AIzaSyATHxYwcKhvU-C5fH8knIiMcdi3QLFwtxM"; 
            const genAI = new GoogleGenerativeAI(apiKey);
            const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });

            let prompt;
            if (type === 'add') {
                if (action === 'accept') {
                    prompt = `Explain the impact of accepting a request to assign the course "${courseTitle}" to faculty member "${facultyName}", who is currently teaching ${teachingHours} hours per week.`;
                } else {
                    prompt = `Explain the impact of rejecting a request to assign the course "${courseTitle}" to faculty member "${facultyName}", who is currently teaching ${teachingHours} hours per week.`;
                }
            } else if (type === 'delete') {
                if (action === 'accept') {
                    prompt = `Explain the impact of approving the deletion of the course "${courseTitle}" from faculty member "${facultyName}"'s assignments, who is currently teaching ${teachingHours} hours per week.`;
                } else {
                    prompt = `Explain the impact of rejecting the deletion request for the course "${courseTitle}" from faculty member "${facultyName}"'s assignments, who is currently teaching ${teachingHours} hours per week.`;
                }
            }

            try {
                const result = await model.generateContent(prompt);
                const suggestion = result?.response?.text() || "No suggestion available.";
                return cleanAndFormatText(suggestion);
            } catch (error) {
                console.error(error);
                return "An error occurred while generating the suggestion.";
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const suggestionBox = document.createElement('div');
            suggestionBox.id = 'suggestionBox';
            suggestionBox.style.position = 'absolute';
            suggestionBox.style.background = '#f9f9f9';
            suggestionBox.style.border = '1px solid #ccc';
            suggestionBox.style.padding = '10px';
            suggestionBox.style.maxWidth = '300px';
            suggestionBox.style.display = 'none';
            document.body.appendChild(suggestionBox);

            document.querySelectorAll('.action-btn').forEach(button => {
                button.addEventListener('mouseover', async function(event) {
                    const action = this.getAttribute('data-action');
                    const type = this.getAttribute('data-type');
                    const courseTitle = this.getAttribute('data-course');
                    const facultyName = this.getAttribute('data-faculty');
                    const teachingHours = this.getAttribute('data-teaching-hours');

                    suggestionBox.style.left = `${event.pageX + 10}px`;
                    suggestionBox.style.top = `${event.pageY + 10}px`;
                    suggestionBox.innerHTML = 'Generating suggestion...';
                    suggestionBox.style.display = 'block';

                    const suggestion = await generateSuggestion(action, type, courseTitle, facultyName, teachingHours);
                    suggestionBox.innerHTML = suggestion;
                });

                button.addEventListener('mouseout', function() {
                    suggestionBox.style.display = 'none';
                });
            });
        });
    </script>
    <style>
        .action-btn { 
            cursor: pointer; 
            padding: 5px 10px; 
            margin: 0 5px; 
        }
        table { 
            border-collapse: collapse; 
            width: 100%; 
            margin-bottom: 20px; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
        }
        body {
            background-color: #f4f4f4;  
        }
    </style>
</head>
<body>
    <?php
    // Database connection (replace with your actual connection code)
    include_once "../connections/connection.php";

    // Sample data (replace with your actual database queries)
    $submissions = [
        ['pending_id' => 1, 'faculty_id' => 1, 'firstname' => 'John', 'lastname' => 'Doe', 'course_title' => 'Math 101', 'available_days' => 'MWF', 'start_time' => '10:00', 'end_time' => '11:00'],
        ['pending_id' => 2, 'faculty_id' => 2, 'firstname' => 'Jane', 'lastname' => 'Smith', 'course_title' => 'CS 202', 'available_days' => 'TTh', 'start_time' => '14:00', 'end_time' => '15:30']
    ];
    $deletion_requests = [
        ['pending_id' => 3, 'faculty_id' => 1, 'firstname' => 'John', 'lastname' => 'Doe', 'course_title' => 'Math 102'],
        ['pending_id' => 4, 'faculty_id' => 2, 'firstname' => 'Jane', 'lastname' => 'Smith', 'course_title' => 'CS 201']
    ];

    $faculty_ids = [];
    foreach ($submissions as $submission) {
        $faculty_ids[] = $submission['faculty_id'];
    }
    foreach ($deletion_requests as $request) {
        $faculty_ids[] = $request['faculty_id'];
    }
    $faculty_ids = array_unique($faculty_ids);

    // Fetch all schedules for these faculty members
    $stmt = $conn->prepare("
        SELECT faculty_id, start_time, end_time
        FROM schedules
        WHERE faculty_id IN (" . implode(',', array_fill(0, count($faculty_ids), '?')) . ")
    ");
    $stmt->execute($faculty_ids);
    $all_schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $teaching_hours = [];
    foreach ($all_schedules as $schedule) {
        $fid = $schedule['faculty_id'];
        if (!isset($teaching_hours[$fid])) {
            $teaching_hours[$fid] = 0;
        }
        if ($schedule['start_time'] && $schedule['end_time']) {
            $start = new DateTime($schedule['start_time']);
            $end = new DateTime($schedule['end_time']);
            $interval = $start->diff($end);
            $hours = $interval->h + ($interval->i / 60); // Convert minutes to hours
            $teaching_hours[$fid] += $hours;
        }
    }
    ?>

    <h1>Review Faculty Availability Submissions</h1>
    <table>
        <tr>
            <th>Faculty Name</th>
            <th>Requested Course</th>
            <th>Available Days</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Action</th>
        </tr>
        <?php foreach ($submissions as $submission): ?>
            <tr>
                <td><?php echo htmlspecialchars($submission['firstname'] . ' ' . $submission['lastname']); ?></td>
                <td><?php echo htmlspecialchars($submission['course_title']); ?></td>
                <td><?php echo htmlspecialchars($submission['available_days'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($submission['start_time'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($submission['end_time'] ?? 'N/A'); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="pending_id" value="<?php echo $submission['pending_id']; ?>">
                        <input type="hidden" name="type" value="add">
                        <button type="submit" name="action" value="accept" class="action-btn" 
                                data-action="accept" data-type="add" 
                                data-course="<?php echo htmlspecialchars($submission['course_title']); ?>" 
                                data-faculty="<?php echo htmlspecialchars($submission['firstname'] . ' ' . $submission['lastname']); ?>"
                                data-teaching-hours="<?php echo number_format($teaching_hours[$submission['faculty_id']] ?? 0, 2); ?>">Accept</button>
                        <button type="submit" name="action" value="reject" class="action-btn" 
                                data-action="reject" data-type="add" 
                                data-course="<?php echo htmlspecialchars($submission['course_title']); ?>" 
                                data-faculty="<?php echo htmlspecialchars($submission['firstname'] . ' ' . $submission['lastname']); ?>"
                                data-teaching-hours="<?php echo number_format($teaching_hours[$submission['faculty_id']] ?? 0, 2); ?>">Reject</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Review Faculty Deletion Requests</h2>
    <table>
        <tr>
            <th>Faculty Name</th>
            <th>Course to Delete</th>
            <th>Action</th>
        </tr>
        <?php foreach ($deletion_requests as $request): ?>
            <tr>
                <td><?php echo htmlspecialchars($request['firstname'] . ' ' . $request['lastname']); ?></td>
                <td><?php echo htmlspecialchars($request['course_title']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="pending_id" value="<?php echo $request['pending_id']; ?>">
                        <input type="hidden" name="type" value="delete">
                        <button type="submit" name="action" value="accept" class="action-btn" 
                                data-action="accept" data-type="delete" 
                                data-course="<?php echo htmlspecialchars($request['course_title']); ?>" 
                                data-faculty="<?php echo htmlspecialchars($request['firstname'] . ' ' . $request['lastname']); ?>"
                                data-teaching-hours="<?php echo number_format($teaching_hours[$request['faculty_id']] ?? 0, 2); ?>">Approve</button>
                        <button type="submit" name="action" value="reject" class="action-btn" 
                                data-action="reject" data-type="delete" 
                                data-course="<?php echo htmlspecialchars($request['course_title']); ?>" 
                                data-faculty="<?php echo htmlspecialchars($request['firstname'] . ' ' . $request['lastname']); ?>"
                                data-teaching-hours="<?php echo number_format($teaching_hours[$request['faculty_id']] ?? 0, 2); ?>">Reject</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>