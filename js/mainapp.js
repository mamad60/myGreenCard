$(document).ready(function() {
    //Load header and Footer
    //====header
    $('nav').load('menu.html', function() {
        //===make current Page Active
        $('#myNavbar').find('li').first().addClass('active');
    });
    //===Footer
    $('footer').load('footer.html', function() {
        //===make current Page Active
        $('footer').css('padding-top', 0);
    });
    // Initiatate Fu;ll page plugin
    $('#fullpage').fullpage({
        sectionsColor: ['#1bbc9b', '#4BBFC3', '#7BAABE', '#E4AEC7', '#23a39a', '#313131'],
        anchors: ['dv-lottery-intro', 'dv-lottery-advantages', 'greencard-samples',
            'dv-lottery-photo', 'dv-lottery-registration', 'footer'
        ],
        menu: '#menu',
        scrollingSpeed: 1000,
        paddingTop: '3em',
        fixedElements: 'nav, #ribbon',
        navigation: true,
        navigationTooltips: ['آشنائی با لاتاری گرین کارت', 'مزایای گرین کارت', 'نمونه گرین کارت', 'شرایط عکس لاتاری', 'ثبت نام در لاتاری', 'پانویس'],
        loopBottom: true,
        onLeave: function(index, nextIndex, direction) {
            switch (nextIndex) {
                case 1:
                    $('#section0 img').addClass('animated fadeInRightBig').css('animation-delay', '.6s').css('-webkit-animation-delay', '0.6s');
                    $('#section0 h1').addClass('animated rubberBand').css('animation-delay', '.2s').css('-webkit-animation-delay', '0.2s');
                    break;
                case 2:
                    $('#section1 h1').addClass('animated slideInRight').css('animation-delay', '.3s').css('-webkit-animation-delay', '0.3s');
                    break;
                case 3:
                    $('#section2 h1').addClass('animated swing').css('animation-delay', '0.2s').css('-webkit-animation-delay', '0.2s');
                    $('#section2 img').addClass('animated bounceInRight').css('animation-delay', '.6s').css('-webkit-animation-delay', '0.6s');
                    break;
                case 4:
                    $('#section3 img').addClass('animated zoomIn').css('animation-delay', '.2s').css('-webkit-animation-delay', '0.2s');
                    break;
                case 5:
                    $('#section4 img').addClass('animated rotateIn').css('animation-delay', '.3s').css('-webkit-animation-delay', '0.3s');

                    break;
            }

            switch (index) {
                case 1:
                    $('#section0 img').removeClass('animated fadeInRightBig');
                    $('#section0 h1').removeClass('animated rubberBand');
                    break;
                case 2:
                    $('#section1 h1').removeClass('animated slideInRight');
                    break;
                case 3:
                    $('#section2 h1').removeClass('animated swing');
                    $('#section2 img').removeClass('animated bounceInRight');
                    break;
                case 4:
                    $('#section3 img').removeClass('animated zoomIn');
                    break;
                case 5:
                    $('#section4 img').removeClass('animated rotateIn');
                    break;
            }

        }
    });

    //Diasble Spousetoo when single
    $('#maridgeStatus').change(function() {
        if ($('#maridgeStatus option:selected').val() == 'single') {
            $('#spouseToo').prop('disabled', true);
        } else {
            $('#spouseToo').prop('disabled', false);
        }
    });
    //Initiate Bootrap Tooltip
    $('[data-toggle="tooltip"]').tooltip();
    // section0  Animation on load
    $('#section0 img').addClass('animated fadeInRightBig').css('animation-delay', '.6s').css('-webkit-animation-delay', '0.6s');
    $('#section0 h1').addClass('animated rubberBand').css('animation-delay', '.2s').css('-webkit-animation-delay', '0.2s');
});