$(document).ready(function() {
    $("table tr").click(function() {
        $("#task_panel").modal();
    });
    $("#new_sprint_panel").modal();
});

document.addEventListener('touchmove', function(e) {
    $("#task_panel").modal();
}, false);

