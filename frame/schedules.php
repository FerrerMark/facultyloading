<?php
include_once("./session/session.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Schedule - Faculty Loading</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            padding: 20px;
            background-color: #f5f5f5;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #2c3e50;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .filters {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            font-size: 14px;
        }

        .alert {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 12px;
            margin: 20px 0;
            border-radius: 4px;
            color: #28a745;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
            overflow-x: auto;
            display: block;
        }

        .schedule-table th,
        .schedule-table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
            min-width: 120px;
            height: 40px;
        }

        .schedule-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .schedule-table td:first-child {
            background-color: #f8f9fa;
            font-weight: bold;
            white-space: nowrap;
            position: sticky;
            left: 0;
            z-index: 5;
        }

        .class-block {
            padding: 2px;
            font-size: 10px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .class-block.cpe {
            background-color: rgba(139, 115, 85, 0.5);
        }

        .class-block.cal {
            background-color: rgba(255, 182, 193, 0.5);
        }

        .available::after {
            content: "✓";
            color: #28a745;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .filters {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="header">
            <h1>Faculty</h1>
        </div>

        <!-- Top Filters -->
        <div class="filters">
            <select>
                <option value="">Academic Year</option>
                <option value="2022-2023">2022-2023</option>
                <option value="2023-2024">2023-2024</option>
            </select>

            <select>
                <option value="">College</option>
                <option value="comp">College of Comp</option>
            </select>

            <select>
                <option value="">Program</option>
                <option value="bsit">BSIT (BS Information Technology)</option>
            </select>

            <select>
                <option value="">Semester</option>
                <option value="first">First</option>
                <option value="second">Second</option>
            </select>

            <select>
                <option value="">Year Level</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>

        <!-- Middle Filters -->
        <div class="filters">
            <select>
                <option value="">Subject</option>
                <option value="lit111">LIT 111 (Philippine Literature)</option>
            </select>

            <select>
                <option value="">Class</option>
                <option value="1-1">1-1</option>
            </select>

            <select>
                <option value="">Faculty</option>
                <option value="eugene">Eugene De Guzman</option>
                <option value="ernesto">Ernesto Rodriguez Jr</option>
            </select>

            <select>
                <option value="">Room</option>
                <option value="117">Room 117(IT Building)</option>
            </select>
        </div>

        <!-- Bottom Filters -->
        <div class="filters">
            <select>
                <option value="">Lecture/Laboratory</option>
                <option value="lecture">Lecture</option>
                <option value="laboratory">Laboratory</option>
            </select>

            <select>
                <option value="">Schedule</option>
                <option value="first">First</option>
                <option value="second">Second</option>
            </select>
        </div>

        <!-- Alert Message -->
        <div class="alert">
            LIT 111 has already plotted 3 hr(s) for BSIT 1-1 at room Room-117Lecture under Eugene De Guzman
        </div>

        <!-- Full Schedule Table -->
        <div class="schedule-table">
            <table>
                <thead>
                    <tr>
                        <th>Time/Day</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Sunday</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Generate time slots from 6:00 AM to 9:00 PM -->
                    <tr>
                        <td>6:00-6:30am</td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                    </tr>
                    <tr>
                        <td>6:30-7:00am</td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                    </tr>
                    <tr>
                        <td>7:00-7:30am</td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                    </tr>
                    <tr>
                        <td>7:30-8:00am</td>
                        <td>
                            <div class="class-block cpe">
                                CpE 311<br>
                                BSCPE<br>
                                Room-117Lecture(Lecture)<br>
                                malupiton n. kups
                            </div>
                        </td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td>
                            <div class="class-block cal">
                                Cal 111<br>
                                BSCPE 1-1<br>
                                Room-116Lecture(Lecture)<br>
                                malupiton n. kups
                            </div>
                        </td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                    </tr>
                    <tr>
                        <td>8:00-8:30am</td>
                        <td>
                            <div class="class-block cpe">
                                CpE 311<br>
                                BSCPE<br>
                                Room-117Lecture(Lecture)<br>
                                malupiton n. kups
                            </div>
                        </td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td>
                            <div class="class-block cal">
                                Cal 111<br>
                                BSCPE 1-1<br>
                                Room-116Lecture(Lecture)<br>
                                malupiton n. kups
                            </div>
                        </td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                    </tr>
                    <tr>
                        <td>8:30-9:00am</td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                    </tr>
                    <!-- Continue with more time slots until 9:00 PM -->
                    <!-- For brevity, I'll skip to the last few entries -->
                    <tr>
                        <td>8:00-8:30pm</td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                    </tr>
                    <tr>
                        <td>8:30-9:00pm</td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                        <td class="available"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>