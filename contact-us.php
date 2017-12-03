<!DOCTYPE html>
<?php 
    include_once  'scripts/securimage/securimage.php';
    session_start();
    // if(!isset($_SESSION['active_contact_form']) || $_SESSION['active_contact_form']==false )
    // {
    //     $_SESSION['active_contact_form']=true;
    // }
    // else{
    //     //simply go to homepage
    //     header("Location: index.php");
    // }
?>
<html lang="fa" dir="rtl">

<head>
    <title>پشتیبانی (ثبت نام لاتاری)</title>
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
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <!---=============BootStrap RTL-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="css/contact.css">
    <link rel="stylesheet" href="scripts/securimage/securimage.css" media="screen">
    <!--JQuery-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <!--BootStrap-->
    <script src="js/bootstrap.min.js"></script>

    <script>
        $(function () {
            $("#contactModal").on("shown.bs.modal", function () {
                $("body").addClass("modal-open");
            }).on("hidden.bs.modal	", function () {
                $("body").removeClass("modal-open");
                // $.post("scripts/ajaxphpfunctions.php", {
                //     "function": "hide_contact"
                // });
                window.history.back();
            });
            // show the modal on load
            $('#contactModal').modal('show');
            // Send form on submit
            $("#contactForm").submit(function (e) {    
                e.preventDefault(); //STOP default action
                var postData = $(this).serializeArray();
                $('#contactForm input[type="submit"]').prop('disabled', 'true');
                $('#contactForm input[type="reset"]').prop('disabled', 'true');
                // Fire off the request to form.php
                var request = $.ajax({
                    url: 'scripts/send-contact.php',
                    type: 'post',
                    dataType: 'JSON',
                    data: postData
                }).done(function (response) {
                    // Log a message to the console
                    if (!response.error) {
                        // console.log('Sucecces');
                        $('#result').html(response.message).removeClass('text-danger').addClass(
                            'text-success').fadeIn();
                        $('#contactForm input[type="submit"]').prop('disabled', 'true');
                        $('#contactForm input[type="reset"]').prop('disabled', 'true')
                        setTimeout(function(){$('#contactModal').modal('hide');}, 300000);
                    } else {
                        // console.log('Error');
                        $('#result').html(response.message).removeClass('text-success').addClass(
                            'text-danger').fadeIn();
                            setTimeout(function(){$('#contactModal').modal('hide');}, 30000);
                        }
                    return true;
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    // Log the error to the console
                    console.error('The following error occurred: ' + textStatus, errorThrown);
                    setTimeout(function(){$('#contactModal').modal('hide');}, 30000);
                    return false;
                }).always(function (response) {
                    $('#contactForm input[type="submit"]').removeAttr('disabled')
                    $('#contactForm input[type="reset"]').removeAttr('disabled')
                });
            });
            //Custom Message for Invalid fields in Perasian
            $('form input[type=text],form textarea').on('change invalid', function () {
                var textfield = $(this).get(0);

                // 'setCustomValidity not only sets the message, but also marks
                // the field as invalid. In order to see whether the field really is
                // invalid, we have to remove the message first
                textfield.setCustomValidity('');
                if (!textfield.validity.valid) {
                    textfield.setCustomValidity('لطفا این قسمت را پر کنید');
                }
            });
            $('form input[type=email]').on('change invalid', function () {
                var textfield = $(this).get(0);

                // 'setCustomValidity not only sets the message, but also marks
                // the field as invalid. In order to see whether the field really is
                // invalid, we have to remove the message first
                textfield.setCustomValidity('');
                if (!textfield.validity.valid) {
                    if (textfield.validity.valueMissing) {
                        textfield.setCustomValidity('لطفا این قسمت را پر کنید');
                    } else {
                        textfield.setCustomValidity('لطفایک ایمیل معتبر وارد کنید');
                    }
                }
            });

        });
    </script>
    <!--For old Browser use HTMLshiv-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <span id="contactLabel">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                <span style="padding-left:1em;">برای درخواست پشتیبانی و مشاوره, لطفا از طریق فرم زیر با ما تماس بگیرید</span>
                            </span>
                        </div>
                        <form method="POST" accept-charset="utf-8" id="contactForm" action="">
                            <div class="modal-body" style="padding: 5px;">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                        <input class="form-control" name="firstname" placeholder="نام" type="text" required autofocus />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                        <input class="form-control" name="lastname" placeholder="نام خانوادگی" type="text" required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                        <input class="form-control" name="email" placeholder="ایمیل" type="email" required />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                        <input class="form-control" name="subject" placeholder="موضوع" type="text" required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <textarea style="resize:vertical;" class="form-control" placeholder="پیغام" rows="6" name="comment" required></textarea>
                                    </div>
                                </div>
                                <div class="row col-lg-12 col-md-12 col-sm-12" style="margin-top:20px;">
                                    <p class="text-muted">لطفا کد تصویر زیر را وارد کنید:</p>
                                </div>
                                <div class="row text-center" style="margin-top:5px; margin-bottom:5px;">
                                    <div style="width:240px;margin:0px auto">
                                        <?php
                                            $options = array('disable_flash_fallback'=>true,'show_text_input'=>false,'icon_size'=>28);
                                            echo Securimage::getCaptchaHtml($options);
                                        ?>
                                            <br>
                                            <input name="captcha_code" id="captcha_code" type="text" value="" maxlength="4" style="width:190px; margin-right:50px;" autofocus
                                                required>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <input type="submit" class="btn btn-success" value="ارسال" />
                                    <!--<span class="glyphicon glyphicon-ok"></span>-->
                                    <input type="reset" class="btn btn-danger" value="پاک کردن" />
                                    <!--<span class="glyphicon glyphicon-remove"></span>-->
                                    <button style="float: right;" type="button" class="btn btn-default btn-close" data-dismiss="modal">بستن</button>
                                    <div id="result" class="row text-center" style="margin-top:10px; margin-bottom:2px;"></div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>