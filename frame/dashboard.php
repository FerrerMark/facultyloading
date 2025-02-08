<?php

    include_once("../back/dashboard.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/sms/cssfolder/dashstyle.css">
</head>
<body>
    <div class="dashboard">
        <main class="main-content">
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Faculty</h3>
                    <p class="number"><?php echo $data['faculty_count']?></p>
                    <p class="subtext">+2 from last month</p>
                </div>
                <div class="card">
                    <h3>Active Faculty</h3>
                    <p class="number">38</p>
                    <p class="subtext">Currently teaching</p>
                </div>
                <div class="card">
                    <h3>to be edit</h3>
                    <p class="number">...</p>
                    <p class="subtext">to be edit</p>
                </div>
                
            </div>
            <div class="new-requests">
                <h2>New Requests</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Faculty</th>
                            <th>Department</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="requestsTableBody">
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const newRequests = [
                { type: '...', faculty: 'Dr. Jane Smith', department: 'Computer Science', status: 'Pending' },
                { type: '...', faculty: 'Prof. John Doe', department: 'Information Technology', status: 'Pending' },
                { type: '...', faculty: 'Dr. Emily Brown', department: 'Software Engineering', status: 'Pending' }
            ];

            const requestsTableBody = document.getElementById('requestsTableBody');

            newRequests.forEach(request => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${request.type}</td>
                    <td>${request.faculty}</td>
                    <td>${request.department}</td>
                    <td><span class="status status-${request.status.toLowerCase()}">${request.status}</span></td>
                `;
                requestsTableBody.appendChild(row);
            });

            const newRequestsNumber = document.querySelector('.card:nth-child(4) .number');
            newRequestsNumber.textContent = newRequests.length;
        });
    </script>
</body>
</html>