<!DOCTYPE html>
<?php session_start();?>
<html lang="fa" dir="rtl">
<head>
    <title>صفحه مدیریت-ثبت نام لاتاری</title>
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
    <link rel="stylesheet" type="text/css" href="css/fontiran.css">
    <!-- Site Specefic -->
    <link rel="stylesheet" type="text/css" href="css/formStyle.css">

    <!--For old Browser use HTMLshiv-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--[if IE]>
		<script type="text/javascript">
			 var console = { log: function() {} };
		</script>
    <![endif]-->

    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
        #loginForm{ width:200px; margin-top:30px; margin-bottom:30px; margin: 0; position: absolute; top: 50%; left: 50%; transform:
        translate(-50%, -50%); } #userName, #password{ direction:ltr; text-align: center; }
        #loginError{
            display:none;
        }
        </style>
</head>
<body>
    <nav></nav>
    <header>
    </header>
    <?php
    include_once("scripts/config.php");
    //IF Admin is autohonticated direcrly go to admin page
    if(isset($_SESSION['Authonticated']))
    {
        if($_SESSION['Authonticated']){
        $go = "admin.php";
        header("Location: $go"); 
        }
    }
    // check login Attemps
    if(!isset($_SESSION['loginAttemps']))
    {
        $_SESSION['loginAttemps']=1; 
    } else {
        // Check for maximun login attemps
        if($_SESSION['loginAttemps']>3)
        {
                echo "<script type=\"text/javascript\">
                $(document).ready(function() {
                $(\"#loginError\").text(\"حداکثر تعداد ورودهای مجاز\").delay(3000).fadeIn();
               });
               </script>";  
               $go = "index.php";
               unset($_SESSION['loginAttemps']);                             
               header("Location: $go"); 
        }else{
        $_SESSION['loginAttemps']++;        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userName"]) && isset($_POST["password"])) {
        $user_name = test_input($_POST["userName"]);
        $user_password= test_input($_POST["password"]);
    // check user name and password
    if($user_name==$admin_user && $user_password==$admin_password){ 
        // if userneme and password  match
        echo "<script type=\"text/javascript\">
        $(document).ready(function() {
        $(\"#loginError\").hide();
        $(\"#loginForm\").fadeOut(\"slow\");
       });
       </script>";
       $_SESSION['Authonticated']=true;
       $_SESSION['AdminName']=$user_name;       
       $go = "admin.php";
       header("Location: $go");
    }
    else{
        // if userneme and password  match
        echo "<script type=\"text/javascript\">
        $(document).ready(function() {
        $(\"#loginError\").fadeIn();
       });
       </script>";  
    }
}
    function test_input($data) {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    ?>
        <form class="container" id="loginForm" method="POST" action="">
            <div class="row form-control-static text-danger" id="loginError">
                نام کاربری یا رمز عبور اشتباه است.
            </div>
            <div class="row form-group">
                <label for="userName" class="form-label">نام کاربری: </label>
                <br>
                <input name="userName" class="form-control" id="userName" type="text" required>
            </div>
            <div class="row form-group">
                <label for="password" class="form-label">رمز ورود: </label>
                <br>
                <input name="password" class="form-control" id="password" type="password" required>
            </div>
            <div class="row text-center">
                <input type="submit" class="btn btn-primary" value="ورود" id="submit">
                <input type="reset" class="btn btn-danger" value="پاک کردن" id="reset" style="margin-right:10px;">
            </div>
        </form>
        <footer></footer>
        <script>
            $(document).ready(function () {
                //Load header and Footer
                //====header
                $('nav').load('menu.html', function () {
                    //===make current Page Active
                    $('#myNavbar').find('li a[href="' + window.location.pathname.split('/').pop() +
                            '"]').parent()
                        .addClass('active');
                });
            //     //===Footer
            //     $('footer').load('footer.html', function () {
            //     });
            });
        </script>
</body>

</html>