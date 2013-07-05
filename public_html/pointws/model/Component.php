<?php 
 class Component {

	 private $id;
	 private $name;
	 private $project_id;

 function __construct($id, $name, $project_id){
		 $this->id=$id;
		 $this->name=$name;
		 $this->project_id=$project_id;
	}
 
	public static function get($object){
		if(property_exists($object, "Component")){
			$object = $object->Component;
		}
		return new Component ($object->id, $object->name, $object->project_id);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

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

	 public function getProject_id() {
		 return $this->project_id;
	 }

	 public function setProject_id($project_id){
		$this->project_id = $project_id;
	}
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Component){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Component->getId());
		 $name = $mysql->checkVariable($Component->getName());
		 $project_id = $mysql->checkVariable($Component->getProject_id());
		return $mysql->insert(
				 " INSERT INTO `component` (`id`,`name`,`project_id`) VALUES ('$id','$name','$project_id')"
		);
	}

	 public static function modify($Component){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Component->getId());
		 $name = $mysql->checkVariable($Component->getName());
		 $project_id = $mysql->checkVariable($Component->getProject_id());
		 return $mysql->update(
				"UPDATE `component` SET`name`='$name',`project_id`='$project_id' WHERE `id` = '$id' " 
		);
	}

	public static function delete($Component){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Component->getId());
		 $name = $mysql->checkVariable($Component->getName());
		 $project_id = $mysql->checkVariable($Component->getProject_id());
		 return $mysql->delete("DELETE FROM `component` WHERE `id` = '$id' LIMIT 1"
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
			'id' => $this->getId(),
			'name' => $this->getName(),
			'project_id' => $this->getProject_id()
		 );
	}
}

?>