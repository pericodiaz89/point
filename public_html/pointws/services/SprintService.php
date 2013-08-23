<?php
 include ('Service.php');
 define('Sprint', 'Sprint');
 class SprintService extends Service {

	 public function includeSpecificFiles() {
		 include('../model/Sprint.php');
	 }

	 public function create() {
		 if (checkParam(Sprint)) {
			  $Sprint = $this->getSprint();
			  return Sprint::create($Sprint);
		}else{
			 return getErrorArray(03, "Parameters missing (Sprint)");
		 }
	 }

	 public function modify() {
		 if (checkParam(Sprint)) {
			 $Sprint = $this->getSprint();
			 return Sprint::modify($Sprint);
		 }else{
			 return getErrorArray(03, "Parameters missing (Sprint)");
		 }
	 }

	 public function delete() {
		 if (checkParam(Sprint)){
			 $Sprint = $this->getSprint();
			 return Sprint::delete($Sprint);
		 }else{
			 return getErrorArray(03, "Parameters missing (Sprint)");
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
				$A = (Sprint::getList($_REQUEST['page'], $_REQUEST['count'], $filters, $orderby));
			} else {
				$A = (Sprint::getList($_REQUEST['page'], $_REQUEST['count'], $filters, NULL));
			}
			 return ArrayHelper::toArray($A);
		 } else {
			 return getErrorArray(03, "Parameters missing (page, count)");
		 }
	 }

	 public function getSprint() {
		 return Sprint::get(json_decode($_REQUEST[Sprint]));
	}
 }

 new SprintService();
 ?>