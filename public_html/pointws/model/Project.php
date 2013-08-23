<?php 
 class Project {

	 private $id;
	 private $name;

 function __construct($id, $name){
		 $this->id=$id;
		 $this->name=$name;
	}
 
	public static function get($object){
		if(property_exists($object, "Project")){
			$object = $object->Project;
		}
		return new Project ($object->id, $object->name);
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
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Project){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Project->getId());
		 $name = $mysql->checkVariable($Project->getName());
		return $mysql->insert(
				 " INSERT INTO `project` (`id`,`name`) VALUES ($id,$name)"
		);
	}

	 public static function modify($Project){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Project->getId());
		 $name = $mysql->checkVariable($Project->getName());
		 return $mysql->update(
				"UPDATE `project` SET`name`=$name WHERE `id` = $id " 
		);
	}

	public static function delete($Project){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Project->getId());
		 $name = $mysql->checkVariable($Project->getName());
		 return $mysql->delete("DELETE FROM `project` WHERE `id` = $id LIMIT 1"
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
					$where .= "project." . $keys[$i] . " LIKE '" . $filters[$keys[$i]] . "'";
				} else {
					$where .= "project." . $keys[$i] . " = '" . $filters[$keys[$i]] . "'";
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
		$result = MysqlDBC::getInstance()->getResult("SELECT * FROM `project` $where $ob $limit");
		$list = array();
		while ($row = $result->fetch_object()) {
			$Entity = Project::get($row);
			array_push($list, $Entity);
		}
		return $list;
	 }

	// </editor-fold>

	public function toArray() {
		return array(
			'id' => $this->getId(),
			'name' => $this->getName()
		 );
	}
}

?>