<?php
 include ('Service.php');
 define('Department', 'Department');
 class DepartmentService extends Service {

	 public function includeSpecificFiles() {
		 include('../model/Department.php');
	 }

	 public function create() {
		 if (checkParam(Department)) {
			  $Department = $this->getDepartment();
			  return Department::create($Department);
		}else{
			 return getErrorArray(03, "Parameters missing (Department)");
		 }
	 }

	 public function modify() {
		 if (checkParam(Department)) {
			 $Department = $this->getDepartment();
			 return Department::modify($Department);
		 }else{
			 return getErrorArray(03, "Parameters missing (Department)");
		 }
	 }

	 public function delete() {
		 if (checkParam(Department)){
			 $Department = $this->getDepartment();
			 return Department::delete($Department);
		 }else{
			 return getErrorArray(03, "Parameters missing (Department)");
		 }
	 }

	 public function get() {
		 $filters = array();
		 if (checkParam('filters')) {
			  $filters = json_decode($_REQUEST['filters']);
		 }
		 if (checkParams('page', 'count')) {
			  $A = (Department::getList($_REQUEST['page'], $_REQUEST['count'], $filters));
			 return ArrayHelper::toArray($A);
		 } else {
			 return getErrorArray(03, "Parameters missing (page, count)");
		 }
	 }

	 public function getDepartment() {
		 return Department::get(json_decode($_REQUEST[Department]));
	}
 }

 new DepartmentService();
 ?>