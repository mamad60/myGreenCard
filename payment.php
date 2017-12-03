<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <title> ثبت نام لاتاری گرین کارت </title>
    <!--Meta Tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="سایت ثبت نام در قرعه کشی گرین کارت آمریکا-فرم ثبت نام">
    <meta name="keywords" content="بهترین, ساده ترین, سریع ترین, گرین کارت, ثبت نام, آمریکا,ثبت نام در قرعه کشی گرین کارت,لاتاری,Greencard">
    <meta name="author" content="Mohammad Aghakhani">
    <link rel="shortcut icon" href="favicon.ico">
    <!--==============================================================-->
    <!--BoottStrap-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <!---=============BootStrap RTL-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/formstyle.css" type="text/css">
    <link rel="stylesheet" href="css/formprint.css" type="text/css">
    <!--JQuery-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <!--BootStrap-->
    <script src="js/bootstrap.min.js"></script>
    <!-- the main fileinput plugin file -->
    <!--Site Specefic-->
    <!--For old Browser use HTMLshiv-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .resultItem {
            display:  none;
            margin-top: 10px;
        }
    </style>
    <script>
        $(function () {
            //======Navigation
            $('nav').load('menu.html', function () {
                //===make current Page Active
                $('#myNavbar').find('li a[href="' + "dv-lottery-reg.php" + '"]').parent().addClass(
                    'active');
            });
            $('.activeProgress').removeClass('activeProgress');
            $('#progressBar li').eq(4).addClass('activeProgress');

        });
    </script>
