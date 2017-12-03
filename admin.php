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
        #authonticationError {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            font-size: 20px;
        }

        #userName,
        #password {
            direction: ltr;
            text-align: center;
        }

        #adminPage {
            display: none;
        }

        #topStrip {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        #adminSearchLabel {
            font-weight: bold;
        }

        #searchResult {
            font-size: 16px;
            margin-top: 1px;
            margin-bottom: 10px;
        }

        @media (min-width: 768px) {
            .form-inline .form-group {
                margin-bottom: 5px;
                margin-right:5px;
            }
            .form-inline .form-group .form-control {
                max-width: 120px;
            }
            #searchID,#searchTransID {
                max-width: 60px;
            }
        }
    </style>
</head>

<body>
    <nav></nav>
    <?php
    include_once("scripts/config.php");       
    $username="";
    if(isset($_SESSION["AdminUser"])){
        $admin_user=$_SESSION["AdminUser"];
    }
    if (isset($_SESSION["Authonticated"])) {
        if($_SESSION["Authonticated"]){
            echo "<script type=\"text/javascript\">
            $(document).ready(function() {
            $(\"#authonticationError\").hide();        
            $(\"#adminPage\").fadeIn();
            });
            </script>";
    } else{
    // if not Authonticated
        echo "<script type=\"text/javascript\">
        $(document).ready(function() {
        $(\"#authonticationError\").fadeIn();
        });
        setTimeout(function(){history.back();}, 3000);
        </script>";
    }       
    } else {
        // if not Authonticated
        echo "<script type=\"text/javascript\">
        $(document).ready(function() {
        $(\"#authonticationError\").fadeIn();
        });
        setTimeout(function(){history.back();}, 3000);
        </script>";
    }
        ?>
        <div id="authonticationError" class="text-center text-danger">شما اجازه دسترسی به این صفحه را ندارید.</div>
        <div id="adminPage" class="container">
            <div class="container" id="topStrip">
                <div class="col-md-6 text-right" id="welcomeMessage">
                    مدیر محترم کاربر
                    <?php echo $admin_user?> خوش آمدید
                </div>
                <div class="col-md-6 text-left">
                    <a href="#" id="logout">خروج</a>
                </div>
            </div>
            <!--Search Box-->
            <form id="searchForm" class="form-inline">
                    <div class="form-group">
                        <label for="searchID" class="control-label">ID: </label>
                        <input type="tel" name="searchID" class="form-control" id="searchID">
                    </div>
                    <div class="form-group">
                        <label for="searchTrackingCode">کد رهگیری: </label>
                        <input type="text" name="searchTrackingCode" class="form-control" id="searchTrackingCode">
                    </div>
                    <div class="form-group">
                        <label for="searchTransID" class="control-label">شماره تراکنش: </label>
                        <input type="tel" name="searchTransID" class="form-control" id="searchTransID">
                    </div>
                    <div class="form-group">
                        <label for="searchTrackingCode">کد رهگیری: </label>
                        <input type="text" name="searchTrackingCode" class="form-control" id="searchTrackingCode">
                    </div>
                    <div class="form-group">
                        <label for="searchFirstName" class="control-label">نام(فارسی): </label>
                        <input type="text" name="searchFirstName" class="form-control" id="searchFirstName">
                    </div>
                    <div class="form-group">
                        <label for="searchLastName" class="control-label">نام خانوادگی(فارسی): </label>
                        <input type="text" name="searchLastName" class="form-control" id="searchLastName">
                    </div>
                    <div class="text-center">
                        <input type="button" class="btn btn-primary" value="اجرا" id="searchSubmit">
                        <input type="reset" class="btn btn-danger" value="پاک کردن" id="SearchReset" style="margin-right:10px;">
                    </div>
                    <sp id="searchResult" class="row col-sm-12 text-right">خلاصه نتیجه جستجو:  <span id="adminSearchResult"></span></div>
            </form>
        </div>
        <footer></footer>
        <script>
            $(document).ready(function () {
                //Load header and Footer
                //====header
                $('nav').load('menu.html');
                // bind event to logout
                $('#logout').click(function () {
                    $.post("scripts/ajaxphpfunctions.php", {
                        "function": "admin_logout"
                    });
                    // go back
                    window.location.href = 'index.php';
                });
                // bind event to Serch Form Submit
                $('#searchSubmit').click(function () {
                    // Fire off the request to form.php
                    var dataSend = $('#searchForm').serialize();
                    dataSend += "&function=admin_query"
                    var request = $.ajax({
                        url: "scripts/ajaxphpfunctions.php",
                        type: 'post',
                        dataType: 'JSON',
                        data: dataSend
                    }).done(function (response) {
                        // Sucssessful
                        if (!response.error) {
                            $('#adminSearchResult').text(response.message).removeClass(
                                'text-danger').addClass('text-success');
                        } else {
                            $('#adminSearchResult').text(response.message).removeClass(
                                'text-success').addClass('text-danger');
                        }
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        // Log the error to the console
                        console.error('The following error occurred: ' + textStatus,
                            errorThrown)
                        $('#adminSearchResult').text(
                            "مشکلی در ارسال و دریافت اطلاعات رخ داده است.").removeClass(
                            'text-success').addClass('text-danger');
                        return false;
                    });;
                });
            });
        </script>

</body>

</html>