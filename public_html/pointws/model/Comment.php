<?php 
 class Comment {

	 private $user_id;
	 private $id;
	 private $task_id;
	 private $comment;

 function __construct($user_id, $id, $task_id, $comment){
		 $this->user_id=$user_id;
		 $this->id=$id;
		 $this->task_id=$task_id;
		 $this->comment=$comment;
	}
 
	public static function get($object){
		if(property_exists($object, "Comment")){
			$object = $object->Comment;
		}
		return new Comment ($object->user_id, $object->id, $object->task_id, $object->comment);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

	 public function getUser_id() {
		 return $this->user_id;
	 }

	 public function setUser_id($user_id){
		$this->user_id = $user_id;
	}

	 public function getId() {
		 return $this->id;
	 }

	 public function setId($id){
		$this->id = $id;
	}

	 public function getTask_id() {
		 return $this->task_id;
	 }

	 public function setTask_id($task_id){
		$this->task_id = $task_id;
	}

	 public function getComment() {
		 return $this->comment;
	 }

	 public function setComment($comment){
		$this->comment = $comment;
	}
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Comment){
		$mysql = MysqlDBC::getInstance();
		
		 $user_id = $mysql->checkVariable($Comment->getUser_id());
		 $id = $mysql->checkVariable($Comment->getId());
		 $task_id = $mysql->checkVariable($Comment->getTask_id());
		 $comment = $mysql->checkVariable($Comment->getComment());
		return $mysql->insert(
				 " INSERT INTO `comment` (`user_id`,`id`,`task_id`,`comment`) VALUES ('$user_id','$id','$task_id','$comment')"
		);
	}

	 public static function modify($Comment){
		$mysql = MysqlDBC::getInstance();
		
		 $user_id = $mysql->checkVariable($Comment->getUser_id());
		 $id = $mysql->checkVariable($Comment->getId());
		 $task_id = $mysql->checkVariable($Comment->getTask_id());
		 $comment = $mysql->checkVariable($Comment->getComment());
		 return $mysql->update(
				"UPDATE `comment` SET`user_id`='$user_id',`task_id`='$task_id',`comment`='$comment' WHERE `id` = '$id' " 
		 );
	}

	 public static function delete($Comment){
		$mysql = MysqlDBC::getInstance();
		
		 $user_id = $mysql->checkVariable($Comment->getUser_id());
		 $id = $mysql->checkVariable($Comment->getId());
		 $task_id = $mysql->checkVariable($Comment->getTask_id());
		 $comment = $mysql->checkVariable($Comment->getComment());
		 return $mysql->delete("DELETE FROM `comment` WHERE `id` = '$id' LIMIT 1"
		);
	}

	 public static function getList($page, $count, $filters) {
		 // <editor-fold defaultstate="collapsed" desc="Limit">
		 $limit = "";
		 if ($count > 0 && $page >= 0) {
			 $lowerLimit = $page * $count;
			 $limit = " LIMIT $lowerLimit, $count";
		}
		// </editor-fold>
		// <editor-fold defaultstate="collapsed" desc="Where">
		$where = "";
		if (is_array($filters) && count($filters) > 0) {
			$where = " WHERE ";
			$keys = array_keys($filters);
			for ($i = 0; $i < count($keys); $i++) {
				$where .= "comment." . $keys[$i] . " = " . $filters[$keys[$i]];
				if ($i < count($keys) - 1) {
					 $where .= " AND ";
				 }
			 }
		 }
		 $result = MysqlDBC::getInstance()->getResult("SELECT * FROM `comment` $where $limit");
		  $list = array();
		 while ($row = $result->fetch_object()) {
			 $Entity = Comment::get($row);
			 array_push($list, $Entity);
		 }
		 return $list;
	 }

	  // </editor-fold>

	 public function toArray() {
		 return array(
			'user_id' => $this->getUser_id,
			'id' => $this->getId,
			'task_id' => $this->getTask_id,
			'comment' => $this->getComment
		 );
	}
}

?>