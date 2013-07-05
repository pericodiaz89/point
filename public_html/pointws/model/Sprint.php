<?php 
 class Sprint {

	 private $date;
	 private $description;
	 private $project_id;
	 private $id;
	 private $name;

 function __construct($date, $description, $project_id, $id, $name){
		 $this->date=$date;
		 $this->description=$description;
		 $this->project_id=$project_id;
		 $this->id=$id;
		 $this->name=$name;
	}
 
	public static function get($object){
		if(property_exists($object, "Sprint")){
			$object = $object->Sprint;
		}
		return new Sprint ($object->date, $object->description, $object->project_id, $object->id, $object->name);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

	 public function getDate() {
		 return $this->date;
	 }

	 public function setDate($date){
		$this->date = $date;
	}

	 public function getDescription() {
		 return $this->description;
	 }

	 public function setDescription($description){
		$this->description = $description;
	}

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
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Sprint){
		$mysql = MysqlDBC::getInstance();
		
		 $date = $mysql->checkVariable($Sprint->getDate());
		 $description = $mysql->checkVariable($Sprint->getDescription());
		 $project_id = $mysql->checkVariable($Sprint->getProject_id());
		 $id = $mysql->checkVariable($Sprint->getId());
		 $name = $mysql->checkVariable($Sprint->getName());
		return $mysql->insert(
				 " INSERT INTO `sprint` (`date`,`description`,`project_id`,`id`,`name`) VALUES ('$date','$description','$project_id','$id','$name')"
		);
	}

	 public static function modify($Sprint){
		$mysql = MysqlDBC::getInstance();
		
		 $date = $mysql->checkVariable($Sprint->getDate());
		 $description = $mysql->checkVariable($Sprint->getDescription());
		 $project_id = $mysql->checkVariable($Sprint->getProject_id());
		 $id = $mysql->checkVariable($Sprint->getId());
		 $name = $mysql->checkVariable($Sprint->getName());
		 return $mysql->update(
				"UPDATE `sprint` SET`date`='$date',`description`='$description',`project_id`='$project_id',`name`='$name' WHERE `id` = '$id' " 
		);
	}

	public static function delete($Sprint){
		$mysql = MysqlDBC::getInstance();
		
		 $date = $mysql->checkVariable($Sprint->getDate());
		 $description = $mysql->checkVariable($Sprint->getDescription());
		 $project_id = $mysql->checkVariable($Sprint->getProject_id());
		 $id = $mysql->checkVariable($Sprint->getId());
		 $name = $mysql->checkVariable($Sprint->getName());
		 return $mysql->delete("DELETE FROM `sprint` WHERE `id` = '$id' LIMIT 1"
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
					$where .= "sprint." . $keys[$i] . " = '" . $filters[$keys[$i]] . "'";
					if ($i < count($keys) - 1) {
						$where .= " AND ";
					}
				}
			}
		}
		$result = MysqlDBC::getInstance()->getResult("SELECT * FROM `sprint` $where $limit");
		$list = array();
		while ($row = $result->fetch_object()) {
			$Entity = Sprint::get($row);
			array_push($list, $Entity);
		}
		return $list;
	 }

	// </editor-fold>

	public function toArray() {
		return array(
			'date' => $this->getDate(),
			'description' => $this->getDescription(),
			'project_id' => $this->getProject_id(),
			'id' => $this->getId(),
			'name' => $this->getName()
		 );
	}
}

?>