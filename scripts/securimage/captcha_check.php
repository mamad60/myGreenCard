<?php
include_once 'securimage.php';
header('Content-Type: text/plain; charset=utf-8');
//Check IF it is a real Ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
	die('NO Ajax Request');
}
session_start();
$image = new Securimage();
$output['error']='';
if ($image->check($_POST['reg_form_captcha']) != true) {
	$output['error']='Captcha entered don\'t match';
}
echo json_encode($output);
?>