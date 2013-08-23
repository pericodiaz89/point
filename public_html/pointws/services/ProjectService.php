<?php
 include ('Service.php');
 define('Project', 'Project');
 class ProjectService extends Service {

	 public function includeSpecificFiles() {
		 include('../model/Project.php');
	 }

	 public function create() {
		 if (checkParam(Project)) {
			  $Project = $this->getProject();
			  return Project::create($Project);
		}else{
			 return getErrorArray(03, "Parameters missing (Project)");
		 }
	 }

	 public function modify() {
		 if (checkParam(Project)) {
			 $Project = $this->getProject();
			 return Project::modify($Project);
		 }else{
			 return getErrorArray(03, "Parameters missing (Project)");
		 }
	 }

	 public function delete() {
		 if (checkParam(Project)){
			 $Project = $this->getProject();
			 return Project::delete($Project);
		 }else{
			 return getErrorArray(03, "Parameters missing (Project)");
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
				$A = (Project::getList($_REQUEST['page'], $_REQUEST['count'], $filters, $orderby));
			} else {
				$A = (Project::getList($_REQUEST['page'], $_REQUEST['count'], $filters, NULL));
			}
			 return ArrayHelper::toArray($A);
		 } else {
			 return getErrorArray(03, "Parameters missing (page, count)");
		 }
	 }

	 public function getProject() {
		 return Project::get(json_decode($_REQUEST[Project]));
	}
 }

 new ProjectService();
 ?>