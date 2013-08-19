<?php
 include ('Service.php');
 define('Task_state', 'Task_state');
 class Task_stateService extends Service {

	 public function includeSpecificFiles() {
		 include('../model/Task_state.php');
	 }

	 public function create() {
		 if (checkParam(Task_state)) {
			  $Task_state = $this->getTask_state();
			  return Task_state::create($Task_state);
		}else{
			 return getErrorArray(03, "Parameters missing (Task_state)");
		 }
	 }

	 public function modify() {
		 if (checkParam(Task_state)) {
			 $Task_state = $this->getTask_state();
			 return Task_state::modify($Task_state);
		 }else{
			 return getErrorArray(03, "Parameters missing (Task_state)");
		 }
	 }

	 public function delete() {
		 if (checkParam(Task_state)){
			 $Task_state = $this->getTask_state();
			 return Task_state::delete($Task_state);
		 }else{
			 return getErrorArray(03, "Parameters missing (Task_state)");
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
				$A = (Task_state::getList($_REQUEST['page'], $_REQUEST['count'], $filters, $orderby));
			} else {
				$A = (Task_state::getList($_REQUEST['page'], $_REQUEST['count'], $filters, NULL));
			}
			 return ArrayHelper::toArray($A);
		 } else {
			 return getErrorArray(03, "Parameters missing (page, count)");
		 }
	 }

	 public function getTask_state() {
		 return Task_state::get(json_decode($_REQUEST[Task_state]));
	}
 }

 new Task_stateService();
 ?>