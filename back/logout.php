<?php
    session_start();
    session_unset();
    session_destroy();
    // header("location: /facultyloading/login.php");    
    header("location: http://localhost/pref/logintestapi.php");


?>