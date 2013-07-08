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
        var name = tTaskName.value;
        console.log(name);
        var desc = tTaskDescription.value;
        console.log(desc);
        if ($("input[type='radio'].radioNewTask").is(':checked')) {
            var points = $("input[type='radio'].radioNewTask:checked").val();
            console.log(points);
        }
        var dep = document.getElementById("sSetDepartment");
        var depVal = dep.options[dep.selectedIndex].value;
//        console.log(depVal);
        var status = document.getElementById("sSetStatus");
        var statusVal =  status.options[status.selectedIndex].value;
//        console.log(statusVal);
        var user = document.getElementById("sSetUser");
        var userVal = user.options[user.selectedIndex].value;
//        console.log(userVal);
        var comp = document.getElementById("sSetComponent");
        var compVal = comp.options[comp.selectedIndex].value;
//        console.log(compVal);
        var sprint = document.getElementById("sSprint");
        var SprintVal = sprint.options[sprint.selectedIndex].value;;
        
        var newTask = new Task(userVal, "null", SprintVal, compVal, points, project.id, depVal, name, desc, statusVal );
        newTask.create(function (objetoNuevo){
            console.log(objetoNuevo);
            var args = new Array();
            args[0] = objetoNuevo.id;
            args[1] = "<input type=\"checkbox\">​";
            args[2] = objetoNuevo.id;
            args[3] = objetoNuevo.name;
            args[4] = objetoNuevo.points;
            if (objetoNuevo.user_id != "null") {
                args[5] = Users[objetoNuevo.user_id].name;
            } else {
                args[5] = "N/A";
            }
            args[6] = Departments[objetoNuevo.department_id].name;
            if (objetoNuevo.component_id != "null") {
                console.log (Components[objetoNuevo.component_id])
                args[7] = Components[objetoNuevo.component_id].name;
            } else {
                args[7] = "N/A";
            }
            args[8] = Task_states[objetoNuevo.state_id].name;
            $("#tableTasks").append(generateRow(args))
            console.log(objetoNuevo);
        });
        console.log(newTask);
        
    });
    
         Task.get(0,10,{"project_id" : project.id});
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
        project = new Project( p.id,p.name);
        document.getElementById("lUsername").innerHTML = user.name;
        document.getElementById("projectName").innerHTML = project.name;
        document.getElementById("lcurrentSprint").innerHTML = "Backlog";
        
        Sprint.get(0,20,{"project_id" : project.id});
        Department.get(0,10);
        User.get(0,10);
        Component.get(0,0,{"project_id" : project.id});
        Task_state.get(0,0);
        
       
    }
}

var initSprint = false;
var initDepartment = false;
var initUser = false;
var initTask = false;
var initComponent = false;
var initTask_state = false;

function getFinished(data) {
    var tipe;
    var first = true;
    var table = new Array();
    var args = new Array();
    var i = 0;

    data.forEach(function(element) {
        if (first) {
            tipe = element;
        }
        if (element instanceof Sprint && !initSprint) {
            if (first) {
                document.getElementById("sSprintChange").innerHTML = "<option value=\"null\"> Backlog</option>";
                document.getElementById("sSprint").innerHTML = "<option value=\"null\"> Backlog</option>";
                first = false;
            }
            document.getElementById("sSprintChange").innerHTML += "<option value=\"" + element.id + "\">" + element.name + " </option>";
            document.getElementById("sSprint").innerHTML += "<option value=\"" + element.id + "\">" + element.name + " </option>";
        } else if (element instanceof Sprint) {

        } else if (element instanceof Department && !initDepartment) {
            if (first) {
                document.getElementById("sDepartment").innerHTML += "<option value=\"null\"> All </option>";
                first = false;
            }
            //$("#sSetDepartment").append("<option>" + element.name + " </option>");
            $("#sSetDepartment").append("<option value=\"" + element.id + "\">" + element.name + " </option>");
            //$("#sSetDepartment").val(element.id);
            
           //document.getElementById("sSetDepartment").value = element.id;
            document.getElementById("sDepartment").innerHTML += "<option value=\"" + element.id + "\">" + element.name + " </option>";
        } else if (element instanceof Department) {

        } else if (element instanceof User && !initUser) {
            if (first) {
                document.getElementById("sUser").innerHTML = "<option value=\"null\"> All </option>";
                document.getElementById("sSetUser").innerHTML = "<option value=\"null\"> N.A. </option>";
                first = false;
            }
            document.getElementById("sUser").innerHTML += "<option value=\"" + element.id + "\">" + element.name + "</option>";
            document.getElementById("sSetUser").innerHTML += "<option value=\"" + element.id + "\">" + element.name + "</option>";
        } else if (element instanceof User) {

        } else if (element instanceof Task && !initTask) {
            if (first) {
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
            if (element.user_id != null) {
                args[i][5] = Users[element.user_id].name;
            } else {
                args[i][5] = "N/A";
            }
            args[i][6] = Departments[element.department_id].name;
            if (element.component_id != null) {
                args[i][7] = Components[element.component_id].name;
            } else {
                args[i][7] = "N/A";
            }
            args[i][8] = Task_states[element.state_id].name;
            i++;
        } else if (element instanceof Task) {

        } else if (element instanceof Component && !initComponent) {
            if (first) {
                document.getElementById("sComponent").innerHTML = "<option value=\"null\"> All </option>";
                first = false;
            }
            document.getElementById("sComponent").innerHTML += "<option value=\"" + element.id + "\">" + element.name + "</option>";
            document.getElementById("sSetComponent").innerHTML += "<option value=\"" + element.id + "\">" + element.name + "</option>";
        } else if (element instanceof Component) {

        } else if (element instanceof Task_state && !initTask_state) {
            if (first) {
                document.getElementById("sStatus").innerHTML = "<option value=\"null\"> All </option>";
                first = false;
            }
            document.getElementById("sSetStatus").innerHTML += "<option value=\"" + element.id + "\">" + element.name + "</option>";
            document.getElementById("sStatus").innerHTML += "<option value=\"" + element.id + "\">" + element.name + "</option>";
        } else if (element instanceof Task_state) {

        }
    });


    if (tipe instanceof Sprint && !initSprint) {
        initSprint = true;
    } else if (tipe instanceof Department && !initDepartment) {
        initDepartment = true;
    } else if (tipe instanceof User && !initUser) {
        initUser = true;
    } else if (tipe instanceof Task) {
        document.getElementById("tableTasks").innerHTML = generateTable(table, args);
    } else if (tipe instanceof Component && !initComponent) {
        intitComponent = true;
    } else if (tipe instanceof Task_state && !initTask_state) {
        initTask_state = true;
    }
}