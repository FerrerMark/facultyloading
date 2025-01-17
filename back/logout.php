<?php
    session_start();
    // include_once("./connections/connection.php");

    session_unset();
    session_destroy();
    header("location: /facultyloading/login.php");

?>