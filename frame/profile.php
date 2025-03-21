<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 30px;
            background: #fff;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            margin-top: unset;
        }
        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }
        .profile-image {
            width: 250px;
            height: 250px;
            border: 2px solid #00000099;
            border-radius: 50%;
            margin-right: 30px;
            overflow: hidden; 
        }
        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            border-radius: 50%; 
        }
        .profile-name {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .profile-role {
            font-size: 18px;
            font-weight: normal;
            margin: 5px 0;
        }
        .profile-department {
            font-size: 18px;
            color: #333;
            margin: 0;
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .info-label {
            font-weight: bold;
            color: #34495e;
            margin-top: 10px;
        }
        .info-value {
            margin-bottom: 10px;
        }
        @media (max-width: 600px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            .profile-image {
                margin-right: 0;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Faculty Profile</h1>
        <div class="profile-header">
            <div class="profile-image">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Profile Picture">
            </div>
            <div>
                <h2 class="profile-name">Alice Johnson</h2>
                <h3 class="profile-role">Department Head</h3>
                <div class="profile-department">BSIT Department</div>
            </div>
        </div>
        <div class="profile-info">
            <div class="info-label">Email:</div>
            <div class="info-value">johnson@gmail.com</div>
            
            <div class="info-label">Phone Number:</div>
            <div class="info-value">09765442345</div>
            
            <div class="info-label">Address:</div>
            <div class="info-value">456 Elm St</div>
        </div>
    </div>
</body>
</html>