<?php
 include ('Service.php');
 define('Componentchild', 'Componentchild');
 class ComponentchildService extends Service {

	 public function includeSpecificFiles() {
		 include('../model/Componentchild.php');
	 }

	 public function create() {
		 if (checkParam(Componentchild)) {
			  $Componentchild = $this->getComponentchild();
			  return Componentchild::create($Componentchild);
		}else{
			 return getErrorArray(03, "Parameters missing (Componentchild)");
		 }
	 }

	 public function modify() {
		 if (checkParam(Componentchild)) {
			 $Componentchild = $this->getComponentchild();
			 return Componentchild::modify($Componentchild);
		 }else{
			 return getErrorArray(03, "Parameters missing (Componentchild)");
		 }
	 }

	 public function delete() {
		 if (checkParam(Componentchild)){
			 $Componentchild = $this->getComponentchild();
			 return Componentchild::delete($Componentchild);
		 }else{
			 return getErrorArray(03, "Parameters missing (Componentchild)");
		 }
	 }

	 public function get() {
		 $filters = array();
		 if (checkParam('filters')) {
			  $filters = json_decode($_REQUEST['filters']);
		 }
		 if (checkParams('page', 'count')) {
			  $A = (Componentchild::getList($_REQUEST['page'], $_REQUEST['count'], $filters));
			 return ArrayHelper::toArray($A);
		 } else {
			 return getErrorArray(03, "Parameters missing (page, count)");
		 }
	 }

	 public function getComponentchild() {
		 return Componentchild::get(json_decode($_REQUEST[Componentchild]));
	}
 }

 new ComponentchildService();
 ?>