$(document).ready(function() {
    $("#tableProyects").click(function() {
        Projects.forEach(function(p) {
            $("#" + p.id).click(function() {
                localStorage.setItem('project', JSON.stringify(p));
                window.top.location.href = 'project.html';
            });
        });
    });
});

var user;
window.onload = checkUser();

function checkUser() {
    if (localStorage.getItem('user') == undefined) {
        window.top.location.href = 'index.html';
    } else {
        var u = jQuery.parseJSON(localStorage.getItem('user'));
        user = new User(u.id, u.name, u.password, u.username, u.email);
        document.getElementById("lUsername").innerHTML = user.name;
        Project.get(0, 20, {}, function getFinished(data) {
            var table = new Array();
            var args = new Array();
            var i = 0;
            table[0] = "#";
            table[1] = "Name";
            data.forEach(function(element) {
                args[i] = new Array();
                args[i][0] = element.id;
                args[i][1] = element.id;
                args[i][2] = element.name;
                i++;
            });
            var h = generateTable(table, args);
            document.getElementById("tableProyects").innerHTML = h;
        });
    }
}




