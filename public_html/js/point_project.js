var user;
var project;
var sprint;
var updateTask;

$(document).ready(function() {
    checkUser();                
    $("#bNewSprint").click(function() {
        $("#new_sprint_panel").modal();
    });
    $("#bCreateTask").click(function() {
        $("#new_task_panel").modal();
    });
    $("#createSprint").click(function() {
        $("#new_sprint_panel").modal('hide');
        var nSprint = new Sprint(project.id, tSprintDescription.value, tSprintName.value, "null", tSprintDate.value);
        nSprint.create(function(sprint) {
            $("#sSprint").append('<option value="' + sprint.id + '">' + sprint.name + '</option>');
        });
    });

    $("#sSprint").change(function() {
        sprint = Sprints[$(this).val()];
        Task.get(0, 0, {"project_id": project.id, "sprint_id": $("#sSprint").val()}, loadTasks);
    });

    $("#bUpdateSearch").click(function() {
        var filter = {"project_id": project.id, "sprint_id": $("#sSprint").val()};
        if ($("#sDepartment").val() != "null") {
            filter["department_id"] = $("#sDepartment").val();
        }
        if ($("#sStatus").val() != "null") {
            filter["state_id"] = $("#sStatus").val();
        }
        if ($("#sUser").val() != "null") {
            filter["user_id"] = $("#sUser").val();
        }
        Task.get(0, 0, filter, loadTasks);
    });

    // <editor-fold defaultstate="collapsed" desc="Create New Task">
    $("#bCreateNewTask").click(function() {
        var name = tTaskName.value;
        var desc = tTaskDescription.value;
        if ($("input[type='radio'].radioNewTask").is(':checked')) {
            var points = $("input[type='radio'].radioNewTask:checked").val();
        }
        var dep = document.getElementById("sSetDepartment");
        var depVal = dep.options[dep.selectedIndex].value;
//        console.log(depVal);
        var status = document.getElementById("sSetStatus");
        var statusVal = status.options[status.selectedIndex].value;
//        console.log(statusVal);
        var user = document.getElementById("sSetUser");
        var userVal = user.options[user.selectedIndex].value;
//        console.log(userVal);
        var comp = document.getElementById("sSetComponent");
        var compVal = comp.options[comp.selectedIndex].value;
//        console.log(compVal);
        var sprint = document.getElementById("sSprint");
        var SprintVal = sprint.options[sprint.selectedIndex].value;
        ;

        var newTask = new Task(userVal, "null", SprintVal, compVal, points, project.id, depVal, name, desc, statusVal);
        newTask.create(function(objetoNuevo) {
            $("#new_task_panel").modal('hide');
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
                args[7] = Components[objetoNuevo.component_id].name;
            } else {
                args[7] = "N/A";
            }
            args[8] = Task_states[objetoNuevo.state_id].name;
            $("#tableTasks").append(generateRow(args));
        });
    });
    // </editor-fold>
    
    $("#bUpdateTask").click(function (){
        console.log($("#sStatusUpdate").val());
        Tasks[updateTask].state_id = $("#sStatusUpdate").val();
        Tasks[updateTask].user_id = $("#sUserUpdate").val();
        Tasks[updateTask].component_id = "null"//TODO: implement 
        Tasks[updateTask].update(updatecheck());
        //Task_states[Tasks[updateTask].state_id].update();
    });
});

function updatecheck(data){
    console.log(data);
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
        document.getElementById("lcurrentSprint").innerHTML = "Backlog";

        Sprint.get(0, 20, {"project_id": project.id}, loadSprints);
        Department.get(0, 10, {}, loadDepartments);
        User.get(0, 10, {}, loadUsers);
//        Component.get(0, 0, {"project_id": project.id});
        Task_state.get(0, 0, {}, loadTask_states);
    }
}

function loadTask_states(data) {
    var htmlTaskStates = "";
    data.forEach(function(element) {
        htmlTaskStates += "<option value=\"" + element.id + "\">" + element.name + "</option>";
    });
    $("#sStatus").html("<option value=\"null\"> All </option>" + htmlTaskStates);
    $("#sSetStatus").html(htmlTaskStates);
    $("#sStatusUpdate").html(htmlTaskStates);
}

function loadUsers(data) {
    var htmlUsers = "";
    data.forEach(function(element) {
        htmlUsers += "<option value=\"" + element.id + "\">" + element.name + "</option>";
    });
    $("#sUser").html("<option value=\"null\"> All </option>" + htmlUsers);
    $("#sSetUser").html("<option value=\"null\"> N/A </option>" + htmlUsers);
    $("#sUserUpdate").html("<option value=\"null\">N/A</option>" + htmlUsers);
}

function loadSprints(data) {
    var htmlSprints = "";
    data.forEach(function(element) {
        htmlSprints += "<option value=\"" + element.id + "\">" + element.name + " </option>";
    });
    $("#sSprintChange").html(htmlSprints);
    $("#sSprint").html(htmlSprints);
    Task.get(0, 0, {"project_id": project.id, "sprint_id": $("#sSprint").val()}, loadTasks);
}

function loadDepartments(data) {
    var htmlDepartments = "";
    data.forEach(function(element) {
        htmlDepartments += "<option value=\"" + element.id + "\">" + element.name + " </option>";
    });

    $("#sDepartment").html("<option value=\"null\"> All </option>" + htmlDepartments);
    $("#sSetDepartment").html(htmlDepartments);
}

function loadTasks(data) {
    var table = new Array();
    var args = new Array();
    table[0] = "✓";
    table[1] = "#";
    table[2] = "Name";
    table[3] = "Points";
    table[4] = "User";
    table[5] = "Department";
    table[6] = "Component";
    table[7] = "Status";
    var i = 0;
    data.forEach(function(element) {
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
    });
    $("#tableTasks").html(generateTableFunction(table, args,"loadSpec"));
}

function loadSpec(id){
    $("#task_panel").modal();
    $("#lInfoName").html("#" + id + " " + $("#Name"+id).html());
    $("#lLinfoDep").html($("#Department"+id).html())
    $("#optionsRadios"+$("#Points"+id).html()).click();
    updateTask = id;
    //console.log(Task_states[Tasks[id].state_id]);
    //console.log(Tasks[id])
    
}

