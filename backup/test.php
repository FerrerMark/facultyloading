<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Additional Faculty</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        select, input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 80px;
            resize: vertical;
        }
        .radio-group {
            margin-bottom: 15px;
        }
        .radio-group input {
            width: auto;
            margin-right: 5px;
        }
        .radio-group label {
            display: inline;
            font-weight: normal;
            margin-right: 15px;
        }
        .buttons {
            text-align: right;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-btn {
            background-color: #007BFF;
            color: white;
        }
        .cancel-btn {
            background-color: #ccc;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>New Faculty Request (Due to Shortage)</h2>
        <form action="submit_faculty_request.php" method="POST">
            <label>Requesting Department *</label>
            <select name="department" required>
                <option value="">Select Department</option>
                <option value="BSIT">BS Information Technology</option>
                <option value="BSBA">BS Business Administration</option>
                <!-- Populate dynamically with PHP from `programs` table -->
            </select>

            <label>Role Needed *</label>
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="Dean">Dean</option>
                <option value="Department Head">Department Head</option>
                <option value="Instructor">Instructor</option>
            </select>

            <label>Employment Status *</label>
            <div class="radio-group">
                <input type="radio" name="employment_status" value="Full-Time" required> <label>Full-Time</label>
                <input type="radio" name="employment_status" value="Part-Time"> <label>Part-Time</label>
            </div>

            <label>Specialization Needed</label>
            <input type="text" name="specialization" placeholder="e.g., General Education">

            <label>Reason for Shortage *</label>
            <textarea name="reason" required>Due to lack of faculty</textarea>

            <label>Number of Faculty Needed *</label>
            <input type="number" name="quantity" min="1" value="1" required>

            <label>Urgency *</label>
            <div class="radio-group">
                <input type="radio" name="urgency" value="Low" required> <label>Low</label>
                <input type="radio" name="urgency" value="Medium"> <label>Medium</label>
                <input type="radio" name="urgency" value="High"> <label>High</label>
            </div>

            <label>Requested Start Date *</label>
            <input type="date" name="start_date" required>

            <div class="buttons">
                <button type="button" class="cancel-btn" onclick="window.location.href='dashboard.php'">Cancel</button>
                <button type="submit" class="submit-btn">Submit Request</button>
            </div>
        </form>
    </div>
</body>
</html>