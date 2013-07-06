<?php 
 class Comment {

	 private $id;
	 private $task_id;
	 private $time;
	 private $comment;
	 private $user_id;

 function __construct($id, $task_id, $time, $comment, $user_id){
		 $this->id=$id;
		 $this->task_id=$task_id;
		 $this->time=$time;
		 $this->comment=$comment;
		 $this->user_id=$user_id;
	}
 
	public static function get($object){
		if(property_exists($object, "Comment")){
			$object = $object->Comment;
		}
		return new Comment ($object->id, $object->task_id, $object->time, $object->comment, $object->user_id);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

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

	 public function getTime() {
		 return $this->time;
	 }

	 public function setTime($time){
		$this->time = $time;
	}

	 public function getComment() {
		 return $this->comment;
	 }

	 public function setComment($comment){
		$this->comment = $comment;
	}

	 public function getUser_id() {
		 return $this->user_id;
	 }

	 public function setUser_id($user_id){
		$this->user_id = $user_id;
	}
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Comment){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Comment->getId());
		 $task_id = $mysql->checkVariable($Comment->getTask_id());
		 $time = $mysql->checkVariable($Comment->getTime());
		 $comment = $mysql->checkVariable($Comment->getComment());
		 $user_id = $mysql->checkVariable($Comment->getUser_id());
		return $mysql->insert(
				 " INSERT INTO `comment` (`id`,`task_id`,`time`,`comment`,`user_id`) VALUES ('$id','$task_id','$time','$comment','$user_id')"
		);
	}

	 public static function modify($Comment){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Comment->getId());
		 $task_id = $mysql->checkVariable($Comment->getTask_id());
		 $time = $mysql->checkVariable($Comment->getTime());
		 $comment = $mysql->checkVariable($Comment->getComment());
		 $user_id = $mysql->checkVariable($Comment->getUser_id());
		 return $mysql->update(
				"UPDATE `comment` SET`time`='$time',`comment`='$comment',`user_id`='$user_id' WHERE `id` = '$id' AND `task_id` = '$task_id' " 
		);
	}

	public static function delete($Comment){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Comment->getId());
		 $task_id = $mysql->checkVariable($Comment->getTask_id());
		 $time = $mysql->checkVariable($Comment->getTime());
		 $comment = $mysql->checkVariable($Comment->getComment());
		 $user_id = $mysql->checkVariable($Comment->getUser_id());
		 return $mysql->delete("DELETE FROM `comment` WHERE `id` = '$id' AND `task_id` = '$task_id' LIMIT 1"
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
		if (is_object($filters)) {
			$filters = get_object_vars($filters);
			if (is_array($filters) && count($filters) > 0) {
				$where = " WHERE ";
				$keys = array_keys($filters);
				for ($i = 0; $i < count($keys); $i++) {
					$where .= "comment." . $keys[$i] . " = '" . $filters[$keys[$i]] . "'";
					if ($i < count($keys) - 1) {
						$where .= " AND ";
					}
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
			'id' => $this->getId(),
			'task_id' => $this->getTask_id(),
			'time' => $this->getTime(),
			'comment' => $this->getComment(),
			'user_id' => $this->getUser_id()
		 );
	}
}

?>