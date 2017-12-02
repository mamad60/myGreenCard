<?php
session_start();
if(!isset($_SESSION['active_contact_form']) || !isset($_POST['hints']))
{
    // echo json_encode("no data");
    return 0;
}
$_SESSION['active_contact_form']=false;

?>