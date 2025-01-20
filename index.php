<?php

    include_once("./back/index.php");   

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Faculty</title>
        <link rel="stylesheet" href="./css/index.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <link rel="icon" type="image/x-icon" href="https://bcp.edu.ph/images/logo300.png">
    </head>
<body>
    
    <header>
        <div style="display: flex; align-items: center;">
            <span class="logo">
                <a href="http://localhost/facultyloading/index.php"><img src="./assets/logo300.png" alt="Logo" style="width:2rem;"/></a>
            </span>
            <span class="header-title">faculty dashboard</span>
        </div>
        <div class="header-icons">
            <span class="icon-park-solid--dark-mode"></span>
            <i class="fa-solid fa-bell"></i>
            <a onclick="loadFrame('profile','<?php echo $role?>','<?php ?>')">
                <i class="fa-solid fa-user"></i>
            </a>
        </div>
        <i class="fa-solid fa-bars" onclick="showNav()"></i>
    </header>
    <div class="container">
        <aside class="sidebar">
            <div class="profile">
                
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="">
            </div>
            <h3><?php echo $row['firstname']." ".$row['lastname']?></h3>
            <h4><?php echo "<span>".$row['departmentID']."</span>"." " .$row['role']?></h4>
            <hr>
            <nav class="side_nav">

                <?php if($row['role'] == "faculty"){ ?>
                    <a href="#" onclick="schedule()" class="nav-item"><i class="fa-solid fa-calendar-days"></i>&nbsp;Schedule</a>
                    <a href="#" onclick="documents()" class="nav-item"><i class="fa-solid fa-file"></i>&nbsp;Documents</a>  
                <?php } ?> 
                
                <a href="#" onclick="loadFrame('programs','<?php echo $role;?>','<?php echo $departmentId;?>')"class="nav-item"><span class="nrk--media-programguide-active"></span></i>&nbsp;programs</a>

                <a href="#" onclick="todo()"  class="nav-item"><span class="lucide--list-todo"></span>&nbsp;ToDo list</a>
                <a href="#" onclick="loadFrame('crads')"  class="nav-item"><span class="uis--schedule"></span>&nbsp;Student Research Schedule</a>
                        
                    <!--head-->
                    <?php if($role == "department head"){ ?>
                        <a href="#" onclick="loadFrame('faculty','<?php echo $role;?>','<?php echo $departmentId;?>')"  class="nav-item"><span class="mdi--teacher"></span>&nbsp;faculty</a>

                        <a href="#" onclick="loadFrame('rooms','<?php echo $role;?>','<?php echo $departmentId;?>')"  class="nav-item"><span class="guidance--conference-room"></span>&nbsp;room</a>

                        <a href="#" onclick="loadFrame('schedules')"  class="nav-item"><span class="mingcute--schedule-line"></span>&nbsp;schedule management</a>

                        <a href="#" onclick="loadFrame('manual_scheduling','<?php echo $role;?>','<?php echo $departmentId;?>')" onclick="check_schedule()"  class="nav-item"><span class="mingcute--schedule-line"></span>&nbsp;Manual Scheduling</a>

                        <a href="#" onclick="distribute()"  class="nav-item"><span class="fluent-mdl2--assign"></span>&nbsp;distribute schedule</a>

                        <a href="#" onclick="loadFrame('manual_scheduling','<?php echo $role;?>','<?php echo $departmentId;?>')"class="nav-item"><span class="tdesign--fact-check"></span>&nbsp;check schedule</a>

                        
                    <?php } ?>
               

            </nav>
            <hr>
            <div class="logout-container">
                <a href="#" class="nav-item"><i class="fa-solid fa-flag"></i>&nbsp;report a problem</a>
                <a href="/facultyloading/back/logout.php" class="nav-item logout-button"><i class="fa-solid fa-arrow-left-long"></i>&nbsp;Logout</a>
            </div>
        </aside>
        <div style="width:100%; ">

        <?php if($row['role'] == "faculty"){ ?>
            <iframe id="frame" src="http://localhost/sms/faculty/frame/facultydashboard.php" width="100%" height="100%" title="nav">
            </iframe>
        <?php } ?>
        <?php if($row['role'] == "department head"){ ?>
            <iframe id="frame" src="http://localhost/sms/faculty/frame/headdashboard.php" width="100%" height="100%" title="nav">
            </iframe>
        <?php } ?>  

        </div>
    </div>
    <script src="scripts.js"></script>
</body>
</html>