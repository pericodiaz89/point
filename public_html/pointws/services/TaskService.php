<?php
 include ('Service.php');
 define('Task', 'Task');
 class TaskService extends Service {

	 public function includeSpecificFiles() {
		 include('../model/Task.php');
	 }

	 public function create() {
		 if (checkParam(Task)) {
			  $Task = $this->getTask();
			  return Task::create($Task);
		}else{
			 return getErrorArray(03, "Parameters missing (Task)");
		 }
	 }

	 public function modify() {
		 if (checkParam(Task)) {
			 $Task = $this->getTask();
			 return Task::modify($Task);
		 }else{
			 return getErrorArray(03, "Parameters missing (Task)");
		 }
	 }

	 public function delete() {
		 if (checkParam(Task)){
			 $Task = $this->getTask();
			 return Task::delete($Task);
		 }else{
			 return getErrorArray(03, "Parameters missing (Task)");
		 }
	 }

	 public function get() {
		 $filters = array();
		 if (checkParam('filters')) {
			  $filters = json_decode($_REQUEST['filters']);
		 }
		 if (checkParams('page', 'count')) {
			if (checkParam('orderby')) {
				$orderby = json_decode($_REQUEST['orderby']);
				$A = (Task::getList($_REQUEST['page'], $_REQUEST['count'], $filters, $orderby));
			} else {
				$A = (Task::getList($_REQUEST['page'], $_REQUEST['count'], $filters, NULL));
			}
			 return ArrayHelper::toArray($A);
		 } else {
			 return getErrorArray(03, "Parameters missing (page, count)");
		 }
	 }

	 public function getTask() {
		 return Task::get(json_decode($_REQUEST[Task]));
	}
 }

 new TaskService();
 ?>