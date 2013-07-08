<?php 
 class Componentchild {

	 private $parent;
	 private $child;

 function __construct($parent, $child){
		 $this->parent=$parent;
		 $this->child=$child;
	}
 
	public static function get($object){
		if(property_exists($object, "Componentchild")){
			$object = $object->Componentchild;
		}
		return new Componentchild ($object->parent, $object->child);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

	 public function getParent() {
		 return $this->parent;
	 }

	 public function setParent($parent){
		$this->parent = $parent;
	}

	 public function getChild() {
		 return $this->child;
	 }

	 public function setChild($child){
		$this->child = $child;
	}
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($Componentchild){
		$mysql = MysqlDBC::getInstance();
		
		 $parent = $mysql->checkVariable($Componentchild->getParent());
		 $child = $mysql->checkVariable($Componentchild->getChild());
		return $mysql->insert(
				 " INSERT INTO `componentchild` (`parent`,`child`) VALUES ('$parent','$child')"
		);
	}

	 public static function modify($Componentchild){
		$mysql = MysqlDBC::getInstance();
		
		 $parent = $mysql->checkVariable($Componentchild->getParent());
		 $child = $mysql->checkVariable($Componentchild->getChild());
		 return $mysql->update(
				"UPDATE `componentchild` SET WHERE `parent` = '$parent' AND `child` = '$child' " 
		);
	}

	public static function delete($Componentchild){
		$mysql = MysqlDBC::getInstance();
		
		 $parent = $mysql->checkVariable($Componentchild->getParent());
		 $child = $mysql->checkVariable($Componentchild->getChild());
		 return $mysql->delete("DELETE FROM `componentchild` WHERE `parent` = '$parent' AND `child` = '$child' LIMIT 1"
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
					$where .= "componentchild." . $keys[$i] . " = '" . $filters[$keys[$i]] . "'";
					if ($i < count($keys) - 1) {
						$where .= " AND ";
					}
				}
			}
		}
		$result = MysqlDBC::getInstance()->getResult("SELECT * FROM `componentchild` $where $limit");
		$list = array();
		while ($row = $result->fetch_object()) {
			$Entity = Componentchild::get($row);
			array_push($list, $Entity);
		}
		return $list;
	 }

	// </editor-fold>

	public function toArray() {
		return array(
			'parent' => $this->getParent(),
			'child' => $this->getChild()
		 );
	}
}

?>