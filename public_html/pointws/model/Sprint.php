<?php 
 class Sprint {

	 private $name;
	 private $project_id;
	 private $date;
	 private $id;
	 private $description;

 function __construct($name, $project_id, $date, $id, $description){
		 $this->name=$name;
		 $this->project_id=$project_id;
		 $this->date=$date;
		 $this->id=$id;
		 $this->description=$description;
	}
 
	public static function get($object){
		if(property_exists($object, "Sprint")){
			$object = $object->Sprint;
		}
		return new Sprint ($object->name, $object->project_id, $object->date, $object->id, $object->description);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

	 public function getName() {
		 return $this->name;
	 }

	 public function setName($name){
		$this->name = $name;
	}

	 public function getProject_id() {
		 return $this->project_id;
	 }

	 public function setProject_id($project_id){
		$this->project_id = $project_id;
	}

	 public function getDate() {
		 return $this->date;
	 }

	 public function setDate($date){
		$this->date = $date;
	}

	 public function getId() {
		 return $this->id;
	 }

	 public function setId($id){
		$this->id = $id;
	}

	 public function getDescription() {
		 return $this->description;
	 }

	 public function setDescription($description){
		$this->description = $description;
	}
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Sprint){
		$mysql = MysqlDBC::getInstance();
		
		 $name = $mysql->checkVariable($Sprint->getName());
		 $project_id = $mysql->checkVariable($Sprint->getProject_id());
		 $date = $mysql->checkVariable($Sprint->getDate());
		 $id = $mysql->checkVariable($Sprint->getId());
		 $description = $mysql->checkVariable($Sprint->getDescription());
		return $mysql->insert(
				 " INSERT INTO `sprint` (`name`,`project_id`,`date`,`id`,`description`) VALUES ('$name','$project_id','$date','$id','$description')"
		);
	}

	 public static function modify($Sprint){
		$mysql = MysqlDBC::getInstance();
		
		 $name = $mysql->checkVariable($Sprint->getName());
		 $project_id = $mysql->checkVariable($Sprint->getProject_id());
		 $date = $mysql->checkVariable($Sprint->getDate());
		 $id = $mysql->checkVariable($Sprint->getId());
		 $description = $mysql->checkVariable($Sprint->getDescription());
		 return $mysql->update(
				"UPDATE `sprint` SET`name`='$name',`project_id`='$project_id',`date`='$date',`description`='$description' WHERE `id` = '$id' " 
		 );
	}

	 public static function delete($Sprint){
		$mysql = MysqlDBC::getInstance();
		
		 $name = $mysql->checkVariable($Sprint->getName());
		 $project_id = $mysql->checkVariable($Sprint->getProject_id());
		 $date = $mysql->checkVariable($Sprint->getDate());
		 $id = $mysql->checkVariable($Sprint->getId());
		 $description = $mysql->checkVariable($Sprint->getDescription());
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
		if (is_array($filters) && count($filters) > 0) {
			$where = " WHERE ";
			$keys = array_keys($filters);
			for ($i = 0; $i < count($keys); $i++) {
				$where .= "sprint." . $keys[$i] . " = " . $filters[$keys[$i]];
				if ($i < count($keys) - 1) {
					 $where .= " AND ";
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
			'name' => $this->getName,
			'project_id' => $this->getProject_id,
			'date' => $this->getDate,
			'id' => $this->getId,
			'description' => $this->getDescription
		 );
	}
}

?>