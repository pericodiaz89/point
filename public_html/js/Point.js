// <editor-fold defaultstate="collapsed" desc="Dictionary">
var urlbase = 'pointws/services';// Webservice Base
var Comments = new Array();
var Components = new Array();
var Departments = new Array();
var Projects = new Array();
var Sprints = new Array();
var Tasks = new Array();
var Task_states = new Array();
var Users = new Array();
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Model">
// <editor-fold defaultstate="collapsed" desc="Comment">
//Comment

function Comment(id, comment, time, task_id, user_id) {
    this.id = id;
    this.comment = comment;
    this.time = time;
    this.task_id = task_id;
    this.user_id = user_id;
    this.create = function(callback) {
        this.createCallBack = callback;
        var params = {command: "create", Comment: JSON.stringify(this)};
        callService(urlbase + "/CommentService.php", params, "register", this);
    };
    this.remove = function(callBack) {
        var params = {command: "delete", Comment: JSON.stringify(this)};
        callService(urlbase + "/CommentService.php", params, callBack, null);
        Comments[this.id] = undefined;
    };
    this.update = function(callBack) {
        var params = {command: "modify", Comment: JSON.stringify(this)};
        callService(urlbase + "/CommentService.php", params, callBack, null);
    };
    this.register = function(data) {
        this.id = data;
        Comments[this.id] = this;
        this.createCallBack(this);
    };
}
Comment.get = function(pages, counts, filter, order, callback) {
    Comment.getCallBack = callback;
    var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter), orderby: JSON.stringify(order)};
    callService(urlbase + "/CommentService.php", params, "Comment.init", null);
};
Comment.init = function(data) {
    var newValues = new Array();
    for (var i = 0; i < data.length; i++) {
        var p = new Comment(data[i].id, data[i].comment, data[i].time, data[i].task_id, data[i].user_id);
        Comments[data[i].id] = p;
        newValues[i] = p;
    }
    if (Comment.getCallBack != undefined) {
        Comment.getCallBack(newValues);

    }
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Component">
//Component

function Component(id, name, project_id, parent_id) {
    this.id = id;
    this.name = name;
    this.project_id = project_id;
    this.parent_id = parent_id;
    this.create = function(callback) {
        this.createCallBack = callback;
        var params = {command: "create", Component: JSON.stringify(this)};
        callService(urlbase + "/ComponentService.php", params, "register", this);
    };
    this.remove = function(callBack) {
        var params = {command: "delete", Component: JSON.stringify(this)};
        callService(urlbase + "/ComponentService.php", params, callBack, null);
        Components[this.id] = undefined;
    };
    this.update = function(callBack) {
        var params = {command: "modify", Component: JSON.stringify(this)};
        callService(urlbase + "/ComponentService.php", params, callBack, null);
    };
    this.register = function(data) {
        this.id = data;
        Components[this.id] = this;
        this.createCallBack(this);
    };
}
Component.get = function(pages, counts, filter, order, callback) {
    Component.getCallBack = callback;
    var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter), orderby: JSON.stringify(order)};
    callService(urlbase + "/ComponentService.php", params, "Component.init", null);
};
Component.init = function(data) {
    var newValues = new Array();
    for (var i = 0; i < data.length; i++) {
        var p = new Component(data[i].id, data[i].name, data[i].project_id, data[i].parent_id);
        Components[data[i].id] = p;
        newValues[i] = p;
    }
    if (Component.getCallBack != undefined) {
        Component.getCallBack(newValues);

    }
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Department">
//Department

function Department(id, name) {
    this.id = id;
    this.name = name;
    this.create = function(callback) {
        this.createCallBack = callback;
        var params = {command: "create", Department: JSON.stringify(this)};
        callService(urlbase + "/DepartmentService.php", params, "register", this);
    };
    this.remove = function(callBack) {
        var params = {command: "delete", Department: JSON.stringify(this)};
        callService(urlbase + "/DepartmentService.php", params, callBack, null);
        Departments[this.id] = undefined;
    };
    this.update = function(callBack) {
        var params = {command: "modify", Department: JSON.stringify(this)};
        callService(urlbase + "/DepartmentService.php", params, callBack, null);
    };
    this.register = function(data) {
        this.id = data;
        Departments[this.id] = this;
        this.createCallBack(this);
    };
}
Department.get = function(pages, counts, filter, order, callback) {
    Department.getCallBack = callback;
    var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter), orderby: JSON.stringify(order)};
    callService(urlbase + "/DepartmentService.php", params, "Department.init", null);
};
Department.init = function(data) {
    var newValues = new Array();
    for (var i = 0; i < data.length; i++) {
        var p = new Department(data[i].id, data[i].name);
        Departments[data[i].id] = p;
        newValues[i] = p;
    }
    if (Department.getCallBack != undefined) {
        Department.getCallBack(newValues);

    }
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Project">
//Project

function Project(id, name) {
    this.id = id;
    this.name = name;
    this.create = function(callback) {
        this.createCallBack = callback;
        var params = {command: "create", Project: JSON.stringify(this)};
        callService(urlbase + "/ProjectService.php", params, "register", this);
    };
    this.remove = function(callBack) {
        var params = {command: "delete", Project: JSON.stringify(this)};
        callService(urlbase + "/ProjectService.php", params, callBack, null);
        Projects[this.id] = undefined;
    };
    this.update = function(callBack) {
        var params = {command: "modify", Project: JSON.stringify(this)};
        callService(urlbase + "/ProjectService.php", params, callBack, null);
    };
    this.register = function(data) {
        this.id = data;
        Projects[this.id] = this;
        this.createCallBack(this);
    };
}
Project.get = function(pages, counts, filter, order, callback) {
    Project.getCallBack = callback;
    var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter), orderby: JSON.stringify(order)};
    callService(urlbase + "/ProjectService.php", params, "Project.init", null);
};
Project.init = function(data) {
    var newValues = new Array();
    for (var i = 0; i < data.length; i++) {
        var p = new Project(data[i].id, data[i].name);
        Projects[data[i].id] = p;
        newValues[i] = p;
    }
    if (Project.getCallBack != undefined) {
        Project.getCallBack(newValues);

    }
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Sprint">
//Sprint

function Sprint(id, name, date, description, project_id) {
    this.id = id;
    this.name = name;
    this.date = date;
    this.description = description;
    this.project_id = project_id;
    this.create = function(callback) {
        this.createCallBack = callback;
        var params = {command: "create", Sprint: JSON.stringify(this)};
        callService(urlbase + "/SprintService.php", params, "register", this);
    };
    this.remove = function(callBack) {
        var params = {command: "delete", Sprint: JSON.stringify(this)};
        callService(urlbase + "/SprintService.php", params, callBack, null);
        Sprints[this.id] = undefined;
    };
    this.update = function(callBack) {
        var params = {command: "modify", Sprint: JSON.stringify(this)};
        callService(urlbase + "/SprintService.php", params, callBack, null);
    };
    this.register = function(data) {
        this.id = data;
        Sprints[this.id] = this;
        this.createCallBack(this);
    };
}
Sprint.get = function(pages, counts, filter, order, callback) {
    Sprint.getCallBack = callback;
    var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter), orderby: JSON.stringify(order)};
    callService(urlbase + "/SprintService.php", params, "Sprint.init", null);
};
Sprint.init = function(data) {
    var newValues = new Array();
    for (var i = 0; i < data.length; i++) {
        var p = new Sprint(data[i].id, data[i].name, data[i].date, data[i].description, data[i].project_id);
        Sprints[data[i].id] = p;
        newValues[i] = p;
    }
    if (Sprint.getCallBack != undefined) {
        Sprint.getCallBack(newValues);

    }
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Task">
//Task

function Task(project_id, id, name, description, points, user_id, department_id, component_id, sprint_id, state_id, timestamp) {
    this.project_id = project_id;
    this.id = id;
    this.name = name;
    this.description = description;
    this.points = points;
    this.user_id = user_id;
    this.department_id = department_id;
    this.component_id = component_id;
    this.sprint_id = sprint_id;
    this.state_id = state_id;
    this.timestamp = timestamp;
    this.create = function(callback) {
        this.createCallBack = callback;
        var params = {command: "create", Task: JSON.stringify(this)};
        callService(urlbase + "/TaskService.php", params, "register", this);
    };
    this.remove = function(callBack) {
        var params = {command: "delete", Task: JSON.stringify(this)};
        callService(urlbase + "/TaskService.php", params, callBack, null);
        Tasks[this.id] = undefined;
    };
    this.update = function(callBack) {
        var params = {command: "modify", Task: JSON.stringify(this)};
        callService(urlbase + "/TaskService.php", params, callBack, null);
    };
    this.register = function(data) {
        this.id = data;
        Tasks[this.id] = this;
        this.createCallBack(this);
    };
}
Task.get = function(pages, counts, filter, order, callback) {
    Task.getCallBack = callback;
    var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter), orderby: JSON.stringify(order)};
    callService(urlbase + "/TaskService.php", params, "Task.init", null);
};
Task.init = function(data) {
    var newValues = new Array();
    for (var i = 0; i < data.length; i++) {
        var p = new Task(data[i].project_id, data[i].id, data[i].name, data[i].description, data[i].points, data[i].user_id, data[i].department_id, data[i].component_id, data[i].sprint_id, data[i].state_id, data[i].timestamp);
        Tasks[data[i].id] = p;
        newValues[i] = p;
    }
    if (Task.getCallBack != undefined) {
        Task.getCallBack(newValues);

    }
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Task_state">
//Task_state

function Task_state(id, name) {
    this.id = id;
    this.name = name;
    this.create = function(callback) {
        this.createCallBack = callback;
        var params = {command: "create", Task_state: JSON.stringify(this)};
        callService(urlbase + "/Task_stateService.php", params, "register", this);
    };
    this.remove = function(callBack) {
        var params = {command: "delete", Task_state: JSON.stringify(this)};
        callService(urlbase + "/Task_stateService.php", params, callBack, null);
        Task_states[this.id] = undefined;
    };
    this.update = function(callBack) {
        var params = {command: "modify", Task_state: JSON.stringify(this)};
        callService(urlbase + "/Task_stateService.php", params, callBack, null);
    };
    this.register = function(data) {
        this.id = data;
        Task_states[this.id] = this;
        this.createCallBack(this);
    };
}
Task_state.get = function(pages, counts, filter, order, callback) {
    Task_state.getCallBack = callback;
    var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter), orderby: JSON.stringify(order)};
    callService(urlbase + "/Task_stateService.php", params, "Task_state.init", null);
};
Task_state.init = function(data) {
    var newValues = new Array();
    for (var i = 0; i < data.length; i++) {
        var p = new Task_state(data[i].id, data[i].name);
        Task_states[data[i].id] = p;
        newValues[i] = p;
    }
    if (Task_state.getCallBack != undefined) {
        Task_state.getCallBack(newValues);

    }
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="User">
//User

function User(id, username, password, name, email) {
    this.id = id;
    this.username = username;
    this.password = password;
    this.name = name;
    this.email = email;
    this.create = function(callback) {
        this.createCallBack = callback;
        var params = {command: "create", User: JSON.stringify(this)};
        callService(urlbase + "/UserService.php", params, "register", this);
    };
    this.remove = function(callBack) {
        var params = {command: "delete", User: JSON.stringify(this)};
        callService(urlbase + "/UserService.php", params, callBack, null);
        Users[this.id] = undefined;
    };
    this.update = function(callBack) {
        var params = {command: "modify", User: JSON.stringify(this)};
        callService(urlbase + "/UserService.php", params, callBack, null);
    };
    this.register = function(data) {
        this.id = data;
        Users[this.id] = this;
        this.createCallBack(this);
    };
}
User.get = function(pages, counts, filter, order, callback) {
    User.getCallBack = callback;
    var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter), orderby: JSON.stringify(order)};
    callService(urlbase + "/UserService.php", params, "User.init", null);
};
User.init = function(data) {
    var newValues = new Array();
    for (var i = 0; i < data.length; i++) {
        var p = new User(data[i].id, data[i].username, data[i].password, data[i].name, data[i].email);
        Users[data[i].id] = p;
        newValues[i] = p;
    }
    if (User.getCallBack != undefined) {
        User.getCallBack(newValues);
    }
};
// </editor-fold>
// </editor-fold>


// <editor-fold defaultstate="collapsed" desc="callService">
function callService(urlService, args, callBackFunction, element) {
    $.ajax({
        dataType: "jsonp",
        url: urlService,
        data: args,
        type: "GET",
        crossDomain: true,
        success: function(data) {
            if (element != null) {
                element[callBackFunction](data);
            } else {
                eval(callBackFunction)(data);
            }
        }, error: function(e, xhr) {
            console.log(e);
        }});
}
// </editor-fold>