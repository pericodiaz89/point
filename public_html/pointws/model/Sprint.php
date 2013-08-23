<?php 
 class Sprint {

	 private $id;
	 private $name;
	 private $date;
	 private $description;
	 private $project_id;

 function __construct($id, $name, $date, $description, $project_id){
		 $this->id=$id;
		 $this->name=$name;
		 $this->date=$date;
		 $this->description=$description;
		 $this->project_id=$project_id;
	}
 
	public static function get($object){
		if(property_exists($object, "Sprint")){
			$object = $object->Sprint;
		}
		return new Sprint ($object->id, $object->name, $object->date, $object->description, $object->project_id);
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
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Sprint){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Sprint->getId());
		 $name = $mysql->checkVariable($Sprint->getName());
		 $date = $mysql->checkVariable($Sprint->getDate());
		 $description = $mysql->checkVariable($Sprint->getDescription());
		 $project_id = $mysql->checkVariable($Sprint->getProject_id());
		return $mysql->insert(
				 " INSERT INTO `sprint` (`id`,`name`,`date`,`description`,`project_id`) VALUES ($id,$name,$date,$description,$project_id)"
		);
	}

	 public static function modify($Sprint){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Sprint->getId());
		 $name = $mysql->checkVariable($Sprint->getName());
		 $date = $mysql->checkVariable($Sprint->getDate());
		 $description = $mysql->checkVariable($Sprint->getDescription());
		 $project_id = $mysql->checkVariable($Sprint->getProject_id());
		 return $mysql->update(
				"UPDATE `sprint` SET`name`=$name,`date`=$date,`description`=$description WHERE `id` = $id AND `project_id` = $project_id " 
		);
	}

	public static function delete($Sprint){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($Sprint->getId());
		 $name = $mysql->checkVariable($Sprint->getName());
		 $date = $mysql->checkVariable($Sprint->getDate());
		 $description = $mysql->checkVariable($Sprint->getDescription());
		 $project_id = $mysql->checkVariable($Sprint->getProject_id());
		 return $mysql->delete("DELETE FROM `sprint` WHERE `id` = $id AND `project_id` = $project_id LIMIT 1"
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
					$where .= "sprint." . $keys[$i] . " LIKE '" . $filters[$keys[$i]] . "'";
				} else {
					$where .= "sprint." . $keys[$i] . " = '" . $filters[$keys[$i]] . "'";
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
		$result = MysqlDBC::getInstance()->getResult("SELECT * FROM `sprint` $where $ob $limit");
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
			'id' => $this->getId(),
			'name' => $this->getName(),
			'date' => $this->getDate(),
			'description' => $this->getDescription(),
			'project_id' => $this->getProject_id()
		 );
	}
}

?>