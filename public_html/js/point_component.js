var buttons;
$(document).ready(function() {
    checkUser();
});

function checkUser() {
    if (localStorage.getItem('user') == undefined) {
        window.top.location.href = 'index.html';
    } else {
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

/*
 * <ul class="breadcrumb">
                        <li><a href="#">Root</a> <span class="divider">/</span></li>
                        <li><a href="#">Component 1</a> <span class="divider">/</span></li>
                        <li class="active">Current Component Name</li>
                    </ul>
 */