</head>
<?php
        include_once("scripts/payir/functions.php");
        include_once("scripts/register.php");        
        // $redirect = urlencode('http://mygreencard.ir'.$_SERVER['PHP_SELF']);
        $redirect = urlencode('http://localhost//'.$_SERVER['PHP_SELF']);
        $factorNumber = null;
        $api = 'test';
        $amout=0;
        $mobile=null;
        $traceNumber=null;
        // redirect to registration Page If Called Directily
        if(!isset($_POST['transId']) && !isset($_POST['Applicant'])){ // call for first time
            $go = "dv-lottery-reg.php";
            header("Location: $go");
        }            
        session_start();      
        if(isset($_POST['Applicant'])){ // for first call and post
            // Start new Session
            $applicant=$_POST['Applicant'];
            $_SESSION['Applicant']= $applicant;
            $mobile=$applicant['TelNumber'];
            if(isset($_POST['Spouse'])){
                $_SESSION['Spouse']=$_POST['Spouse'];                
            }                
            if(isset($_POST['Children'])){
                $_SESSION['Children']=$_POST['Children'];                
            }                
            if(isset($_POST['Price'])){
                $price =$_POST['Price'];                
                $_SESSION['Price']=$price;
                $amount=$price["TotalCharge"]."0";                
            }                
        }
        if(!isset($_POST['transId']) && isset($_POST['Applicant'])){ // call for first time
            $result = send($api,$amount,$redirect,$factorNumber,$mobile);
            $result = json_decode($result);
            // var_dump($result);
            if($result->status) {
                $go = "https://pay.ir/payment/gateway/$result->transId";
                header("Location: $go");
            } else { // No TransID
                    $error=$result->errorMessage;
                    echo "<script type=\"text/javascript\">
                    $(document).ready(function() {
                    $(\"#resultContainer\").find(\".panel-heading\").css(\"background-color\",\"red\").css(\"background-image\", \"linear-gradient(to bottom,IndianRed	 0,FireBrick 100%)\");
                    $(\"#result\").html(\"<p>مشکلی در فرآیند پرداخت پیش آمده است.</p>\").removeClass(\"text-success\").addClass(\"text-danger\").show();
                    $(\"#transId\").html(\"شماره تراکنش: $transId \").show();
                    $(\"#resultContainer\").show();
                   });
                  </script>";
                } 
        }        
    
        // process from payment
        if(isset($_POST['transId'])){ // If returned form Gateway
            $transId = $_POST['transId'];
            if(isset($_POST['traceNumber'])){ // If trace number is available
                $traceNumber=$_POST['traceNumber'];
                $_SESSION['TraceNumber']=$traceNumber;
            }                
        // var_dump($_POST);
            if(isUniqueTransId($transId)){  // IF TransID is unique in DB
                // Save TransID to session for use in DB
                $_SESSION['TransId']=$transId;
                // Verify payment
                $result = verify($api,$transId);
                $result = json_decode($result);
                // var_dump($result);
                if($result->status) { //On successFull payment
                    $output=saveToDB(); // save Data to DB
                    $paid=((int)($result->amount))/10;                    
                    if(empty($output['error'])){ //SuccesFull save To DB
                            $trackingCode=$output['TrackingCode'];
                            $sucessMsg="آقای/خانم"."  <strong>".$_SESSION['Applicant']['FirstName_fa']." ".$_SESSION['Applicant']['LastName_fa']."</strong>  "."ثبت نام شما با موفقیت انجام شد.";
                            echo "<script type=\"text/javascript\">
                            $(document).ready(function() {
                                $(\"#resultContainer\").find(\".panel-heading\").css(\"background-color\",\"green\").css(\"background-image\", \"linear-gradient(to bottom,SpringGreen 0,MediumSeaGreen 100%)\");
                            $(\"#result\").html(\"$sucessMsg\").removeClass(\"text-danger\").addClass(\"text-success\").show();
                            $(\"#amount\").html(\"مبلغ پرداختی: $paid تومان\").show();
                            $(\"#transId\").html(\"شماره تراکنش: $transId \").show();
                            $(\"#trackingCode\").html(\"کد رهگیری:  $trackingCode \").show();
                            $(\"#resultContainer\").show();
                            });
                            </script>";
                            if($traceNumber){
                                echo "<script type=\"text/javascript\">
                                $(document).ready(function() {
                                $(\"#traceNumber\").html(\"کد رهگیری بانکی:  $trackingCode \").show();
                                });
                                </script>";                               
                            }
                            unset($_SESSION['Applicant']);
                            unset($_SESSION['Spouse']);
                            unset($_SESSION['Children']);
                            unset($_SESSION['Price']);
                            unset($_SESSION['TransId']);
                        }
                    else{    // Save to DB Failed
                            echo "<script type=\"text/javascript\">
                            $(document).ready(function() {
                            $(\"#resultContainer\").find(\".panel-heading\").css(\"background-color\",\"red\").css(\"background-image\", \"linear-gradient(to bottom,IndianRed	 0,FireBrick 100%)\");
                            $(\"#result\").html(\"<p>متاسفانه در حال حاضر قادر به ذخیره اطلاعات شما در سرور نیستیم.</p><p>لطفا اطلاعات زیر را ذخیره کرده و با پشتیبانی تماس بگیرید</p>\").addClass(\"text-success\").addClass(\"text-danger\").show();
                            $(\"#amount\").html(\"مبلغ پرداختی: $paid تومان\").show();
                            $(\"#transId\").html(\"شماره تراکنش: $transId \").show();                    
                            $(\"#resultContainer\").show();
                        });
                           </script>";
                           
                }    
                } else { // No TransID is is Send
                    echo "<script type=\"text/javascript\">
                      $(document).ready(function() {
                      $(\"#resultContainer\").find(\".panel-heading\").css(\"background-color\",\"red\").css(\"background-image\", \"linear-gradient(to bottom,IndianRed	 0,FireBrick 100%)\");
                      $(\"#result\").html(\"<p>مشکلی در فرآیند پرداخت پیش آمده است.</p>\").addClass(\"text-danger\").show();
                      $(\"#transId\").html(\"شماره تراکنش: $transId \").show();
                      $(\"#resultContainer\").show();
                     });
                    </script>";
                    
                }
            } else { //duplicate TransAction
                echo "<script type=\"text/javascript\">
                $(document).ready(function() {
                $(\"#resultContainer\").find(\".panel-heading\").css(\"background-color\",\"red\").css(\"background-image\", \"linear-gradient(to bottom,IndianRed	 0,FireBrick 100%)\");
                $(\"#result\").html(\"<p>خطا در فرآیند پرداخت: شماره تراکنش تکراری است.</p>\").addClass(\"text-danger\").show();
                $(\"#transId\").html(\"شماره تراکنش: $transId \").show();
                $(\"#resultContainer\").show();
               });
              </script>";
              
            }
        }
// Function to check uniqness of TransID in DB
function isUniqueTransId($TransId){
        // see if transId is uinque in the database
    include_once("scripts/config.php");
    try {
        $conn = new PDO("mysql:host=$db_servername;dbname=mygreencard;charset=utf8", $db_username, $db_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
            die($e->getMessage());
    }
    try {
        $stmt = $conn->query("SELECT * FROM applicant WHERE TransID=$TransId");
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    // check Uniqness of transacition
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $storedTransId = $row['TransID'];
    if(empty($results)){
        return true;
    } else {
        return false;
    }
    }
?>

    <body>
        <nav>
        </nav>
        <header>
            <h1 class=" page-header text-center">فرم ثبت نام در قرعه کشی گرین کارت آمریکا</h1>
            <div class="container row text-justify hidden-print" id="progressBar">
                <ul class="list-inline">
                    <li>شروع ثبت نام</li>
                    <li>مشخصات فردی</li>
                    <li>مشخصات همسر و فرزندان</li>
                    <li>تائید و پرداخت</li>
                    <li>پایان ثبت نام و دریافت کد پیگیری</li>
                </ul>
            </div>
        </header>
        <div id="redirectContainer" class="formStage container">
            <div class="panel panel-primary" id="finalNotice">
                <div class="panel-heading">پرداخت</div>
                <div class="panel-body">
                    <div class="row col-sm-12 text-center" id="instruction" style='margin-bottom:20px;'>در حال انتقال به سایت پرداخت.
                        <br/> لطفا صبر کنید.</div>
                </div>
            </div>
            <div class="row col-sm-12 text-center">
                <input type="button" class="btn btn-primary" id="goToHome" value="صفحه اصلی" onclick='document.location.href="index.php";'>
                <input type="button" class="btn btn-primary" id="contactUs" value="تماس با پشتیبانی" onclick='document.location.href="contact-us.php";'>
            </div>
        </div>
        <!-- Begin of Final stage-Show Tracking Code and TransID -->
        <div id="resultContainer" class="formStage container">
            <div id="printTitle" class='text-center visible-print'>رسید ثبت نام در سایت MYGreenCard.ir</div>
            <div class="panel panel-primary" id="finalNotice">
                <div class="panel-heading">نتیجه ثبت نام</div>
                <div class="panel-body">
                    <div class="row col-sm-12 resultItem" id="result"></div>
                    <div class="row col-sm-12 resultItem" id="trackingCode"></div>
                    <div class="row col-sm-12 resultItem" id="amount"></div>
                    <div class="row col-sm-12 resultItem" id="traceNumber"></div>
                    <div class="row col-sm-12 resultItem" id="transId"></div>
                    <div class="row col-sm-12" id="description" style='margin-top:20px;'>
                        <p>لطفا برای مراجعات بعدی این رسید را نگه داری فرمائید.</p>
                        <p> با تشکر از شما</p>
                    </div>

                </div>
            </div>
            <div class="row col-sm-12 text-center">
                <input type="button" class="btn btn-primary" id="printResult" value="چاپ" onclick="window.print();">
                <input type="button" class="btn btn-primary" id="goToHome" value="صفحه اصلی" onclick='document.location.href="index.php";'>
                <input type="button" class="btn btn-primary" id="contactUs" value="تماس با پشتیبانی" onclick='document.location.href="contact-us.php";'>
            </div>
        </div>
        <footer>
        </footer>
    </body>

</html>