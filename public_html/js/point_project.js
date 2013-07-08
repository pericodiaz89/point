$(document).ready(function() {
//    $("table tr").click(function() {
//        $("#task_panel").modal();
//    });
    $("#bNewSprint").click(function() {
        $("#new_sprint_panel").modal();
    });
    $("#bCreateTask").click(function() {
        $("#new_task_panel").modal();
    });
    $("#createSprint").click(function(){
        var nSprint = new Sprint(tSprintDescription.value, tSprintName.value, tSprintDate.value, undefined, project.id);
        nSprint.create();
    });
    $("#bCrateTask").click(function(){
        console.log(tTaskName.value);
        console.log(tTaskDescription.value);
        console.log($("#rbOptionNewTask1").attr());
    });
});

var user;
var project;

window.onload = checkUser();

document.addEventListener('touchmove', function(e) {
    $("#task_panel").modal();
}, false);

function checkUser(){
    if(localStorage.getItem('user')==undefined){
         window.top.location.href = 'index.html';
    }else{
        var u = jQuery.parseJSON(localStorage.getItem('user'));
        user = new User(u.id, u.name, u.password, u.username, u.email);
        var p = jQuery.parseJSON(localStorage.getItem('project'));
        project = new Project(p.id, p.name);
        document.getElementById("lUsername").innerHTML = user.name;
        document.getElementById("projectName").innerHTML = project.name;
        document.getElementById("lcurrentSprint").innerHTML = "Backlog";
        
        Sprint.get(0,20,{"project_id" : project.id});
        Department.get(0,10);
        User.get(0,10);
        Task.get(0,10,{"project_id" : project.id});
    }
}

var initSprint = false;
var initDepartment = false;
var initUser = false;
var initTask = false;

function getFinished(data) {
    var tipe;
    var first = true;
    var table = new Array();
    var args = new Array();
    var i = 0;
    
    data.forEach(function(element) {
        if(first){
            tipe = element;
        }
        if  (element instanceof Sprint && !initSprint) {
            if (first) {
                document.getElementById("sSprintChange").innerHTML = "<option> Backlog</option>";
                document.getElementById("sSprint").innerHTML = "<option> Backlog</option>";
                first = false;
            }
            document.getElementById("sSprintChange").innerHTML += "<option>" + element.name + " </option>";
            document.getElementById("sSprint").innerHTML += "<option>" + element.name + " </option>";
        } else if(element instanceof Sprint){
            
        }else if (element instanceof Department && !initDepartment) {
            if (first) {
                document.getElementById("sDepartment").innerHTML += "<option> All </option>";
                first = false;
            }
            document.getElementById("sDepartment").innerHTML += "<option>" + element.name + " </option>";
        }else if(element instanceof Department){
            
        }else if(element instanceof User && !initUser){
            if(first){
                document.getElementById("sUser").innerHTML = "<option> All </option>";
                first = false;
            }
            document.getElementById("sUser").innerHTML += "<option>"+element.name+"</option>";
        }else if(element instanceof User){
            
        }else if (element instanceof Task && !initTask){
            if(first){
                table[0] = "✓";
                table[1] = "#";
                table[2] = "Name";
                table[3] = "Points";
                table[4] = "User";
                table[5] = "Department";
                table[6] = "Component";
                table[7] = "Status";
                first = false;
            }
            args[i] = new Array();
            args[i][0] = element.id;
            args[i][1] = "<input type=\"checkbox\">​";
            args[i][2] = element.id;
            args[i][3] = element.name;
            args[i][4] = element.points;
            args[i][5] = element.user_id;
            args[i][6] = element.department_id;
            args[i][7] = element.component_id;
            args[i][8] = "new";
            i++;
        }else if (element instanceof Task){
            
        }
    });
    
    
     if  (tipe instanceof Sprint && !initSprint) {
         initSprint = true;
     }else if(tipe instanceof Department && !initDepartment){
         initDepartment = true;
     }else if (tipe instanceof User && !initUser){
         initUser = true;
     }
    if(tipe instanceof Task){
        document.getElementById("tableTasks").innerHTML = generateTable(table, args);
    }
}