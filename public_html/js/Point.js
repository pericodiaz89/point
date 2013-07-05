 // <editor-fold defaultstate="collapsed" desc="Dictionary">
var urlbase = 'http://127.0.0.1/Emerald%20Digital%20Entertainment/Applications/Point/public_html/pointws/services/';// Webservice Base
var Comments =  new Array();
var Tasks =  new Array();
var Sprints =  new Array();
var Departments =  new Array();
var Components =  new Array();
var Projects =  new Array();
var Users =  new Array();
// </editor-fold>
 // <editor-fold defaultstate="collapsed" desc="Model">
// <editor-fold defaultstate="collapsed" desc="Comment">
//Comment

function Comment (id,comment,user_id,task_id){
	this.id = id;
	this.comment = comment;
	this.user_id = user_id;
	this.task_id = task_id;
	this.create = function() {
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
	};
}
Comment.get = function(pages, counts, filter) {
	var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter)};
	callService(urlbase + "/CommentService.php", params, "Comment.init", null);
};
Comment.init = function(data) {
	for (var i = 0; i < data.length; i++) {
		Comments[data[i].id] = new Comment(data[i].id,data[i].comment,data[i].user_id,data[i].task_id);
	}
	getFinished(Comments);
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Task">
//Task

function Task (department_id,description,sprint_id,user_id,name,points,project_id,component_id,id){
	this.department_id = department_id;
	this.description = description;
	this.sprint_id = sprint_id;
	this.user_id = user_id;
	this.name = name;
	this.points = points;
	this.project_id = project_id;
	this.component_id = component_id;
	this.id = id;
	this.create = function() {
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
	};
}
Task.get = function(pages, counts, filter) {
	var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter)};
	callService(urlbase + "/TaskService.php", params, "Task.init", null);
};
Task.init = function(data) {
	for (var i = 0; i < data.length; i++) {
		Tasks[data[i].id] = new Task(data[i].department_id,data[i].description,data[i].sprint_id,data[i].user_id,data[i].name,data[i].points,data[i].project_id,data[i].component_id,data[i].id);
	}
	getFinished(Tasks);
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Sprint">
//Sprint

function Sprint (description,name,date,id,project_id){
	this.description = description;
	this.name = name;
	this.date = date;
	this.id = id;
	this.project_id = project_id;
	this.create = function() {
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
	};
}
Sprint.get = function(pages, counts, filter) {
	var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter)};
	callService(urlbase + "/SprintService.php", params, "Sprint.init", null);
};
Sprint.init = function(data) {
	for (var i = 0; i < data.length; i++) {
		Sprints[data[i].id] = new Sprint(data[i].description,data[i].name,data[i].date,data[i].id,data[i].project_id);
	}
	getFinished(Sprints);
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Department">
//Department

function Department (name,id){
	this.name = name;
	this.id = id;
	this.create = function() {
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
	};
}
Department.get = function(pages, counts, filter) {
	var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter)};
	callService(urlbase + "/DepartmentService.php", params, "Department.init", null);
};
Department.init = function(data) {
	for (var i = 0; i < data.length; i++) {
		Departments[data[i].id] = new Department(data[i].name,data[i].id);
	}
	getFinished(Departments);
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Component">
//Component

function Component (project_id,id,name){
	this.project_id = project_id;
	this.id = id;
	this.name = name;
	this.create = function() {
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
	};
}
Component.get = function(pages, counts, filter) {
	var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter)};
	callService(urlbase + "/ComponentService.php", params, "Component.init", null);
};
Component.init = function(data) {
	for (var i = 0; i < data.length; i++) {
		Components[data[i].id] = new Component(data[i].project_id,data[i].id,data[i].name);
	}
	getFinished(Components);
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Project">
//Project

function Project (name,id){
	this.name = name;
	this.id = id;
	this.create = function() {
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
	};
}
Project.get = function(pages, counts, filter) {
	var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter)};
	callService(urlbase + "/ProjectService.php", params, "Project.init", null);
};
Project.init = function(data) {
	for (var i = 0; i < data.length; i++) {
		Projects[data[i].id] = new Project(data[i].name,data[i].id);
	}
	getFinished(Projects);
};
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="User">
//User

function User (username,password,id,email,name){
	this.username = username;
	this.password = password;
	this.id = id;
	this.email = email;
	this.name = name;
	this.create = function() {
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
	};
}
User.get = function(pages, counts, filter) {
	var params = {command: "get", page: pages, count: counts, filters: JSON.stringify(filter)};
	callService(urlbase + "/UserService.php", params, "User.init", null);
};
User.init = function(data) {
	for (var i = 0; i < data.length; i++) {
		Users[data[i].id] = new User(data[i].username,data[i].password,data[i].id,data[i].email,data[i].name);
	}
	getFinished(Users);
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
}		, error: function(e, xhr) {				console.log(e);
		}});
}
// </editor-fold>