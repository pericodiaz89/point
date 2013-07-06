<?php 
 class Task {

	 private $points;
	 private $id;
	 private $sprint_id;
	 private $project_id;
	 private $component_id;
	 private $department_id;
	 private $user_id;
	 private $name;
	 private $description;

 function __construct($points, $id, $sprint_id, $project_id, $component_id, $department_id, $user_id, $name, $description){
		 $this->points=$points;
		 $this->id=$id;
		 $this->sprint_id=$sprint_id;
		 $this->project_id=$project_id;
		 $this->component_id=$component_id;
		 $this->department_id=$department_id;
		 $this->user_id=$user_id;
		 $this->name=$name;
		 $this->description=$description;
	}
 
	public static function get($object){
		if(property_exists($object, "Task")){
			$object = $object->Task;
		}
		return new Task ($object->points, $object->id, $object->sprint_id, $object->project_id, $object->component_id, $object->department_id, $object->user_id, $object->name, $object->description);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

	 public function getPoints() {
		 return $this->points;
	 }

	 public function setPoints($points){
		$this->points = $points;
	}

	 public function getId() {
		 return $this->id;
	 }

	 public function setId($id){
		$this->id = $id;
	}

	 public function getSprint_id() {
		 return $this->sprint_id;
	 }

	 public function setSprint_id($sprint_id){
		$this->sprint_id = $sprint_id;
	}

	 public function getProject_id() {
		 return $this->project_id;
	 }

	 public function setProject_id($project_id){
		$this->project_id = $project_id;
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

	 public function getUser_id() {
		 return $this->user_id;
	 }

	 public function setUser_id($user_id){
		$this->user_id = $user_id;
	}

	 public function getName() {
		 return $this->name;
	 }

	 public function setName($name){
		$this->name = $name;
	}

	 public function getDescription() {
		 return $this->description;
	 }

	 public function setDescription($description){
		$this->description = $description;
	}
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Task){
		$mysql = MysqlDBC::getInstance();
		
		 $points = $mysql->checkVariable($Task->getPoints());
		 $id = $mysql->checkVariable($Task->getId());
		 $sprint_id = $mysql->checkVariable($Task->getSprint_id());
		 $project_id = $mysql->checkVariable($Task->getProject_id());
		 $component_id = $mysql->checkVariable($Task->getComponent_id());
		 $department_id = $mysql->checkVariable($Task->getDepartment_id());
		 $user_id = $mysql->checkVariable($Task->getUser_id());
		 $name = $mysql->checkVariable($Task->getName());
		 $description = $mysql->checkVariable($Task->getDescription());
		return $mysql->insert(
				 " INSERT INTO `task` (`points`,`id`,`sprint_id`,`project_id`,`component_id`,`department_id`,`user_id`,`name`,`description`) VALUES ('$points','$id','$sprint_id','$project_id','$component_id','$department_id','$user_id','$name','$description')"
		);
	}

	 public static function modify($Task){
		$mysql = MysqlDBC::getInstance();
		
		 $points = $mysql->checkVariable($Task->getPoints());
		 $id = $mysql->checkVariable($Task->getId());
		 $sprint_id = $mysql->checkVariable($Task->getSprint_id());
		 $project_id = $mysql->checkVariable($Task->getProject_id());
		 $component_id = $mysql->checkVariable($Task->getComponent_id());
		 $department_id = $mysql->checkVariable($Task->getDepartment_id());
		 $user_id = $mysql->checkVariable($Task->getUser_id());
		 $name = $mysql->checkVariable($Task->getName());
		 $description = $mysql->checkVariable($Task->getDescription());
		 return $mysql->update(
				"UPDATE `task` SET`points`='$points',`sprint_id`='$sprint_id',`component_id`='$component_id',`department_id`='$department_id',`user_id`='$user_id',`name`='$name',`description`='$description' WHERE `id` = '$id' AND `project_id` = '$project_id' " 
		);
	}

	public static function delete($Task){
		$mysql = MysqlDBC::getInstance();
		
		 $points = $mysql->checkVariable($Task->getPoints());
		 $id = $mysql->checkVariable($Task->getId());
		 $sprint_id = $mysql->checkVariable($Task->getSprint_id());
		 $project_id = $mysql->checkVariable($Task->getProject_id());
		 $component_id = $mysql->checkVariable($Task->getComponent_id());
		 $department_id = $mysql->checkVariable($Task->getDepartment_id());
		 $user_id = $mysql->checkVariable($Task->getUser_id());
		 $name = $mysql->checkVariable($Task->getName());
		 $description = $mysql->checkVariable($Task->getDescription());
		 return $mysql->delete("DELETE FROM `task` WHERE `id` = '$id' AND `project_id` = '$project_id' LIMIT 1"
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
					$where .= "task." . $keys[$i] . " = '" . $filters[$keys[$i]] . "'";
					if ($i < count($keys) - 1) {
						$where .= " AND ";
					}
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
			'points' => $this->getPoints(),
			'id' => $this->getId(),
			'sprint_id' => $this->getSprint_id(),
			'project_id' => $this->getProject_id(),
			'component_id' => $this->getComponent_id(),
			'department_id' => $this->getDepartment_id(),
			'user_id' => $this->getUser_id(),
			'name' => $this->getName(),
			'description' => $this->getDescription()
		 );
	}
}

?>