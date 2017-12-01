<!DOCTYPE html>

<head>
    <title>صفحه مدیریت</title>
    <!--Meta Tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="سایت ثبت نام در قرعه کشی گرین کارت آمریکا-فرم ثبت نام">
    <meta name="keywords" content="بهترین, ساده ترین, سریع ترین, گرین کارت, ثبت نام, آمریکا,ثبت نام در قرعه کشی گرین کارت,لاتاری,Greencard">
    <meta name="author" content="Mohammad Aghakhani">
    <!--==============================================================-->
    <!--BoottStrap-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <!---=============BootStrap RTL-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontiran.css">;
    <!-- Site Specefic -->
    <link rel="stylesheet" type="text/css" href="css/page.css">;
 
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
</head>
<html lang="fa" dir="rtl">

<body>
    <nav></nav>
    <header>
    </header>
    <footer></footer>
    <script>
        $(document).ready(function() {
            //Load header and Footer
            //====header
            $('nav').load('menu.html', function() {
                //===make current Page Active
                $('#myNavbar').find('li a[href="' + window.location.pathname.split('/').pop() + '"]').parent().addClass('active');
            });
            //===Footer
            $('footer').load('footer.html', function() {
                //===make current Page Active
                $('footer').css('padding-top', 0);
            });
        });
    </script>
</body>

</html>