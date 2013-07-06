$(document).ready(function() {
    $("table tr").click(function() {
        $("#task_panel").modal();
    });
    $("#bCreateSprint").click(function() {
        $("#new_sprint_panel").modal();
    });
    $("#bCreateTask").click(function() {
        $("#new_task_panel").modal();
    });
});

document.addEventListener('touchmove', function(e) {
    $("#task_panel").modal();
}, false);

