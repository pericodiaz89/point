<?php
 include ('Service.php');
 define('Comment', 'Comment');
 class CommentService extends Service {

	 public function includeSpecificFiles() {
		 include('../model/Comment.php');
	 }

	 public function create() {
		 if (checkParam(Comment)) {
			  $Comment = $this->getComment();
			  return Comment::create($Comment);
		}else{
			 return getErrorArray(03, "Parameters missing (Comment)");
		 }
	 }

	 public function modify() {
		 if (checkParam(Comment)) {
			 $Comment = $this->getComment();
			 return Comment::modify($Comment);
		 }else{
			 return getErrorArray(03, "Parameters missing (Comment)");
		 }
	 }

	 public function delete() {
		 if (checkParam(Comment)){
			 $Comment = $this->getComment();
			 return Comment::delete($Comment);
		 }else{
			 return getErrorArray(03, "Parameters missing (Comment)");
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
				$A = (Comment::getList($_REQUEST['page'], $_REQUEST['count'], $filters, $orderby));
			} else {
				$A = (Comment::getList($_REQUEST['page'], $_REQUEST['count'], $filters, NULL));
			}
			 return ArrayHelper::toArray($A);
		 } else {
			 return getErrorArray(03, "Parameters missing (page, count)");
		 }
	 }

	 public function getComment() {
		 return Comment::get(json_decode($_REQUEST[Comment]));
	}
 }

 new CommentService();
 ?>