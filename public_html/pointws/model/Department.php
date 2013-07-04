<?php 
 class Department {

	 private $name;
	 private $id;

 function __construct($name, $id){
		 $this->name=$name;
		 $this->id=$id;
	}
 
	public static function get($object){
		if(property_exists($object, "Department")){
			$object = $object->Department;
		}
		return new Department ($object->name, $object->id);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

	 public function getName() {
		 return $this->name;
	 }

	 public function setName($name){
		$this->name = $name;
	}

	 public function getId() {
		 return $this->id;
	 }

	 public function setId($id){
		$this->id = $id;
	}
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Department){
		$mysql = MysqlDBC::getInstance();
		
		 $name = $mysql->checkVariable($Department->getName());
		 $id = $mysql->checkVariable($Department->getId());
		return $mysql->insert(
				 " INSERT INTO `department` (`name`,`id`) VALUES ('$name','$id')"
		);
	}

	 public static function modify($Department){
		$mysql = MysqlDBC::getInstance();
		
		 $name = $mysql->checkVariable($Department->getName());
		 $id = $mysql->checkVariable($Department->getId());
		 return $mysql->update(
				"UPDATE `department` SET`name`='$name' WHERE `id` = '$id' " 
		 );
	}

	 public static function delete($Department){
		$mysql = MysqlDBC::getInstance();
		
		 $name = $mysql->checkVariable($Department->getName());
		 $id = $mysql->checkVariable($Department->getId());
		 return $mysql->delete("DELETE FROM `department` WHERE `id` = '$id' LIMIT 1"
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
				$where .= "department." . $keys[$i] . " = " . $filters[$keys[$i]];
				if ($i < count($keys) - 1) {
					 $where .= " AND ";
				 }
			 }
		 }
		 $result = MysqlDBC::getInstance()->getResult("SELECT * FROM `department` $where $limit");
		  $list = array();
		 while ($row = $result->fetch_object()) {
			 $Entity = Department::get($row);
			 array_push($list, $Entity);
		 }
		 return $list;
	 }

	  // </editor-fold>

	 public function toArray() {
		 return array(
			'name' => $this->getName,
			'id' => $this->getId
		 );
	}
}

?>