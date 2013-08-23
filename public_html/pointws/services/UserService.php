<?php
 include ('Service.php');
 define('User', 'User');
 class UserService extends Service {

	 public function includeSpecificFiles() {
		 include('../model/User.php');
	 }

	 public function create() {
		 if (checkParam(User)) {
			  $User = $this->getUser();
			  return User::create($User);
		}else{
			 return getErrorArray(03, "Parameters missing (User)");
		 }
	 }

	 public function modify() {
		 if (checkParam(User)) {
			 $User = $this->getUser();
			 return User::modify($User);
		 }else{
			 return getErrorArray(03, "Parameters missing (User)");
		 }
	 }

	 public function delete() {
		 if (checkParam(User)){
			 $User = $this->getUser();
			 return User::delete($User);
		 }else{
			 return getErrorArray(03, "Parameters missing (User)");
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
				$A = (User::getList($_REQUEST['page'], $_REQUEST['count'], $filters, $orderby));
			} else {
				$A = (User::getList($_REQUEST['page'], $_REQUEST['count'], $filters, NULL));
			}
			 return ArrayHelper::toArray($A);
		 } else {
			 return getErrorArray(03, "Parameters missing (page, count)");
		 }
	 }

	 public function getUser() {
		 return User::get(json_decode($_REQUEST[User]));
	}
 }

 new UserService();
 ?>