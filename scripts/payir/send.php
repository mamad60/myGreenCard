<?php
include_once("functions.php");
if (!is_ajax()) { // If it is real Ajax Request}
die('NO Ajax Request!');
}
$output['error']='';
if(isset($_POST['amount'])){
$amount = $_POST['amount'].'0';} else {
	$output['error']='No Paymnet amount is set';
}
$api = 'test';
$redirect = 'Callback';
$factorNumber = 123;
$result = send($api,$amount,$redirect,$factorNumber);
$result = json_decode($result);
$output['result']=$result;
if($result->status) {
	$go = "https://pay.ir/payment/gateway/$result->transId";
	header("Location: $go");
} else {
	$output['error']=$result->errorMessage;
}
echo json_encode($output);
?>