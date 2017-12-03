<?php
header("Content-Type: application/json; charset=UTF-8");
include_once("functions.php");
include_once ("securimage\securimage.php");
session_start();
if (!is_ajax()) { // If it is real Ajax Request}
    die('NO Ajax Request!');
}
//if contact form is active
// if(!isset($_SESSION['active_contact_form']))
// {
//     $output['error']=true;   
//     $output['message']= 'لطفا فقط از یک نسخه از فرم پشتیبانی استفاده کنید.';}
if(!check_captcha()){
    $output['error']=true;   
    $output['message']= 'لطفا کد تصویر را بدرستی وارد نمائید.';
    //Return Message to client
    echo json_encode($output);
    return 0;
}

$output['error']=false; //Returned varibles to caller
$output['message']=[]; //Returned varibles to caller

if (isset($_POST["firstname"])) { //Checks if action value exist
    $firstName=$_POST["firstname"];
}    
if (isset($_POST["lastname"])) { //Checks if action value exist
    $lastname=$_POST["lastname"];
}    
if (isset($_POST["email"])) { //Checks if action value exist
    $email=$_POST["email"];
}    
if (isset($_POST["comment"])) { //Checks if action value exist
    $comment=$_POST["comment"];
} 
//replace \n with <br/> in comment
// $comment=htmlentities($comment);
$comment=str_replace("\n","   <br/>",$comment);   
//====send form to admin
$from='admin@mygreencard.ir';
    $to = 'info@mygreencard.ir';
$subject = 'Contact Form MyGreenCard '.$firstName.'  '.$lastname;
$body = "<html>
        <body lang='fa'  dir='rtl'  style='font-size:16px;'>
        <div style='font-weight:bold;'>
        سلام،
        <br/>
          درخواست پشتیبانی جدید در سایت MygreenCard
        </div>
        <br/>
        نام=$firstName
        <br/>        
        نام خانوادگی=  $lastname
        <br/>        
        آدرس ایمیل= $email
        <br/>        
        پیغام:
        <br/>
         $comment
        <br/>        
        </html>
        </body>";
$mailStat=sendMail($from,$to,$subject,$body);
if($mailStat){
    $output['error']=false; //Returned varibles to caller    
    $output['message']='<p>فرم پشتیبانی با موفقیت ارسال شد. کارشناسان ما در اسرع وقت با شما تماس خواهند گرفت</p><p>با تشکر</p>';
//======send Email to user
$from='info@mygreencard.ir';
$to = $email;
$subject = 'Mygreencard Support';
$body = "<html>
        <body lang='fa' style='font-size:16px;'>
        <div dir='rtl'>
        با سلام
        <br/>
          کاربر محترم, آقای/خانم <strong>$firstName  $lastname</strong> درخواست پشتیبانی شما در سایت <a href='http://myreencard.ir' target='_blank'>mygreencard.ir</a> دریافت شد
          <br/>
            کارشناسان ما بزودی با شما تماس می گیرند.
        <br/>
        <br/>
        <strong>پیغام شما:</strong>
        <br/>
         $comment
        <br/>
        <br/>       
        با تشکر,  سایت <a href='http://myreencard.ir' target='_blank'>mygreencard.ir</a>
        </div>     
        </html>
        </body>";
sendMail($from,$to,$subject,$body);
} else {
    $output['error']=true;   
    $output['message']= '<p>ارسال فرم با خطا روبرو شده است. لطفا بعدا تلاش کنید.</p>';
}
//Return Message to client
echo json_encode($output);
function is_ajax() //Function to check if the request is an AJAX request
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
function check_captcha(){
    $image = new Securimage();
    return $image->check($_POST['captcha_code']) == true;
}
?>