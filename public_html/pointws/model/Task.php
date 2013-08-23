<?php 
 class Task {

	 private $project_id;
	 private $id;
	 private $name;
	 private $description;
	 private $points;
	 private $user_id;
	 private $department_id;
	 private $component_id;
	 private $sprint_id;
	 private $state_id;
	 private $timestamp;

 function __construct($project_id, $id, $name, $description, $points, $user_id, $department_id, $component_id, $sprint_id, $state_id, $timestamp){
		 $this->project_id=$project_id;
		 $this->id=$id;
		 $this->name=$name;
		 $this->description=$description;
		 $this->points=$points;
		 $this->user_id=$user_id;
		 $this->department_id=$department_id;
		 $this->component_id=$component_id;
		 $this->sprint_id=$sprint_id;
		 $this->state_id=$state_id;
		 $this->timestamp=$timestamp;
	}
 
	public static function get($object){
		if(property_exists($object, "Task")){
			$object = $object->Task;
		}
		return new Task ($object->project_id, $object->id, $object->name, $object->description, $object->points, $object->user_id, $object->department_id, $object->component_id, $object->sprint_id, $object->state_id, $object->timestamp);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

	 public function getProject_id() {
		 return $this->project_id;
	 }

	 public function setProject_id($project_id){
		$this->project_id = $project_id;
	}

	 public function getId() {
		 return $this->id;
	 }

	 public function setId($id){
		$this->id = $id;
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

	 public function getPoints() {
		 return $this->points;
	 }

	 public function setPoints($points){
		$this->points = $points;
	}

	 public function getUser_id() {
		 return $this->user_id;
	 }

	 public function setUser_id($user_id){
		$this->user_id = $user_id;
	}

	 public function getDepartment_id() {
		 return $this->department_id;
	 }

	 public function setDepartment_id($department_id){
		$this->department_id = $department_id;
	}

	 public function getComponent_id() {
		 return $this->component_id;
	 }

	 public function setComponent_id($component_id){
		$this->component_id = $component_id;
	}

	 public function getSprint_id() {
		 return $this->sprint_id;
	 }

	 public function setSprint_id($sprint_id){
		$this->sprint_id = $sprint_id;
	}

	 public function getState_id() {
		 return $this->state_id;
	 }

	 public function setState_id($state_id){
		$this->state_id = $state_id;
	}

	 public function getTimestamp() {
		 return $this->timestamp;
	 }

	 public function setTimestamp($timestamp){
		$this->timestamp = $timestamp;
	}
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Task){
		$mysql = MysqlDBC::getInstance();
		
		 $project_id = $mysql->checkVariable($Task->getProject_id());
		 $id = $mysql->checkVariable($Task->getId());
		 $name = $mysql->checkVariable($Task->getName());
		 $description = $mysql->checkVariable($Task->getDescription());
		 $points = $mysql->checkVariable($Task->getPoints());
		 $user_id = $mysql->checkVariable($Task->getUser_id());
		 $department_id = $mysql->checkVariable($Task->getDepartment_id());
		 $component_id = $mysql->checkVariable($Task->getComponent_id());
		 $sprint_id = $mysql->checkVariable($Task->getSprint_id());
		 $state_id = $mysql->checkVariable($Task->getState_id());
		 $timestamp = $mysql->checkVariable($Task->getTimestamp());
		return $mysql->insert(
				 " INSERT INTO `task` (`project_id`,`id`,`name`,`description`,`points`,`user_id`,`department_id`,`component_id`,`sprint_id`,`state_id`,`timestamp`) VALUES ($project_id,$id,$name,$description,$points,$user_id,$department_id,$component_id,$sprint_id,$state_id,$timestamp)"
		);
	}

	 public static function modify($Task){
		$mysql = MysqlDBC::getInstance();
		
		 $project_id = $mysql->checkVariable($Task->getProject_id());
		 $id = $mysql->checkVariable($Task->getId());
		 $name = $mysql->checkVariable($Task->getName());
		 $description = $mysql->checkVariable($Task->getDescription());
		 $points = $mysql->checkVariable($Task->getPoints());
		 $user_id = $mysql->checkVariable($Task->getUser_id());
		 $department_id = $mysql->checkVariable($Task->getDepartment_id());
		 $component_id = $mysql->checkVariable($Task->getComponent_id());
		 $sprint_id = $mysql->checkVariable($Task->getSprint_id());
		 $state_id = $mysql->checkVariable($Task->getState_id());
		 $timestamp = $mysql->checkVariable($Task->getTimestamp());
		 return $mysql->update(
				"UPDATE `task` SET`name`=$name,`description`=$description,`points`=$points,`user_id`=$user_id,`department_id`=$department_id,`component_id`=$component_id,`sprint_id`=$sprint_id,`state_id`=$state_id,`timestamp`=$timestamp WHERE `project_id` = $project_id AND `id` = $id " 
		);
	}

	public static function delete($Task){
		$mysql = MysqlDBC::getInstance();
		
		 $project_id = $mysql->checkVariable($Task->getProject_id());
		 $id = $mysql->checkVariable($Task->getId());
		 $name = $mysql->checkVariable($Task->getName());
		 $description = $mysql->checkVariable($Task->getDescription());
		 $points = $mysql->checkVariable($Task->getPoints());
		 $user_id = $mysql->checkVariable($Task->getUser_id());
		 $department_id = $mysql->checkVariable($Task->getDepartment_id());
		 $component_id = $mysql->checkVariable($Task->getComponent_id());
		 $sprint_id = $mysql->checkVariable($Task->getSprint_id());
		 $state_id = $mysql->checkVariable($Task->getState_id());
		 $timestamp = $mysql->checkVariable($Task->getTimestamp());
		 return $mysql->delete("DELETE FROM `task` WHERE `project_id` = $project_id AND `id` = $id LIMIT 1"
		);
	}

	public static function getList($page, $count, $filters,$orderby) {
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
				if (preg_match('/' . preg_quote('.*') . '/', $filters[$keys[$i]])) {
					$filters[$keys[$i]] = str_replace('.*', '%', $filters[$keys[$i]]);
					$where .= "task." . $keys[$i] . " LIKE '" . $filters[$keys[$i]] . "'";
				} else {
					$where .= "task." . $keys[$i] . " = '" . $filters[$keys[$i]] . "'";
					}
					if ($i < count($keys) - 1) {
						$where .= " AND ";
					}
				}
			}
		}
		// </editor-fold>
		// <editor-fold defaultstate="collapsed" desc="Order By">
		$ob = '';
		if (isset($orderby) && count($orderby) > 0) {
			$ob = " ORDER BY ";
			for ($i = 0; $i < count($orderby); $i++) {
				$ob .= $orderby[$i];
				if ($i < count($orderby) - 1) {
					$ob .= ", ";
				}
			}
		}
		// </editor-fold>
		$result = MysqlDBC::getInstance()->getResult("SELECT * FROM `task` $where $ob $limit");
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
			'project_id' => $this->getProject_id(),
			'id' => $this->getId(),
			'name' => $this->getName(),
			'description' => $this->getDescription(),
			'points' => $this->getPoints(),
			'user_id' => $this->getUser_id(),
			'department_id' => $this->getDepartment_id(),
			'component_id' => $this->getComponent_id(),
			'sprint_id' => $this->getSprint_id(),
			'state_id' => $this->getState_id(),
			'timestamp' => $this->getTimestamp()
		 );
	}
}

?>