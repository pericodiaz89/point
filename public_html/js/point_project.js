var user;
var project;
var sprint;
var updateTask;
var isCreatingTask = true;

$(document).ready(function() {
    checkUser();

    // <editor-fold defaultstate="collapsed" desc="Events">

    $("#sSprint").change(function() {
        sprint = Sprints[$(this).val()];
        localStorage.setItem(project.name+'lastSprint',$(this).val());
        Tasks = [];
        Task.get(0, 0, {"project_id": project.id, "sprint_id": $("#sSprint").val()},[], loadTasks);
    });

    // <editor-fold defaultstate="collapsed" desc="Clicks">
    $("#lLogOut").click(function(){
        localStorage.clear();
        window.top.location.href = 'index.html';
    });
    $("#bNewSprint").click(function() {
        $("#new_sprint_panel").modal();
    });
    $("#bCreateTask").click(function() {
        $("#bCreateNewTask").text("Create Task");
        $("#lNewTask").text("New Task");
        isCreatingTask = true;
        tTaskName.value = "";
        tTaskDescription.value = "";
        $("#new_task_panel").modal();
    });
    $("#createSprint").click(function() {
        $("#new_sprint_panel").modal('hide');
        var nSprint = new Sprint(project.id, tSprintDescription.value, tSprintName.value, "null", tSprintDate.value);
        nSprint.create(function(sprint) {
            $("#sSprint").append('<option value="' + sprint.id + '">' + sprint.name + '</option>');
            $("#sSprintChange").append('<option value="' + sprint.id + '">' + sprint.name + '</option>');
        });
    });

    $("#bNewComment").click(function() {
        $("#bNewComment").button('loading');
        var comment = tNewComment.value;
        var c = new Comment(comment, updateTask, 0, getTimeStamp(), user.id);
        c.create(function(data) {
            addComments(data);
        });
        tNewComment.value = "";
    });

    $("#bUpdateSearch").click(function() {
        refreshTable();
    });

    $("#bSendToSprint").click(function() {
        var taskIds = new Array();
        var table = document.getElementById("tableTasks");
        for (var i = 1; i < table.rows.length; i++) {
            if (table.rows[i].cells[0].getElementsByTagName("input")[0].checked) {
                taskIds.push(table.rows[i].id);
            }
        }
        var params = {"command": "setTasksToSprint", "tasks": JSON.stringify(taskIds), "sprint_id": $("#sSprintChange").val()};
        callService(urlbase + "/ProjectCtrlService.php", params, "refreshTable", null);
    });

    $("#bNewTaskPanelCancel").click(function() {
        $("#new_task_panel").modal('hide');
    });

    $("#bSprintPanelCancel").click(function() {
        $("#new_sprint_panel").modal('hide');
    });

    $("#bUpdateTask").click(function() {
        if ($("input[type='radio'].radioUpdateTask").is(':checked')) {
            Tasks[updateTask].points = $("input[type='radio'].radioUpdateTask:checked").val();
        }
        Tasks[updateTask].state_id = $("#sStatusUpdate").val();
        Tasks[updateTask].user_id = $("#sUserUpdate").val();
        if (Tasks[updateTask].component_id == null) {
            Tasks[updateTask].component_id = "null";
        }
        console.log(Tasks[updateTask]);
        Tasks[updateTask].update("updatecheck");
    });

    $("#bModifyTask").click(function() {
        $("#task_panel").modal('hide');
        $("#new_task_panel").modal();
        isCreatingTask = false;
        var T = Tasks[updateTask];
        tTaskName.value = T.name;
        tTaskDescription.value = T.description;
        $("#sSetDepartment").val(T.department_id).attr('selected', true);
        $("#sSetUser").val(T.user_id).attr('selected', true);
        $("#sSetStatus").val(T.state_id).attr('selected', true);
        $("#sSetComponent").val(T.component_id).attr('selected', true);
        //$("#sSetStatus").val(T.state_id).attr('selected', true); TODO Component
        $("#rbOptionNewTask" + $("#Points" + T.id).html()).click();

        $("#bCreateNewTask").text("Update Task");
        $("#lNewTask").text("Update Task");
    });

    $("#bDeleteTask").click(function(){
        $("#task_panel").modal('hide');
        $("#confirmation_panel").modal();
    });

    $("#bConfirmation").click(function() {
        Tasks[updateTask].remove(function(){
            Tasks[updateTask]=undefined;
            refreshTable();
        });
        $("#confirmation_panel").modal('hide');
    });

    $("#bCancel").click(function() {
        $("#confirmation_panel").modal('hide');

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

        var status = document.getElementById("sSetStatus");
        var statusVal = status.options[status.selectedIndex].value;

        var user = document.getElementById("sSetUser");
        var userVal = user.options[user.selectedIndex].value;

        var comp = document.getElementById("sSetComponent");
        var compVal = comp.options[comp.selectedIndex].value;

        var sprint = document.getElementById("sSprint");
        var SprintVal = sprint.options[sprint.selectedIndex].value;

        if (isCreatingTask) {
            var newTask = new Task(project.id, 'null', name, desc, points, userVal, depVal, compVal, SprintVal, statusVal, '');
            //var newTask = new Task(userVal, "null", SprintVal, compVal, points, project.id, depVal, name, desc, statusVal, '');
            newTask.create(function(objetoNuevo) {
                $("#new_task_panel").modal('hide');
                loadTasks(Tasks);
            });
        } else {
            var T = Tasks[updateTask];
            T.department_id = depVal;
            T.description = desc;
            T.name = name;
            T.points = points;
            T.state_id = statusVal;
            T.user_id = userVal;
            T.component_id = compVal;
            T.update("updatecheck");
        }
    });
    // </editor-fold>

    // </editor-fold>

    // </editor-fold>
});

