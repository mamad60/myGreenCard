<?php
include_once "config.php";
//1:session is not expired
//0:session expired
session_start();
if (!isset($_SESSION)) {
    return;
}
if (!isset($_POST['user_type'])) {
    return;
}
// if no timestmp create it
switch ($_POST['user_type']) {
    case 'user':
        if (!isset($_SESSION['user_timestamp'])) {
            $_SESSION['user_timestamp'] = time();
            echo json_encode(1);
            return;
        }
        break;
    case 'admin':
        if (!isset($_SESSION['admin_timestamp'])) {
            $_SESSION['admin_timestamp'] = time();
            echo json_encode(1);
            return;
        }
        break;
}
// check the time limit and redirect if time is expired
switch ($_POST['user_type']) {
    case 'user':
        if ( (time() - $_SESSION['user_timestamp']) >= $user_session_timeout) {
            if (isset($_SESSION)) {
                session_destroy();
                unset($_SESSION);
            }
            echo json_encode(0);
            return;
        }
        break;
    case 'admin':
        if ( (time() - $_SESSION['admin_timestamp']) >= $admin_session_timeout) {
            if (isset($_SESSION)) {
                session_destroy();
                unset($_SESSION);
            }
            echo json_encode(0);
            return;
        }
}
echo json_encode(1);
?>