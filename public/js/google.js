function onSignIn(googleUser) {
    var user = googleUser.getBasicProfile();
    console.log('ID: ' + user.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Firstname: ' + user.getGivenName());
    console.log('Lastname: ' + user.getFamilyName());
    console.log('Image URL: ' + user.getImageUrl());
    console.log('Email: ' + user.getEmail()); // This is null if the 'email' scope is not present.
}

function signOut(googleUser) {
var auth2 = gapi.auth2.getAuthInstance();
auth2.signOut().then(function () {
    console.log('User signed out.');
});
}

function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://yourbackend.example.com/tokensignin');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
    console.log('Signed in as: ' + xhr.responseText);
    };

    xhr.send('idtoken=' + id_token);
}