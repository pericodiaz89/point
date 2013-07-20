$(document).ready(function() {
    $("#signIn").click(function() {
        signIn();
    });
});

window.onload = checkUser();

function signIn() {
    var username = tUsername.value;
    var password = tPassword.value;
    User.get(0, 1, {"username": username, "password": password}, function getFinished(data) {
        console.log(data);
        data.forEach(function(element) {
            localStorage.setItem('user', JSON.stringify(element));
        });
        window.top.location.href = 'home.html';
    });
}



function checkUser(){
    if(localStorage.getItem('user')!=undefined){
        window.top.location.href = 'home.html';
    }
}

