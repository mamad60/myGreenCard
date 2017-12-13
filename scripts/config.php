<?php
    // Setup Connection to the MySQL database
    $db_servername = 'localhost';
    $db_username = 'Mohammad';
    $db_password = '7QfAgRrsTb4fjC0Y';
    //User Name and Passeord for Administrator
    $admin_user="m";
    $admin_password="123456";
    // payment api 
    $api = 'test';
    //Session Setting----Session Timeout
    $admin_session_timeout=2*60*60; // 2 hours
    $user_session_timeout=30*60;  // 30 minutes
    $admin_redirect="adminlogin.php"; // whrer to redirect admin on session expiration
    $user_redirect="dv-lottery-reg.php"; // whrer to redirect user on session expiration
?>