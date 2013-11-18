var user;
var project;
var isCreatingTask = true;

$(document).ready(function() {
    checkUser();
    $("#lLogOut").click(function() {
        localStorage.clear();
        window.top.location.href = 'index.html';
    });
    User.get(0, 0, {}, [], loadUsers);
});

function loadUsers(data) {
    Task.get(0, 0, {"project_id": project.id}, ["timestamp"], loadTasks);
}

function loadTasks(data) {
    Department.get(0, 0, {}, [], loadDepartments);
}

function loadDepartments(data) {
    setTimeout(function() {
        google.load('visualization', '1', {'callback': 'drawChart', 'packages': ['corechart']});
    }, 2000);
}

function drawChart() {
    // <editor-fold defaultstate="collapsed" desc="Graphs Data">

    var userData = new google.visualization.DataTable();
    userData.addColumn('string', 'User');
    userData.addColumn('number', 'Points');

    var dptData = new google.visualization.DataTable();
    dptData.addColumn('string', 'Department');
    dptData.addColumn('number', 'Points');

    // </editor-fold>
    var sumPoints = 0;
    var sumPointsDone = 0;

    var userPoints = new Array();
    userPoints[0] = 0;
    Users.forEach(function(element) {
        userPoints[element.id] = 0;
    });

    var dptPoints = new Array();
    dptPoints[0] = 0;
    Departments.forEach(function(element) {
        dptPoints[element.id] = 0;
    });


    var burndownPoints = new Array();

    Tasks.forEach(function(task) {
        if (task.state_id != 4) {
            // General Points
            sumPoints += parseInt(task.points);
            if (task.state_id == 3) {
                sumPointsDone += parseInt(task.points);
            }

            // Points by User
            if (task.user_id != undefined) {
                userPoints[task.user_id] += parseInt(task.points);
            } else {
                userPoints[0] += parseInt(task.points);
            }

            // Points by Department
            if (task.department_id != undefined) {
                dptPoints[task.department_id] += parseInt(task.points);
            } else {
                dptPoints[0] += parseInt(task.points);
            }

            // Burndown
            var date = new Date(Date.parse(task.timestamp)).toLocaleDateString();
            if (burndownPoints[date] == undefined) {
                burndownPoints[date] = new Object();
            }
            burndownPoints[date].total = sumPoints;
            burndownPoints[date].complete = sumPointsDone;
        }
    });

    // <editor-fold defaultstate="collapsed" desc="User Draw Chart">

    var userRows = new Array();
    userPoints.forEach(function(points, index) {
        if (index == 0) {
            userRows.push(['Not Assigned', points]);
        }
        if (Users[index] != undefined && points > 0) {
            userRows.push([Users[index].name, points]);
        }
    });
    userData.addRows(userRows);
    var userOp = {'title': 'Points by Users', 'width': 400, 'heigth': 300};
    var userChart = new google.visualization.PieChart(document.getElementById('pieUserPoints'));
    userChart.draw(userData, userOp);
// </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Department Draw Chart">
    var dptRows = new Array();
    dptPoints.forEach(function(points, index) {
        if (index == 0) {
            dptRows.push(['Not Assigned', points]);
        }
        if (Departments[index] != undefined && points > 0) {
            dptRows.push([Departments[index].name, points]);
        }
    });
    dptData.addRows(dptRows);
    var dptOp = {'title': 'Points by Department', 'width': 400, 'heigth': 300};
    var dptChart = new google.visualization.PieChart(document.getElementById('pieDepartmentPoints'));
    dptChart.draw(dptData, dptOp);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="BurnDownChart">
    var burnDownArray = [];

    for (var element in burndownPoints) {
        burnDownArray.push([new Date(Date.parse(element)).toLocaleDateString(), burndownPoints[element].total, burndownPoints[element].complete]);
    }
    burnDownArray.sort(function(a, b) {
        return new Date(Date.parse(a[0])) - new Date(Date.parse(b[0]));
    });
    burnDownArray.unshift(['Date', 'Pending', 'Finished']);
    var burnDownData = google.visualization.arrayToDataTable(burnDownArray);
    var burnDownOp = {
        title: 'Burn Down Chart',
        hAxis: {title: 'Dates', titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0}
    };

    var bdChart = new google.visualization.AreaChart(document.getElementById('burnDownChart'));
    bdChart.draw(burnDownData, burnDownOp);

    var bar = '<div class="bar" style="width: ' + (sumPointsDone / sumPoints * 100) + '%"></div>';
    $("#progressBarProject").append(bar);
    $("#totalPoints").append(sumPoints);
    $("#totalCompletedPoints").append(sumPointsDone);
    // </editor-fold>

}



function checkUser() {
    if (localStorage.getItem('user') == undefined) {
        window.top.location.href = 'index.html';
    } else {
        var u = jQuery.parseJSON(localStorage.getItem('user'));
        user = new User(u.id, u.name, u.password, u.username, u.email);
        var p = jQuery.parseJSON(localStorage.getItem('project'));
        project = new Project(p.id, p.name);
        document.getElementById("lUsername").innerHTML = user.name;
        document.getElementById("projectName").innerHTML = project.name;

    }
}

// <editor-fold defaultstate="collapsed" desc="Helpers">
function getTimeStamp() {
    var now = new Date();
    return (now.getFullYear() + '-' +
            (now.getMonth() + 1) + '-' +
            (now.getDate()) + " " +
            now.getHours() + ':' +
            ((now.getMinutes() < 10)
                    ? ("0" + now.getMinutes())
                    : (now.getMinutes())) + ':' +
            ((now.getSeconds() < 10)
                    ? ("0" + now.getSeconds())
                    : (now.getSeconds())));
}
// </editor-fold>
