<?php
 include ('Service.php');
 define('Component', 'Component');
 class ComponentService extends Service {

	 public function includeSpecificFiles() {
		 include('../model/Component.php');
	 }

	 public function create() {
		 if (checkParam(Component)) {
			  $Component = $this->getComponent();
			  return Component::create($Component);
		}else{
			 return getErrorArray(03, "Parameters missing (Component)");
		 }
	 }

	 public function modify() {
		 if (checkParam(Component)) {
			 $Component = $this->getComponent();
			 return Component::modify($Component);
		 }else{
			 return getErrorArray(03, "Parameters missing (Component)");
		 }
	 }

	 public function delete() {
		 if (checkParam(Component)){
			 $Component = $this->getComponent();
			 return Component::delete($Component);
		 }else{
			 return getErrorArray(03, "Parameters missing (Component)");
		 }
	 }

	 public function get() {
		 $filters = array();
		 if (checkParam('filters')) {
			  $filters = json_decode($_REQUEST['filters']);
		 }
		 if (checkParams('page', 'count')) {
			  $A = (Component::getList($_REQUEST['page'], $_REQUEST['count'], $filters));
			 return ArrayHelper::toArray($A);
		 } else {
			 return getErrorArray(03, "Parameters missing (page, count)");
		 }
	 }

	 public function getComponent() {
		 return Component::get(json_decode($_REQUEST[Component]));
	}
 }

 new ComponentService();
 ?>