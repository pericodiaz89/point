<?php 
 class Component {

	 private $project_id;
	 private $id;
	 private $name;

 function __construct($project_id, $id, $name){
		 $this->project_id=$project_id;
		 $this->id=$id;
		 $this->name=$name;
	}
 
	public static function get($object){
		if(property_exists($object, "Component")){
			$object = $object->Component;
		}
		return new Component ($object->project_id, $object->id, $object->name);
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
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Component){
		$mysql = MysqlDBC::getInstance();
		
		 $project_id = $mysql->checkVariable($Component->getProject_id());
		 $id = $mysql->checkVariable($Component->getId());
		 $name = $mysql->checkVariable($Component->getName());
		return $mysql->insert(
				 " INSERT INTO `component` (`project_id`,`id`,`name`) VALUES ('$project_id','$id','$name')"
		);
	}

	 public static function modify($Component){
		$mysql = MysqlDBC::getInstance();
		
		 $project_id = $mysql->checkVariable($Component->getProject_id());
		 $id = $mysql->checkVariable($Component->getId());
		 $name = $mysql->checkVariable($Component->getName());
		 return $mysql->update(
				"UPDATE `component` SET`name`='$name' WHERE `project_id` = '$project_id' AND `id` = '$id' " 
		);
	}

	public static function delete($Component){
		$mysql = MysqlDBC::getInstance();
		
		 $project_id = $mysql->checkVariable($Component->getProject_id());
		 $id = $mysql->checkVariable($Component->getId());
		 $name = $mysql->checkVariable($Component->getName());
		 return $mysql->delete("DELETE FROM `component` WHERE `project_id` = '$project_id' AND `id` = '$id' LIMIT 1"
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
					$where .= "component." . $keys[$i] . " = '" . $filters[$keys[$i]] . "'";
					if ($i < count($keys) - 1) {
						$where .= " AND ";
					}
				}
			}
		}
		$result = MysqlDBC::getInstance()->getResult("SELECT * FROM `component` $where $limit");
		$list = array();
		while ($row = $result->fetch_object()) {
			$Entity = Component::get($row);
			array_push($list, $Entity);
		}
		return $list;
	 }

	// </editor-fold>

	public function toArray() {
		return array(
			'project_id' => $this->getProject_id(),
			'id' => $this->getId(),
			'name' => $this->getName()
		 );
	}
}

?>