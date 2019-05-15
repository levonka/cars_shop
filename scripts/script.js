window.onload = function() {

    var header_overlay = document.getElementById('header_overlay');

    var sign_in = document.getElementById('sign_up--btn');
    if (typeof sign_in != 'undefined')
        sign_in.onclick = popup_form;
    var closeB = document.getElementById('popup_close');
    var closeB2 = document.getElementById('popup_close2');
    closeB.onclick = popupClose;
    closeB2.onclick = popupClose;

    var tIn, tOut;

    function popup_form() {
        header_overlay.style.display = 'block';
        popupIn(1);
    }

    function popupClose () {
        popupOut(0);
    }

    //  Медленное появление
    function popupIn(opacity) {
        var currentOpacity = (header_overlay.style.opacity) ? parseFloat(header_overlay.style.opacity) : 0;

        if (currentOpacity < opacity) {
            clearInterval(tOut);
            currentOpacity += 0.02;
            header_overlay.style.opacity = currentOpacity;

            tIn = setTimeout(function () {
                popupIn(opacity);
            }, 15);
        }
    }

     // Медленное исчезновение
    function popupOut(opacity) {
        var currentOpacity = (header_overlay.style.opacity) ? parseFloat(header_overlay.style.opacity) : 0;

        if (currentOpacity > opacity) {
            clearInterval(tIn);
            currentOpacity -= 0.02;
            header_overlay.style.opacity = currentOpacity;

            tOut = setTimeout(function () {
                popupOut(opacity);
            }, 15);

            if (header_overlay.style.opacity <= opacity)
            {
                header_overlay.style.display = 'none';
                header_overlay.style.opacity = opacity;
            }
        }
    }

    var logInForm = document.getElementById('header-form--log_in');
    var registrationForm = document.getElementById('header-form--join');

    var joinBtn = document.getElementById('join_btn');
    joinBtn.onclick = function () {
        openRegistrationForm();
    }
    var signBtn = document.getElementById('sign_btn');
    signBtn.onclick = function () {
        openLogInForm();
    }
    
    function openRegistrationForm() {
        logInForm.style.display = 'none';
        registrationForm.style.display = 'block';
    }

    function openLogInForm() {
        registrationForm.style.display = 'none';
        logInForm.style.display = 'block';
    }



    var error_login = document.getElementById('errorAuthBtn');

    if (typeof error_login != 'undefined')
        error_login.onclick = function () {
            location.search = "";
        }

};