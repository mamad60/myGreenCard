<!DOCTYPE html>
<?php session_start(); ?>
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
    <!-- Font Awsomr -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Site Specefic -->
    <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"></script>
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

</head>

<body>
    <nav></nav>
    <?php
    include_once("scripts/config.php");
    $authContainer = '    <div id="authonticationError" class="text-center text-danger">شما اجازه دسترسی به این صفحه را ندارید.</div>
    ';
    $username = "";
    if (!isset($_SESSION["Authonticated"]) || !$_SESSION["Authonticated"]) {
        echo $authContainer;
        echo "<script type=\"text/javascript\">
                // Load Header
                $('nav').load('menu.html');                
                setTimeout(function(){history.back();}, 3000);
            </script>";
        exit;
    }
    if (isset($_SESSION["AdminUser"])) {
        $admin_user = $_SESSION["AdminUser"];
    }

    ?>
        <div id="adminPage" class="container">
            <div class="container" id="topStrip">
                <div class="col-md-6 text-right" id="welcomeMessage">
                    مدیر محترم کاربر
                    <?php echo $admin_user ?> خوش آمدید
                </div>
                <div class="col-md-6 text-left">
                    <a href="#" id="logout">خروج</a>
                </div>
            </div>
            <div class="row col-sm-12 text-center">
                <input type="button" class="btn btn-success" id="registerRecord" value="ثبت نام">
            </div>

            <div class="row col-sm-12 text-center">
                <span id="recordNumber" class="text-left"></span>
                <input type="button" class="btn btn-primary" id="nextRecord" value="رکورد بعدی">
                <input type="button" class="btn btn-primary" id="prevRecord" value="رکورد قبلی">
                <input type="button" class="btn btn-primary" id="firstRecord" value="اولین رکورد">
                <input type="button" class="btn btn-primary" id="lastRecord" value="آخرین رکورد">
                <input type="button" class="btn btn-primary" id="reLoad" value="بازخوانی">
            </div>
            <div class="row col-sm-12 text-center" id="summray">
                <small class="col-sm-3">
                    همسر:
                    <span id="s_spouse"></span>
                </small>
                <small class="col-sm-3">
                    تعداد فرزندان:
                    <span id="s_childNum"></span>
                </small>
                <small class="col-sm-3">
                    ثبت نام همسر:
                    <span id="s_spouseReg"></span>
                </small>
                <small class="col-sm-">
                    ثبت نام شده:
                    <span id="s_registered"></span>
                </small>
            </div>
            <form method="post" enctype="multipart/form-data" class="form-horizontal container" role="form" id="resultForm">
                <div id="applicant" class="stage">
                    <!--==Applicant Info==-->
                    <h3>مشخصات فرد متقاضی</h3>
                    <!--Personal Info-->
                    <fieldset>
                        <legend>1-مشخصات فردی</legend>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainFirstName_fa" class="col-md-6 control-label">نام(فارسی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="mainFirstName_fa" id="mainFirstName_fa" class="form-control" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainLastName_fa" class="col-md-6 control-label">نام خانوادگی(فارسی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="mainLastName_fa" class="form-control" id="mainLastName_fa" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainFirstName_en" class="col-md-6 control-label">نام(انگلیسی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="mainFirstName_en" class="form-control" id="mainFirstName_en" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainLastName_en" class="col-md-6 control-label">نام خانوادگی(انگلیسی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="mainLastName_en" class="form-control" id="mainLastName_en" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainGender" class="col-md-6 control-label">جنسیت:</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="mainGender" id="mainGender" class="form-control" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainBirthDate" class="col-md-6 control-label">تاریخ تولد(شمسی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" class="form-control" name="mainBirthDate" id="mainBirthDate" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="Georgian_mainBirthDate" class="col-md-6 control-label">تاریخ تولد(میلادی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" class="form-control" name="Georgian_mainBirthDate" id="Georgian_mainBirthDate" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy" type="button">
                                        <i class="fa fa-copy "></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainBirthCity" class="col-md-6 control-label">شهر محل تولد:</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="mainBirthCity" class="form-control" id="mainBirthCity" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainBirthCountry" class="col-md-6 control-label">کشور محل تولد:</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="mainBirthCountry" class="form-control" id="mainBirthCountry" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </fieldset>
                    <!--===========Picture============-->
                    <hr class="style-four">
                    <fieldset>
                        <legend>2-عکس متقاضی</legend>
                        <div class=" form-group form-group-sm row col-sm-12">
                            <a href="" id="mainPhotoLink" download="mainPhoto">
                                <img src="" id="mainPhoto" name="mainPhoto" style="width:120px;height:120px;">
                            </a>
                            <button class="btn btn-default btn-sm imgCopy" type="button" onclick="copyToClipboard(this)">
                                <i class="fa fa-copy"></i>
                                <span>کپی آدرس عکس</span>
                            </button>
                        </div>
                    </fieldset>
                    <hr class="style-four">
                    <!--===========Contact Info============-->
                    <fieldset>
                        <legend>3-اطلاعات تماس</legend>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainAddress" class="col-md-4 control-label ">آدرس کامل:</label>
                            <div class="input-group col-md-8">
                                <textarea name="mainAddress" class="form-control " id="mainAddress" rows="1" readonly></textarea>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainZipCode" class="col-md-6 control-label ">کدپستی(اختیاری):</label>
                            <div class="input-group col-md-6">
                                <input type="tel" name="mainZipCode" class="form-control " id="mainZipCode" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainEmail" class="col-md-6 control-label ">آدرس ایمیل:</label>
                            <div class="input-group col-md-6">
                                <input type="email" name="mainEmail" class="form-control " id="mainEmail" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainTelNumber" class="col-md-6 control-label ">شماره همراه:</label>
                            <div class="input-group col-md-6">
                                <input type="tel" name="mainTelNumber" class="form-control " id="mainTelNumber" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </fieldset>
                    <hr class="style-four">
                    <!--===========mainEducation============-->
                    <fieldset>
                        <legend>4-اطلاعات تحصیلی</legend>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainEducation" class="col-md-5 control-label ">سطح تحصیلات:</label>
                            <div class="input-group col-md-7">
                                <input type="text" name="mainEducation" class="form-control " id="mainEducation" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </fieldset>
                    <hr class="style-four">
                    <!--===========Marital Status============-->
                    <fieldset>
                        <legend>5-وضعیت تاهل</legend>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainMaridgStatus" class="col-md-6 control-label ">وضعیت تاهل:</label>
                            <div class="input-group col-md-6">
                                <input type="tel" name="mainMaridgStatus" class="form-control " id="mainMaridgStatus" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="mainChildNumber" class="col-md-6 control-label ">تعداد فرزندان:</label>
                            <div class="input-group col-md-6">
                                <input type="tel" name="mainChildNumber" class="form-control" id="mainChildNumber" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div id="spouse" class="stage">
                    <!--==Applicant Info==-->
                    <h3>مشخصات همسر</h3>
                    <!--Personal Info-->
                    <fieldset>
                        <legend>1-مشخصات فردی همسر</legend>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="spouseFirstName_fa" class="col-md-6 control-label">نام(فارسی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="spouseFirstName_fa" id="spouseFirstName_fa" class="form-control" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="spouseLastName_fa" class="col-md-6 control-label">نام خانوادگی(فارسی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="spouseLastName_fa" class="form-control" id="spouseLastName_fa" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="spouseFirstName_en" class="col-md-6 control-label">نام(انگلیسی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="spouseFirstName_en" class="form-control" id="spouseFirstName_en" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="spouseLastName_en" class="col-md-6 control-label">نام خانوادگی(انگلیسی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="spouseLastName_en" class="form-control" id="spouseLastName_en" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="spouseGender" class="col-md-6 control-label">جنسیت:</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="spouseGender" id="spouseGender" class="form-control" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="spouseBirthDate" class="col-md-6 control-label">تاریخ تولد(شمسی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" class="form-control" name="spouseBirthDate" id="spouseBirthDate" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="Georgian_spouseBirthDate" class="col-md-6 control-label">تاریخ تولد(میلادی):</label>
                            <div class="input-group col-md-6">
                                <input type="text" class="form-control" name="Georgian_spouseBirthDate" id="Georgian_spouseBirthDate" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy" type="button">
                                        <i class="fa fa-copy "></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="spouseBirthCity" class="col-md-6 control-label">شهر محل تولد:</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="spouseBirthCity" class="form-control" id="spouseBirthCity" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-sm-4">
                            <label for="spouseBirthCountry" class="col-md-6 control-label">کشور محل تولد:</label>
                            <div class="input-group col-md-6">
                                <input type="text" name="spouseBirthCountry" class="form-control" id="spouseBirthCountry" readonly>
                                <span class="input-group-btn btn-group-sm">
                                    <button class="btn btn-default copy " type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </fieldset>
                    <!--===========Picture============-->
                    <hr class="style-four">
                    <fieldset>
                        <legend>2-عکس همسر</legend>
                        <div class=" form-group form-group-sm row col-sm-12">
                            <a href="" id="spousePhotoLink" download="spousePhoto">
                                <img src="" id="spousePhoto" name="spousePhoto" style="width:120px;height:120px;">
                            </a>
                            <button class="btn btn-default btn-sm imgCopy" type="button" onclick="copyToClipboard(this)">
                                <i class="fa fa-copy"></i>
                                <span>کپی آدرس عکس</span>
                            </button>
                        </div>
                    </fieldset>
                </div>
                <div id="children" class="stage">
                    <h3>مشخصات فرزندان</h3>
                    <div id="childTemplate" stye="display:none">
                        <!--==children Info==-->
                        <!--Personal Info-->
                        <fieldset>
                            <legend>1-مشخصات فردی فرزند</legend>
                            <div class="form-group form-group-sm col-sm-4">
                                <label for="childFirstName_fa" class="col-md-6 control-label">نام(فارسی):</label>
                                <div class="input-group col-md-6">
                                    <input type="text" name="childFirstName_fa" id="childFirstName_fa" class="form-control" readonly>
                                    <span class="input-group-btn btn-group-sm">
                                        <button class="btn btn-default copy " type="button">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group form-group-sm col-sm-4">
                                <label for="childLastName_fa" class="col-md-6 control-label">نام خانوادگی(فارسی):</label>
                                <div class="input-group col-md-6">
                                    <input type="text" name="childLastName_fa" class="form-control" id="childLastName_fa" readonly>
                                    <span class="input-group-btn btn-group-sm">
                                        <button class="btn btn-default copy " type="button">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group form-group-sm col-sm-4">
                                <label for="childFirstName_en" class="col-md-6 control-label">نام(انگلیسی):</label>
                                <div class="input-group col-md-6">
                                    <input type="text" name="childFirstName_en" class="form-control" id="childFirstName_en" readonly>
                                    <span class="input-group-btn btn-group-sm">
                                        <button class="btn btn-default copy " type="button">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group form-group-sm col-sm-4">
                                <label for="childLastName_en" class="col-md-6 control-label">نام خانوادگی(انگلیسی):</label>
                                <div class="input-group col-md-6">
                                    <input type="text" name="childLastName_en" class="form-control" id="childLastName_en" readonly>
                                    <span class="input-group-btn btn-group-sm">
                                        <button class="btn btn-default copy " type="button">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group form-group-sm col-sm-4">
                                <label for="childGender" class="col-md-6 control-label">جنسیت:</label>
                                <div class="input-group col-md-6">
                                    <input type="text" name="childGender" id="childGender" class="form-control" readonly>
                                    <span class="input-group-btn btn-group-sm">
                                        <button class="btn btn-default copy " type="button">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group form-group-sm col-sm-4">
                                <label for="childBirthDate" class="col-md-6 control-label">تاریخ تولد(شمسی):</label>
                                <div class="input-group col-md-6">
                                    <input type="text" class="form-control" name="childBirthDate" id="childBirthDate" readonly>
                                    <span class="input-group-btn btn-group-sm">
                                        <button class="btn btn-default copy " type="button">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group form-group-sm col-sm-4">
                                <label for="Georgian_childBirthDate" class="col-md-6 control-label">تاریخ تولد(میلادی):</label>
                                <div class="input-group col-md-6">
                                    <input type="text" class="form-control" name="Georgian_childBirthDate" id="Georgian_childBirthDate" readonly>
                                    <span class="input-group-btn btn-group-sm">
                                        <button class="btn btn-default copy" type="button">
                                            <i class="fa fa-copy "></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group form-group-sm col-sm-4">
                                <label for="childBirthCity" class="col-md-6 control-label">شهر محل تولد:</label>
                                <div class="input-group col-md-6">
                                    <input type="text" name="childBirthCity" class="form-control" id="childBirthCity" readonly>
                                    <span class="input-group-btn btn-group-sm">
                                        <button class="btn btn-default copy " type="button">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group form-group-sm col-sm-4">
                                <label for="childBirthCountry" class="col-md-6 control-label">کشور محل تولد:</label>
                                <div class="input-group col-md-6">
                                    <input type="text" name="childBirthCountry" class="form-control" id="childBirthCountry" readonly>
                                    <span class="input-group-btn btn-group-sm">
                                        <button class="btn btn-default copy " type="button">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </fieldset>
                        <!--===========Picture============-->
                        <hr class="style-four">
                        <fieldset>
                            <legend>2-عکس فرزند</legend>
                            <div class=" form-group form-group-sm row col-sm-12">
                                <a href="" id="childPhotoLink" download="childPhoto">
                                    <img src="" id="childPhoto" name="childPhoto" style="width:120px;height:120px;">
                                </a>
                                <button class="btn btn-default btn-sm imgCopy" type="button" onclick="copyToClipboard(this)">
                                    <i class="fa fa-copy"></i>
                                    <span>کپی آدرس عکس</span>
                                </button>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div id="register-template" class="stage">
                    <fieldset>
                        <h2 class="row col-sm-12"> ثبت نام</h2>
                        <div>
                            <h4 class="row col-sm-12"> چک لیست ثبت نام:</h4>
                            <div class="col-sm-4" id="applicantReg-template">
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="">ثبت نام متقاضی
                                </label>
                            </div>
                            <div class="col-sm-4" id="spouseReg-template">
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="">ثبت نام همسر
                                </label>
                            </div>
                            <div class="col-sm-4" id="childReg-template">
                                <label class="checkbox-inline" id="childCheck-template">
                                    <input type="checkbox" value=""><span> ثبت نام فرزند 1</span>
                                </label>
                            </div>
                            <div class="col-sm-12" id="spouseRegToo-template">
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="">آیا تمامی این موارد را برای همسر متقاضی نیز انجام داده اید(ثبت نام همسر)؟
                                </label>
                            </div>
                        </div>
                        <div class="row col-sm-12" id="regCodes-template">
                            <h4 class="row col-sm-12">کد ثبت نام سایت DV-Lottery:</h4>
                            <div class="col-sm-6">
                                <label for="siteRegCode">کد ثبت نام متقاضی:</label>
                                <input type="text" id="siteRegCode-template" value="">
                            </div>
                            <div class="col-sm-6" id="spouseRegCode-template">
                                <label for="siteRegCodeSpouse">کد ثبت نام همسر:</label>
                                <input type="text" id="siteRegCodeSpouse-template" value="">
                            </div>
                            <div class="row col-sm-12 text-center" id="registerMessage-template"></div>
                            <div class="row col-sm-12 text-center">
                                <input type="button" class="btn btn-success" id="finalRegister-template" value="ثبت نام متقاضی">
                            </div>
                        </div>
                    </fieldset>
                </div>


                <div class="row col-sm-12 text-center">
                    <span id="recordNumber1" class="text-left"></span>
                    <input type="button" class="btn btn-primary" id="nextRecord1" value="رکورد بعدی">
                    <input type="button" class="btn btn-primary" id="prevRecord1" value="رکورد قبلی">
                    <input type="button" class="btn btn-primary" id="firstRecord1" value="اولین رکورد">
                    <input type="button" class="btn btn-primary" id="lastRecord1" value="آخرین رکورد">
                    <input type="button" class="btn btn-primary" id="reLoad1" value="بازخوانی">
                </div>
                <div class="row col-sm-12 text-center">
                    <input type="button" class="btn btn-success" id="registerRecord1" value="ثبت نام">
                    <input type="button" class="btn btn-danger" id="deleteRecord" value="حذف">
                </div>
            </form>

            <!--Search Box-->
            <form id="searchForm" class="form-inline clearfix">
                <legend>جستجو:</legend>
                <div class="form-group form-group-sm">
                    <label for="searchID" class="control-label">ID: </label>
                    <input type="tel" name="searchID" class="form-control" id="searchID">
                </div>
                <div class="form-group form-group-sm">
                    <label for="searchTrackingCode">کد رهگیری: </label>
                    <input type="text" name="searchTrackingCode" class="form-control" id="searchTrackingCode">
                </div>
                <div class="form-group form-group-sm">
                    <label for="searchTransID" class="control-label">شماره تراکنش: </label>
                    <input type="tel" name="searchTransID" class="form-control" id="searchTransID">
                </div>
                <div class="form-group form-group-sm">
                    <label for="searchTrackingCode">کد رهگیری: </label>
                    <input type="text" name="searchTrackingCode" class="form-control" id="searchTrackingCode">
                </div>
                <div class="form-group form-group-sm">
                    <label for="searchFirstName" class="control-label">نام(فارسی): </label>
                    <input type="text" name="searchFirstName" class="form-control" id="searchFirstName">
                </div>
                <div class="form-group form-group-sm">
                    <label for="searchLastName" class="control-label">نام خانوادگی(فارسی): </label>
                    <input type="text" name="searchLastName" class="form-control" id="searchLastName">
                </div>
                <div class="text-center">
                    <input type="button" class="btn btn-primary" value="اجرا" id="searchSubmit">
                    <input type="reset" class="btn btn-danger" value="پاک کردن" id="SearchReset" style="margin-right:10px;">
                </div>
                <div id="adminSearchResult" class="row col-sm-12 text-center"></div>
            </form>
        </div>
        <footer></footer>
        <script src="js/clipboradjs/clipboard.min.js"></script>
        <script src="js/session.js"></script>
        <script src="js/admin.js"></script>
</body>

</html>