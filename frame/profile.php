<?php

    include_once("../back/profile.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['FirstName']?></title>
    <link rel="stylesheet" href="../cssfolder/profile.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        h5{
            margin: unset;
        }

        h3 {
            margin: unset;
        }

        .profile-header {
            text-align: center;
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            flex-direction: column;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 30px;
        }

        .profile-name {
            font-size: 24px;
            font-weight: bold;
        }

        .profile-department {
            font-size: 18px;
            color: #7f8c8d;
        }

        .profile-info {
            margin-bottom: 20px;
        }

        .info-label {
            font-weight: bold;
            color: #34495e;
        }

        .info-value {
            margin-bottom: 10px;
        }

        img {
            border: 1px solid black;
            border-radius: 50%;
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
            
            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="">
            <div>
                <div class="profile-name"><?php echo $row['firstname']." ".$row['lastname']?></div>
                <h3><?php echo $row['role']?></h3>
                <div class="profile-department"><?php echo $row['departmentID']?> Department</div>
            </div>
        </div>
        <div class="profile-info">

            <div class="info-label">Email:</div>
            <div class="info-value"><?php echo $row['lastname']?>@gmail.com</  div>
            
            <div class="info-label">Phone Number:</div>
            <div class="info-value"><?php echo $row['phone_no']?></div>
            
            <div class="info-label">Address:</div>
            <div class="info-value"><?php echo $row['address'] ?></div>
            
        </div>
    </div>
</body>
</html>