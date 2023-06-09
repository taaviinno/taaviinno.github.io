<?php
    // Prof. Jake Rodriguez Pomperada, MAED-IT, MIT
    // www.jakerpomperada.blogspot.com and www.jakerpomperada.com
    // jakerpomperada@gmail.com
    // Bacolod City, Negros Occidental
    

    // Enable error reporting for mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Hostname
    $host = "localhost";

    // Username
    $user = "root";

    // Password
    $pass = "";

    // Database Name
    $db   = "r_questions";

    // Establish database connection
    $con = new mysqli($host, $user, $pass, $db);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }