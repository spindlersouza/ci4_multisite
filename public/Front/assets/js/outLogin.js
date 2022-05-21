
function checkLoginState() {
    var stsLogin, atk;
    FB.login(function (response) {
        console.log(response);
    }, {scope: 'public_profile,email'});

    FB.getLoginStatus(function (response) {
        console.log(response);
        stsLogin = response.status;
//        atk = response.accessToken;
    });
    if (stsLogin === 'connected') {
//        FB.api('/me?access_token=' + atk, function (response) {
        FB.api('/me', function (response) {
            console.log(response);
        });
    }
    FB.logout(function (response) {
        // Person is now logged out
    });
}


(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


window.fbAsyncInit = function () {
    FB.init({
        appId: '493823439029035',
        cookie: true,
        xfbml: true,
        version: 'v13.0'
    });
    FB.AppEvents.logPageView();
};

