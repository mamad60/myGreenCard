<!DOCTYPE html>
<?php 
    include_once  'scripts/securimage/securimage.php';
?>

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
        <!-- optionally uncomment line below if using a theme or icon set like font awesome (note that default icons used are glyphicons and `fa` theme can override it) -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!--BoottStrap-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">l
    <!---=============BootStrap RTL-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap-rtl.min.css">
    <link href="css/bootstrap-fileinput/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <link href="css/bootstrap-fileinput/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" />
    <!--Persian Date/Time Picker Plugin-->
    <link rel="stylesheet" href="css/persianDateTimePicker/jquery.Bootstrap-PersianDateTimePicker.css" />
    <link rel="stylesheet" href="css/bootstrapvalidator/bootstrapValidator.min.css" />
    <!-- Secure Image Rotating -->
    <link rel="stylesheet" href="scripts/securimage/securimage.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/fontiran.css">;
    <!--site specefic-->
    <link rel="stylesheet" href="css/formstyle.css" type="text/css">
    <link rel="stylesheet" href="css/formprint.css" type="text/css">
    <!--For old Browser use HTMLshiv-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
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
    <div id="preStageContainer" class="formStage container">
        <h3 class="row col-xs-12 text-justify">به صفحه ثبت نام در قرعه کشی گرین کارت آمریکا خوش آمدید</h3>
        <h4 class="row col-xs-12 text-justify">لطفا قبل از شروع به ثبت نام به نکات زیر توجه فرمائید: </h4>
        <div class="row col-xs-12 text-justify">
            <ul class="list-group row">
                <li class="list-group-item list-group-item-info" style="margin-right: 10px">قبل از ثبت نام حتما عکس خود, , همسر و فرزندان خود را طبق راهنمای های این صفحه آماده کنید</li>
                <li class="list-group-item list-group-item-warning" style="margin-right: 10px">در حین مراحل ثبت نام و قبل از تکمیل ثبت نام و دریافت کد پیگیری اکیدا از دکمه های Back و Forward مرورگر استفاده
                    نکرده و صفحه را Refresh نکنید در غیر این صورت اطلاعات به درستی ذخیره نخواهند شد. </li>
            </ul>
        </div>
        <form class="form-horizontal" method="POST">
            <div class="form-group row col-xs-12">
                <label for="captcha_code" class="form-label">لطفا برای شروع ثبت نام کد تصویر زیر را وارد کنید:</label>
                <br/>
                <div class="text-center">
                    <div style="width:240px;margin:0px auto">
                        <?php
                            $options = array('securimage_path' => 'scripts/securimage','disable_flash_fallback'=>true,'show_text_input'=>false,'icon_size'=>28);
                            echo Securimage::getCaptchaHtml($options);
                        ?>
                        <br>
                            <input name="captcha_code" id="captcha_code" type="text" value="" maxlength="4" style="width:190px; margin-right:50px;"
                                autofocus>
                            <div id="captchaError" class="text-danger" style="display:none;margin-right:50px;">
                                <p>کد وارد شده صحیح نیست</p>
                            </div>
                    </div>

                </div>
                <div class="col-xs-12 text-center">
                    <input type="button" class=" btn btn-primary" value="ارسال و شروع ثبت نام" id="captchaSubmit">
                    <input type="button" class="btn btn-primary" id="goToHome" value="صفحه اصلی" onclick='document.location.href="index.php";'>
                </div>
            </div>
        </form>
        <div class="row col-xs-12 text-justify">
            <ul class="list-group row">
                <li class="list-group-item list-group-item-text" style="margin-right: 10px">با شروع ثبت نام شما با شرایط .استفاده موافقت می کنید</li>
                <li class="list-group-item list-group-item-text" style="margin-right: 10px">بعد از ثبت نام توسط ما تائیدیه ثبت نام به آدرس ایمیل یا تلگرام شما ارسال خواهد شد.</li>
                <li class="list-group-item list-group-item-text" style="margin-right: 10px">در صورت دارا بودن شرایط , شما می توانید با یک بار ثبت نام در سایت ما, تقاضای ثبت نام همسر خود را نیز داشته
                    باشید و شانس برنده شدن در لاتاری گرین کارت خود را دو برابر کنید.</li>
            </ul>
        </div>
    </div>

    <div id="firstStageContainer" class="formStage container">
        <!--Main Applicant-->
        <form method="post" enctype="multipart/form-data" class="form-horizontal" role="form" id="mainApplicantForm">
            <!--==Applicant Info==-->
            <h2>مرحله 1: مشخصات فرد متقاضی</h2>
            <div class="row text-center text-danger" id="firstStageError" style="display:none;"><i class="fa fa-times fa-lg" style="margin-left: 5px;"></i>لطفا خطاهای قسمت های قرمز رنگ را اصلاح کرده و فرم را مجددا ارسال فرمائید.</div>
            <!--Personal Info-->
            <fieldset>
                <legend>1-مشخصات فردی</legend>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mainFirstName_fa" class="col-md-4 control-label">نام(فارسی):</label>
                        <div class="col-md-8">
                            <input type="text" name="mainFirstName_fa" id="mainFirstName_fa" class="form-control" placeholder="نام فارسی" maxlength="33"
                                autofocus>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mainLastName_fa" class="col-md-4 control-label">نام خانوادگی(فارسی):</label>
                        <div class="col-md-8">
                            <input type="text" name="mainLastName_fa" class="form-control" id="mainLastName_fa" placeholder="نام خانوادگی فارسی" maxlength="33">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mainFirstName_en" class="col-md-4 control-label">نام(انگلیسی):</label>
                        <div class="col-md-8">
                            <input type="text" name="mainFirstName_en" class="form-control" id="mainFirstName_en" placeholder="First Name" maxlength="33">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mainLastName_en" class="col-md-4 control-label">نام خانوادگی(انگلیسی):</label>
                        <div class="col-md-8">
                            <input type="text" name="mainLastName_en" class="form-control" id="mainLastName_en" placeholder="Last/Family Name" maxlength="33">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mainGender" class="col-md-4 control-label  ">جنسیت:</label>
                        <div class="col-md-8 genderSelect">
                            <div class="col-xs-6">
                                <i class="fa fa-male" style="font-size:23px;"></i>
                                <label class="radio-inline ">
                                    <input type="radio" name="mainGender" value="male">مذکر</label>
                            </div>
                            <div class="col-xs-6">
                                <i class="fa fa-female " style="font-size:23px;"></i>
                                <label class="radio-inline">
                                    <input type="radio" name="mainGender" value="female">مونث</label>
                            </div>
                            <div id="mainGenderErrors"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mainDate" class="col-md-4 control-label">تاریخ تولد(شمسی):</label>
                        <div class="col-md-8 date">
                            <div class="input-group dateGroup" id="mainDate">
                                <div class="input-group-addon" id="mainBirthDate_AddOn">
                                    <span class="fa fa-calendar"></span>
                                </div>
                                <input type="text" class="form-control" name="mainBirthDate" id="mainBirthDate" placeholder="1390/1/1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mainBirthCity" class="col-md-4 control-label">شهر محل تولد:</label>
                        <div class="col-md-8">
                            <input type="text" name="mainBirthCity" class="form-control" id="mainBirthCity" placeholder="تهران(بدون نام استان یا منطقه)"
                                maxlength="20">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mainBirthCountry" class="col-md-4 control-label">کشور محل تولد:</label>
                        <div class="col-md-8">
                            <input type="text" name="mainBirthCountry" class="form-control" id="mainBirthCountry" placeholder="ایران" value="ایران" maxlength="20">
                        </div>
                    </div>
                </div>
            </fieldset>
            <!--===========Picture============-->
            <hr class="style-four">
            <fieldset>
                <legend>2-عکس متقاضی</legend>
                <div class="row col-sm-12">
                    <p class="form-text text-muted ">توجه!!!: عکس متقاضی باید در اندازه 600 در 600 بوده و حداکثر اندازه آن 240 کیلو بایت باشد </p>
                </div>
                <div class=" form-group row col-sm-12">
                    <label for="mainPhoto" class="control-label ">لطفا عکس پرسنلی خود را آپلود کنید:</label>
                    <div class="col-md-8 col-centered" style="max-width: none;">
                        <input class="form-control file-loading" id="mainPhoto" name="mainPhoto" type="file" accept="image/jpg,image/jpeg">
                        <small class="help-block" id="mainPhotoErrors" style="color:red;display:none;">آپلود عکس پرسنلی الزامی است.</small>
                    </div>
                </div>
            </fieldset>
            <hr class="style-four">
            <!--===========Contact Info============-->
            <fieldset>
                <legend>3-اطلاعات تماس</legend>
                <div class=" row col-sm-12 ">
                    <p id="contactHelper " class="form-text text-muted ">لطفا اطلاعات زیر را دقیق وارد کنید. تنها راه تماس ما با شما در صورت بروز مشکل از طریق زیر است.</p>
                </div>
                <div class=" col-sm-6 ">
                    <div class="form-group">
                        <label for="mainAddress" class="col-md-4 control-label ">آدرس کامل:</label>
                        <div class="col-md-8 ">
                            <textarea name="mainAddress" placeholder="آدرس کامل : کشور, استان , شهر و ..." class="form-control " id="mainAddress" rows="1"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="form-group">
                        <label for="mainZipCode" class="col-md-4 control-label ">کدپستی(اختیاری):</label>
                        <div class="col-md-8 ">
                            <input type="tel" name="mainZipCode" class="form-control " id="mainZipCode" placeholder="کدپستی 16 رقمی " maxlength="16">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="form-group ">
                        <label for="mainEmail" class="col-md-4 control-label ">آدرس ایمیل:</label>
                        <div class="col-md-8 ">
                            <input type="email" name="mainEmail" class="form-control " id="mainEmail" placeholder="someone@gmail.com " maxlength="30">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="form-group ">
                        <label for="mainTelNumber" class="col-md-4 control-label ">شماره همراه:</label>
                        <div class="col-md-8 ">
                            <input type="tel" name="mainTelNumber" class="form-control " id="mainTelNumber" placeholder="09120000000 " maxlength="11">
                        </div>
                    </div>
                </div>
            </fieldset>
            <hr class="style-four">
            <!--===========mainEducation============-->
            <fieldset>
                <legend>4-اطلاعات تحصیلی</legend>
                <div class="row col-sm-12 ">
                    <p id="mainEducationHelper " class="form-text text-muted ">توجه!!!: برای ثبت نام در قرعه کشی گرین کارت آمریکا شما باید حداقل  دارای مدرک 12 ساله(پیش دانشگاهی ) یا 3 سال
                        سابقه کار مورد تائید باشید.</p>
                </div>
                <div class=" col-sm-6 ">
                    <div class="form-group">
                        <label for="mainEducation" class="col-md-4 control-label ">سطح تحصیلات:</label>
                        <div class="col-md-8 ">
                            <select class="form-control " id="mainEducation" name="mainEducation">
                                <option value=" " disabled selected>انتخاب کنید</option>
                                <option value="Primary">ابتدائی</option>
                                <option value="Some Highschool">دبیرستان</option>
                                <option value="Vaccany">مدرک فنی حرفه ای</option>
                                <option value="Highschool">دبیرستان یا پیش دانشگاهی (12 ساله)</option>
                                <option value="2 Years University">کاردانی</option>
                                <option value="Bachelor">لیسانس</option>
                                <option value="Master">کارشناسی ارشد</option>
                                <option value="PhD">دکتری</option>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
            <hr class="style-four">
            <!--===========Marital Status============-->
            <fieldset>
                <legend>5-وضعیت تاهل</legend>
                <div class="row col-sm-12 ">
                    <p id="maridgeHelper " class="form-text text-muted ">لطفا دراین قسمت فقط تعداد فرزندان زیر 21 سال خود را که ازدواج نکرده اند وارد نمائید.</p>
                    <p id="maridgeHelper1 " class="form-text text-muted ">اگر همسرتان شهروند ایالات متحده یا دارای اقامت دائم است نیازی به وارد کردن اطلاعات او نیست.</p>
                </div>
                <div class=" col-sm-6 ">
                    <div class="form-group" id='mainMaridge_container'>
                        <label for="mainMaridgStatus" class="col-md-4 control-label ">وضعیت تاهل:</label>
                        <div class="col-md-8 ">
                            <select class="form-control " name="mainMaridgStatus" id="mainMaridgStatus">
                                <option value=" " disabled selected>انتخاب کنید</option>
                                <option value="Single">مجرد</option>
                                <option value="Married">متاهل</option>
                                <option value="Married Spouse US citizen">متاهل(همسر مقیم با شهروند آمریکا)</option>
                                <option value="Divorced">مطلقه</option>
                                <option value="Widowed">بیوه</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 ">
                    <div class="form-group">
                        <label for="mainChildNumber" class="col-md-4 control-label ">تعداد فرزندان:</label>
                        <div class="col-md-8 ">
                            <input type="tel" name="mainChildNumber" class="form-control" id="mainChildNumber" placeholder="0" min="0" max="10" maxlength="2"
                                size="5">
                        </div>
                    </div>
                </div>
            </fieldset>
            <hr class="style-four">
            <div class="row col-sm-12 text-center">
                <input type="button" class="btn btn-primary" id="nextStage1" value="ثبت و مرحله بعدی">
                <input type="reset" class="btn btn-primary" id="resetStage1" value="پاک کردن فرم">
            </div>
        </form>
    </div>
    <!---End of First Stage -->
    <!--===Spouse & Children Info Info=========-->
    <div id="secondStageContainer" class="formStage container">
        <h2>مرحله 2: مشخصات همسر و فرزندان</h2>
        <form method="post" enctype="multipart/form-data" class="form-horizontal" role="form" id="spouseChildrenForm">
            <div id='spouse' style="display:none;">
                <!--==Spouse Info==-->
                <h3>مرحله 2-1: مشخصات همسر </h3>
              
                <div class="row text-center text-danger" id="secondStageError" style="display:none;"><i class="fa fa-times fa-lg" style="margin-left: 5px;"></i>لطفا خطاهای قسمت های قرمز رنگ را اصلاح کرده و فرم را مجددا ارسال فرمائید.</div>
                <!--Personal Info-->
                <fieldset>
                    <legend>1-مشخصات فردی همسر</legend>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="spouseFirstName_fa" class="col-md-4 control-label">نام(فارسی):</label>
                            <div class="col-md-8">
                                <input type="text" name="spouseFirstName_fa" id="spouseFirstName_fa" class="form-control" placeholder="نام فارسی" maxlength="33">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="spouseLastName_fa" class="col-md-4 control-label">نام خانوادگی(فارسی):</label>
                            <div class="col-md-8">
                                <input type="text" name="spouseLastName_fa" class="form-control" id="spouseLastName_fa" placeholder="نام خانوادگی فارسی"
                                    maxlength="33">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="spouseFirstName_en" class="col-md-4 control-label">نام(انگلیسی):</label>
                            <div class="col-md-8">
                                <input type="text" name="spouseFirstName_en" class="form-control" id="spouseFirstName_en" placeholder="First Name" maxlength="33">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="spouseLastName_en" class="col-md-4 control-label">نام خانوادگی(انگلیسی):</label>
                            <div class="col-md-8">
                                <input type="text" name="spouseLastName_en" class="form-control" id="spouseLastName_en" placeholder="Last/Family Name" maxlength="33">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="spouseGender" class="col-md-4 control-label  ">جنسیت:</label>
                            <div class="col-md-8 genderSelect">
                                <div class="col-xs-6">
                                    <i class="fa fa-male" style="font-size:23px;"></i>
                                    <label class="radio-inline ">
                                        <input type="radio" name="spouseGender" value="male">مذکر</label>
                                </div>
                                <div class="col-xs-6">
                                    <i class="fa fa-female " style="font-size:23px;"></i>
                                    <label class="radio-inline">
                                        <input type="radio" name="spouseGender" value="female">مونث</label>
                                </div>
                                <div id="spouseGenderErrors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="spouseDate" class="col-md-4 control-label">تاریخ تولد(شمسی):</label>
                            <div class="col-md-8 date">
                                <div class="input-group dateGroup" id="spouseDate">
                                    <div class="input-group-addon" id="spouseBirthDate_AddOn">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                    <input type="text" class="form-control" name="spouseBirthDate" id="spouseBirthDate" placeholder="1390/1/1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="spouseBirthCity" class="col-md-4 control-label">شهر محل تولد:</label>
                            <div class="col-md-8">
                                <input type="text" name="spouseBirthCity" class="form-control" id="spouseBirthCity" placeholder="تهران(بدون نام استان یا منطقه)"
                                    maxlength="20">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="spouseBirthCountry" class="col-md-4 control-label">کشور محل تولد:</label>
                            <div class="col-md-8">
                                <input type="text" name="spouseBirthCountry" class="form-control" id="spouseBirthCountry" placeholder="ایران" value="ایران"
                                    maxlength="20">
                            </div>
                        </div>
                    </div>
                </fieldset>
                <!----===========Picture============-->
                <fieldset>
                    <legend>2-عکس همسر</legend>
                    <div class="row col-sm-12">
                        <p class="form-text text-muted ">توجه!!!: عکس همسر باید در اندازه 600 در 600 بوده و حداکثر اندازه آن 240 کیلو بایت باشد </p>
                    </div>
                    <div class=" form-group row col-sm-12">
                        <label for="spousePhoto" class="control-label ">لطفا عکس همسر خود را آپلود کنید:</label>
                        <div class="col-md-8 col-centered" style="max-width: none;">
                            <input class="form-control file-loading" id="spousePhoto" name="spousePhoto" type="file" accept="image/jpg,image/jpeg">
                            <small class="help-block" id="spousePhotoErrors" style="color:red;display:none;">آپلود عکس پرسنلی همسر الزامی است.</small>
                        </div>
                    </div>
                </fieldset>
                <hr class="style-one">
            </div>
            <!--==Children Info==-->
            <div id='children' style="display:none;">
                <!--==child Info==-->
                <h3>مرحله 2-2-مشخصات فرزندان</h3>
                <div id='childTemplate' style="display:none">
                    <!--=========Personal Info-->
                    <fieldset>
                        <legend>1-مشخصات فردی فرزند</legend>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">نام(فارسی):</label>
                                <div class="col-md-8">
                                    <input type="text" name="childFirstName_fa" class="form-control" placeholder="نام فارسی" maxlength="33">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">نام خانوادگی(فارسی):</label>
                                <div class="col-md-8">
                                    <input type="text" name="childLastName_fa" class="form-control" placeholder="نام خانوادگی فارسی" maxlength="33">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">نام(انگلیسی):</label>
                                <div class="col-md-8">
                                    <input type="text" name="childFirstName_en" class="form-control" placeholder="First Name" maxlength="33">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">نام خانوادگی(انگلیسی):</label>
                                <div class="col-md-8">
                                    <input type="text" name="childLastName_en" class="form-control" placeholder="Last/Family Name" maxlength="33">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="childGender" class="col-md-4 control-label  ">جنسیت:</label>
                                <div class="col-md-8 genderSelect">
                                    <div class="col-xs-6">
                                        <i class="fa fa-male" style="font-size:23px;"></i>
                                        <label class="radio-inline ">
                                            <input type="radio" name="childGender" value="male">مذکر</label>
                                    </div>
                                    <div class="col-xs-6">
                                        <i class="fa fa-female " style="font-size:23px;"></i>
                                        <label class="radio-inline">
                                            <input type="radio" name="childGender" value="female">مونث</label>
                                    </div>
                                    <div id="childGenderErrors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">تاریخ تولد(شمسی):</label>
                                <div class="col-md-8 date">
                                    <div class="input-group dateGroup">
                                        <div class="input-group-addon" id="childBirthDate_AddOn">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                        <input type="text" class="form-control" name="childBirthDate" id="childBirthDate" placeholder="1390/1/1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">شهر محل تولد:</label>
                                <div class="col-md-8">
                                    <input type="text" name="childBirthCity" class="form-control" placeholder="تهران(بدون نام استان یا منطقه)" maxlength="20">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">کشور محل تولد:</label>
                                <div class="col-md-8">
                                    <input type="text" name="childBirthCountry" class="form-control" placeholder="ایران" value="ایران" maxlength="20">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <!----===========Picture============-->
                    <fieldset>
                        <legend>2-عکس فرزند</legend>
                        <div class="row col-sm-12">
                            <p class="form-text text-muted ">توجه!!!: عکس فرزند باید در اندازه 600 در 600 بوده و حداکثر اندازه آن 240 کیلو بایت باشد </p>
                        </div>
                        <div class=" form-group row col-sm-12">
                            <label class="control-label ">لطفا عکس فرزند خود را آپلود کنید:</label>
                            <div class="col-md-8 col-centered" style="max-width: none;">
                                <input class="form-control file-loading" name="childPhoto" id="childPhoto" type="file" accept="image/jpg,image/jpeg">
                                <small class="help-block" id="childPhotoErrors" style="color:red;display:none;">آپلود عکس پرسنلی فرزندالزامی است.</small>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row col-sm-12 text-center">
                <input type="button" class="btn btn-primary" id="nextStage2" value="ثبت و مرحله بعدی">
                <input type="button" class="btn btn-primary" id="prevStage2" value="مرحله قبلی">
                <input type="reset" class="btn btn-primary" id="resetStage2" value="پاک کردن فرم">
            </div>
        </form>
    </div>
    <!---End of second Stage -->
    <!-- Begin of third stage -->
    <div id="thirdStageContainer" class="formStage container">
        <!-- Show Personal Info for Confirmation -->
        <div id="personalInfo">
            <div class="panel panel-primary" id="personalInfoPanel-Template" style="display:none;">
                <div class="panel-heading">1- مشخصات فرد متقاضی</div>
                <div class="panel-body">
                    <div class="col-lg-4 col-sm-6">
                        <strong>نام: </strong>
                        <span>%FirstName_fa%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>نام خانوادگی: </strong>
                        <span>%LastName_fa%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>نام(انگلیسی): </strong>
                        <span>%FirstName_en%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>نام خانوادگی(انگلیسی): </strong>
                        <span>%LastName_en%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>جنسیت: </strong>
                        <span>%Gender%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>تاریخ تولد(شمسی): </strong>
                        <span>%BirthDate%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>تاریخ تولد(میلادی): </strong>
                        <span>%BirthDate-Georgian%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>شهر محل تولد: </strong>
                        <span>%BirthCity%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>کشور محل تولد: </strong>
                        <span>%BirthCountry%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>کد پستی: </strong>
                        <span>%ZipCode%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>ایمیل: </strong>
                        <span>%Email%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>شماره همراه: </strong>
                        <span>%TelNumber%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>سطح تحصیلات: </strong>
                        <span>%Education%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>وضعیت تاهل: </strong>
                        <span>%MaridgStatus%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6" style="display: none;">
                        <strong>تعداد فرزندان: </strong>
                        <span>%ChildNumber%</span>
                    </div>
                    <div class="col-sm-12">
                        <strong>آدرس: </strong>
                        <span>%Address%</span>
                    </div>
                    <div class="col-sm-12">
                        <span>عکس متقاضی دریافت شد.</span>
                    </div>

                </div>
            </div>
        </div>
        <!-- Show Spouse Info for Confirmation -->
        <div id="spouseInfo">
            <div class="panel panel-primary" id="spouselInfoPanel-Template" style="display:none;">
                <div class="panel-heading">2- مشخصات همسر</div>
                <div class="panel-body">
                    <div class="col-lg-4 col-sm-6">
                        <strong>نام: </strong>
                        <span>%FirstName_fa%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>نام خانوادگی: </strong>
                        <span>%LastName_fa%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>نام(انگلیسی): </strong>
                        <span>%FirstName_en%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>نام خانوادگی(انگلیسی): </strong>
                        <span>%LastName_en%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>جنسیت: </strong>
                        <span>%Gender%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>تاریخ تولد(شمسی): </strong>
                        <span>%BirthDate%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>تاریخ تولد(میلادی): </strong>
                        <span>%BirthDate-Georgian%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>شهر محل تولد: </strong>
                        <span>%BirthCity%</span>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <strong>کشور محل تولد: </strong>
                        <span>%BirthCountry%</span>
                    </div>
                    <div class="col-sm-12">
                        <span>عکس همسر متقاضی دریافت شد.</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Show Children Info for Confirmation -->
        <div id="childrenInfo">
            <div class="panel panel-primary" id="childernInfoPanel-Template" style="display:none;">
                <div class="panel-heading">%caption%</div>
                <div class="panel-body" id="panelBody-Template">
                    <div id="childInfo-Template" class="container-fluid" style="display:none;">
                        <div class="col-sm-12 childHeading">%childIndex%</div>
                        <div class="col-lg-4 col-sm-6">
                            <strong>نام: </strong>
                            <span>%FirstName_fa%</span>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <strong>نام خانوادگی: </strong>
                            <span>%LastName_fa%</span>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <strong>نام(انگلیسی): </strong>
                            <span>%FirstName_en%</span>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <strong>نام خانوادگی(انگلیسی): </strong>
                            <span>%LastName_en%</span>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <strong>جنسیت: </strong>
                            <span>%Gender%</span>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <strong>تاریخ تولد(شمسی): </strong>
                            <span>%BirthDate%</span>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <strong>تاریخ تولد(میلادی): </strong>
                            <span>%BirthDate-Georgian%</span>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <strong>شهر محل تولد: </strong>
                            <span>%BirthCity%</span>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <strong>کشور محل تولد: </strong>
                            <span>%BirthCountry%</span>
                        </div>
                        <div class="col-sm-12">
                            <span>عکس فرزند دریافت شد.</span>
                        </div>
                        <hr class="row col-sm-12" />
                    </div>
                </div>
            </div>
        </div>
        <!-- Show Using condition and Spouse Ingo -->
        <div id="spouseReg" style="display:none;">
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="spouseToo">آیا مایل هستید برای همسرتان نیز ثبت نام انجام شود(دوشانس برنده شدن و 50 درصد تخفیف)؟</label>
            </div>
        </div>
        <!-- Show the price for registartion -->
        <div id="price" style="display: none">
            <div class="panel panel-primary">
                <div class="panel-heading">هزینه ثبت نام</div>
                <div class="panel-body">
                    <span>هزینه ثبت نام در قرعه کشی گرین کارت برای فرد متقاضی %spousetoo% %spouse% %childNumber% , %totalPrice%
                        تومان می باشد.</span>
                </div>
            </div>
        </div>
        <!-- Place Holder for Errors -->
        <div id="finalStageError" class="row col-sm-12 text-justify  text-danger" style="display:none"></div>
        <div class="row col-sm-12 text-center">
            <input type="button" class="btn btn-primary" id="prevprevStage3" value="اصلاح اطلاعات فردی">
            <input type="button" class="btn btn-primary" id="prevStage3" value="اصلاح اطلاعات همسر و فرزندان">
            <input type="button" class="btn btn-primary" id="payandSubmit" value="پرداخت و ارسال">
        </div>
    </div>
    <!-- End of third Stage -->

    <footer>
    </footer>
    <!--JQuery-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <!--BootStrap-->
    <script src="js/bootstrap.min.js"></script>
    <!-- the main fileinput plugin file -->
    <script src="js/bootstrap-fileinput/fileinput.min.js"></script>
    <!-- optionally uncomment line below for loading your theme assets for a theme like Font Awesome (`fa`) -->
    <!-- optionally if you need translation for your language then include  locale file as mentioned below -->
    <script src="js/bootstrap-fileinput/locales/fa.js"></script>
    <!--Bootstrap Validator-->
    <script src="js/bootstrapvalidator/bootstrapValidator.min.js"></script>
    <script src="js/bootstrapvalidator/language/fa_IR.js"></script>
    <!---Persina Date/Time Picker Plugin-->
    <script src="js/persianDateTimePicker/jalaali.js" type="text/javascript"></script>
    <script src="js/persianDateTimePicker/jquery.Bootstrap-PersianDateTimePicker.js" type="text/javascript"></script>
    <!-- JQuery Redirect Plugin -->
    <script src="js/redirect/jquery.redirect.js" type="text/javascript"></script>
    <!-- Session Check -->
    <script src="js/session.js"></script>
    <!--Site Specefic-->
    <script src="js/formapp.js"></script>
</body>

</html>