<?php 
 class Task {

	 private $project_id;
	 private $points;
	 private $name;
	 private $sprint_id;
	 private $id;
	 private $user_id;
	 private $description;
	 private $component_id;
	 private $department_id;

 function __construct($project_id, $points, $name, $sprint_id, $id, $user_id, $description, $component_id, $department_id){
		 $this->project_id=$project_id;
		 $this->points=$points;
		 $this->name=$name;
		 $this->sprint_id=$sprint_id;
		 $this->id=$id;
		 $this->user_id=$user_id;
		 $this->description=$description;
		 $this->component_id=$component_id;
		 $this->department_id=$department_id;
	}
 
	public static function get($object){
		if(property_exists($object, "Task")){
			$object = $object->Task;
		}
		return new Task ($object->project_id, $object->points, $object->name, $object->sprint_id, $object->id, $object->user_id, $object->description, $object->component_id, $object->department_id);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

	 public function getProject_id() {
		 return $this->project_id;
	 }

	 public function setProject_id($project_id){
		$this->project_id = $project_id;
	}

	 public function getPoints() {
		 return $this->points;
	 }

	 public function setPoints($points){
		$this->points = $points;
	}

	 public function getName() {
		 return $this->name;
	 }

	 public function setName($name){
		$this->name = $name;
	}

	 public function getSprint_id() {
		 return $this->sprint_id;
	 }

	 public function setSprint_id($sprint_id){
		$this->sprint_id = $sprint_id;
	}

	 public function getId() {
		 return $this->id;
	 }

	 public function setId($id){
		$this->id = $id;
	}

	 public function getUser_id() {
		 return $this->user_id;
	 }

	 public function setUser_id($user_id){
		$this->user_id = $user_id;
	}

	 public function getDescription() {
		 return $this->description;
	 }

	 public function setDescription($description){
		$this->description = $description;
	}

	 public function getComponent_id() {
		 return $this->component_id;
	 }

	 public function setComponent_id($component_id){
		$this->component_id = $component_id;
	}

	 public function getDepartment_id() {
		 return $this->department_id;
	 }

	 public function setDepartment_id($department_id){
		$this->department_id = $department_id;
	}
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Task){
		$mysql = MysqlDBC::getInstance();
		
		 $project_id = $mysql->checkVariable($Task->getProject_id());
		 $points = $mysql->checkVariable($Task->getPoints());
		 $name = $mysql->checkVariable($Task->getName());
		 $sprint_id = $mysql->checkVariable($Task->getSprint_id());
		 $id = $mysql->checkVariable($Task->getId());
		 $user_id = $mysql->checkVariable($Task->getUser_id());
		 $description = $mysql->checkVariable($Task->getDescription());
		 $component_id = $mysql->checkVariable($Task->getComponent_id());
		 $department_id = $mysql->checkVariable($Task->getDepartment_id());
		return $mysql->insert(
				 " INSERT INTO `task` (`project_id`,`points`,`name`,`sprint_id`,`id`,`user_id`,`description`,`component_id`,`department_id`) VALUES ('$project_id','$points','$name','$sprint_id','$id','$user_id','$description','$component_id','$department_id')"
		);
	}

	 public static function modify($Task){
		$mysql = MysqlDBC::getInstance();
		
		 $project_id = $mysql->checkVariable($Task->getProject_id());
		 $points = $mysql->checkVariable($Task->getPoints());
		 $name = $mysql->checkVariable($Task->getName());
		 $sprint_id = $mysql->checkVariable($Task->getSprint_id());
		 $id = $mysql->checkVariable($Task->getId());
		 $user_id = $mysql->checkVariable($Task->getUser_id());
		 $description = $mysql->checkVariable($Task->getDescription());
		 $component_id = $mysql->checkVariable($Task->getComponent_id());
		 $department_id = $mysql->checkVariable($Task->getDepartment_id());
		 return $mysql->update(
				"UPDATE `task` SET`project_id`='$project_id',`points`='$points',`name`='$name',`sprint_id`='$sprint_id',`user_id`='$user_id',`description`='$description',`component_id`='$component_id',`department_id`='$department_id' WHERE `id` = '$id' " 
		 );
	}

	 public static function delete($Task){
		$mysql = MysqlDBC::getInstance();
		
		 $project_id = $mysql->checkVariable($Task->getProject_id());
		 $points = $mysql->checkVariable($Task->getPoints());
		 $name = $mysql->checkVariable($Task->getName());
		 $sprint_id = $mysql->checkVariable($Task->getSprint_id());
		 $id = $mysql->checkVariable($Task->getId());
		 $user_id = $mysql->checkVariable($Task->getUser_id());
		 $description = $mysql->checkVariable($Task->getDescription());
		 $component_id = $mysql->checkVariable($Task->getComponent_id());
		 $department_id = $mysql->checkVariable($Task->getDepartment_id());
		 return $mysql->delete("DELETE FROM `task` WHERE `id` = '$id' LIMIT 1"
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
				$where .= "task." . $keys[$i] . " = " . $filters[$keys[$i]];
				if ($i < count($keys) - 1) {
					 $where .= " AND ";
				 }
			 }
		 }
		 $result = MysqlDBC::getInstance()->getResult("SELECT * FROM `task` $where $limit");
		  $list = array();
		 while ($row = $result->fetch_object()) {
			 $Entity = Task::get($row);
			 array_push($list, $Entity);
		 }
		 return $list;
	 }

	  // </editor-fold>

	 public function toArray() {
		 return array(
			'project_id' => $this->getProject_id,
			'points' => $this->getPoints,
			'name' => $this->getName,
			'sprint_id' => $this->getSprint_id,
			'id' => $this->getId,
			'user_id' => $this->getUser_id,
			'description' => $this->getDescription,
			'component_id' => $this->getComponent_id,
			'department_id' => $this->getDepartment_id
		 );
	}
}

?>