function updatecheck(data) {
    $("#task_panel").modal('hide');
    $("#new_task_panel").modal('hide');
    loadTasks(Tasks);
}

function refreshTable() {
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
    if ($("#sComponent").val() != "null") {
        filter["component_id"] = $("#sComponent").val();
    }
    Task.get(0, 0, filter, ["id DESC"], loadTasks);
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

        Sprint.get(0, 0, {"project_id": project.id}, [], loadSprints);
        Department.get(0, 0, {}, [], loadDepartments);
        User.get(0, 0, {}, [], loadUsers);
        Component.get(0, 0, {"project_id": project.id}, [], loadComponents);
        Task_state.get(0, 0, {}, [], loadTask_states);
    }
}

// <editor-fold defaultstate="collapsed" desc="Load Entities">
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
    $("#sSprint").html(htmlSprints);
    if(localStorage.getItem(project.name+'lastSprint')!=undefined){
        $("#sSprint").val(localStorage.getItem(project.name+'lastSprint')).attr('selected', true);
    }
    Task.get(0, 0, {"project_id": project.id, "sprint_id": $("#sSprint").val()}, ["id DESC"], loadTasks);
}

function loadDepartments(data) {
    var htmlDepartments = "";
    data.forEach(function(element) {
        htmlDepartments += "<option value=\"" + element.id + "\">" + element.name + " </option>";
    });

    $("#sDepartment").html("<option value=\"null\"> All </option>" + htmlDepartments);
    $("#sSetDepartment").html(htmlDepartments);
}

function loadComponents(data) {
    var htmlDepartments = "";
    data.forEach(function(element) {
        htmlDepartments += "<option value=\"" + element.id + "\">" + element.name + " </option>";
    });

    $("#sComponent").html("<option value=\"null\"> All </option>" + htmlDepartments);
    $("#sSetComponent").html("<option value=\"null\">N/A</option>" + htmlDepartments);
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
    var sum = 0;
    data.forEach(function(element) {
        args[i] = new Array();
        args[i][0] = element.id;
        args[i][1] = "<input type=\"checkbox\">​";
        args[i][2] = element.id;
        args[i][3] = element.name;
        args[i][4] = element.points;
        sum += parseInt(element.points);
        if (element.user_id != null && element.user_id != "null") {
            args[i][5] = Users[element.user_id].name;
        } else {
            args[i][5] = "N/A";
        }
        args[i][6] = Departments[element.department_id].name;
        if (element.component_id != null && element.component_id != "null") {
            args[i][7] = Components[element.component_id].name;
        } else {
            args[i][7] = "N/A";
        }
        args[i][8] = Task_states[element.state_id].name;
        i++;
    });
    $("#tableTasks").html(generateTableFunction(table, args, "loadSpec"));
    $("#pointSum").html("Point Sum: " + sum);
}

function loadSpec(id) {
    var T = Tasks[id];
    //TODO set User
    clearComments();
    $("#bNewComment").button('loading');
    $("#task_panel").modal();
    $("#lInfoName").html("#" + id + " " + $("#Name" + id).html());
    $("#lLinfoDep").html($("#Department" + id).html());
    $("#lLInfoComp").html($("#Component" + id).html());
    $("#sUserUpdate").val(T.user_id).attr('selected', true);
    $("#sStatusUpdate").val(T.state_id).attr('selected', true);
    $("#tTaskDescription_taskpanel").text(T.description);
    $("#optionsRadios" + $("#Points" + id).html()).click();

    updateTask = id;
    Comment.get(0, 0, {'task_id': id}, [], setComments);
}
// </editor-fold>
function checked(){
    var count = 0;
    var sum = 0;
    var table = document.getElementById("tableTasks");
    for (var i = 1; i < table.rows.length; i++) {
        sum += parseInt ($("#"+table.rows[i].cells[3].id).html());
        if (table.rows[i].cells[0].getElementsByTagName("input")[0].checked) {
            count += parseInt ($("#"+table.rows[i].cells[3].id).html());
        }
    }

        console.log(count);
        if(count!=0){
            $("#selectedPointSum").html("Points Selected: " + count);
        }else{
            $("#selectedPointSum").html("");
        }

}

// <editor-fold defaultstate="collapsed" desc="Comments">
function clearComments() {
    $("#commentList").html("");
}

function setComments(data) {
    var htmlComments = "";
    data.forEach(function(element) {
        htmlComments += '<div class="text-left"> <b>' + element.time + ' ' + Users[element.user_id].name
        + ': </b>' + element.comment + '</div>';
    });
    $("#commentList").html(htmlComments);
    $("#bNewComment").button('reset');
}

function addComments(element) {
    var htmlComments = '<div class="text-left"> <b>' + element.time + ' ' + Users[element.user_id].name
    + ': </b>' + element.comment + '</div>';
    $("#commentList").append(htmlComments);
    $("#bNewComment").button('reset');
}

// </editor-fold>

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
