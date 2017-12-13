function set_session(user_type, interval) {
    check_session(user_type); // for the firet time
    setInterval(function () {
        check_session(user_type);
    }, interval);
}

function check_session(user_type) {
    var dataSend = {
        user_type: user_type
    }
    $.ajax({
        url: 'scripts/session.php',
        type: 'post',
        dataType: 'JSON',
        cash: false,
        data: $.param(dataSend)
    }).done(function (response) {
        console.log(response+'  '+new Date().toUTCString());
        if (!response) {
            switch (user_type) {
                case 'user':
                    window.location.href = 'dv-lottery-reg.php';
                    break;
                case 'admin':
                    window.location.href = 'adminlogin.php?expired';
                    break;
            }
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.error(errorThrown);
    });
}