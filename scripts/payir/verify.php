<?php
include_once("functions.php");
if (!is_ajax()) { // If it is real Ajax Request}
die('NO Ajax Request!');
}
$api = 'test';
$transId = $_POST['transId'];
$result = verify($api,$transId);
echo  $result;
?>