var buttons;
var parent;
$(document).ready(function() {
    checkUser();

    // <editor-fold defaultstate="collapsed" desc="Events">

     $("#bNewComponent").click(function() {
        $("#new_component_panel").modal();
    });

    $("#bNewComponentPanelCancel").click(function() {
        $("#new_component_panel").modal('hide');
    });

    $("#bCreateNewComponent").click(function(){
        var name = tComponentName.value;
        if(name!=""){
            var newComponent = new Component("null", name, project.id, parent);
            newComponent.create(addNewComponent);
        }
    });
   // </editor-fold>

});

function addNewComponent(data){
    var html = '<div class="btn-group">' +
            '<button onclick=checkButton(' + data.id + ') class="btn " data-toggle="button">' +
            '<span class="icon-ok-sign"></span>' +
            '</button>' +
            '<button onclick=loadComponents(' + data.id + ') class="btn">' + data.name + '</button>' +
            '</div>';
     $("#components").append(html);
     $("#new_component_panel").modal('hide');
}

function checkUser() {
    if (localStorage.getItem('user') == undefined) {
        window.top.location.href = 'index.html';
    } else {
        parent = "null";
        var p = jQuery.parseJSON(localStorage.getItem('project'));
        project = new Project(p.id, p.name);
        Component.get(0,0,{"project_id":project.id},[],loadRoot);
    }
}

function loadRoot(data){
    var html = "";
    console.log(project.id);
    buttons = new Array();
    data.forEach(function(element){
        if(element.parent_id == undefined){
            buttons[element.id] = false;
            html+='<div class="btn-group">'+
                  '<button onclick=checkButton('+element.id+') class="btn " data-toggle="button">'+
                  '<span class="icon-ok-sign"></span>'+
                  '</button>'+
                  '<button onclick=loadComponents('+element.id+') class="btn">'+ element.name +'</button>'+
                  '</div>';
        }
    });
    $("#components").html(html);
}

function checkButton(id){
    buttons[id] = !buttons[id];
}

function loadComponents(id){
    parent = id;
    $("#ruta").append('<li id=l'+id+' class="active"><span class="divider">/</span>'+Components[id].name+'</li>');
    var html = "";

    Components.forEach(function(element){
        if(element.parent_id == id){
            buttons[element.id] = false;
            html+='<div class="btn-group">'+
                  '<button onclick=checkButton('+element.id+') class="btn " data-toggle="button">'+
                  '<span class="icon-ok-sign"></span>'+
                  '</button>'+
                  '<button onclick=loadComponents('+element.id+') class="btn">'+ element.name +'</button>'+
                  '</div>';
        }
    });
    $("#components").html(html);
}