<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-Generate Faculty Schedules</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        #output {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Auto-Generate Faculty Schedules</h1>
    <form action="auto_generated_schedule.php" method="post" enctype="multipart/form-data">
        <label for="faculty_file">Upload Faculty Data File (XLSX):</label>
        <input type="file" name="faculty_file" id="faculty_file" accept=".xlsx" required>
        <button type="submit">Upload File</button>
    </form>
    <div id="instructions">
        <p>Please upload a file containing the faculty data. Ensure the file is in the correct format.</p>
        <p>Example format: Faculty ID, First Name, Middle Name, Last Name, College, Employment Status, Address, Phone No, Department ID, Department Title, Subject, Role, Specialization</p>
    </div>
    <div id="output">
        <h2>Generated Schedule</h2>
        <!-- Generated schedule will be populated here -->
    </div>
</body>
</html>