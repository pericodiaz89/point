<?php 
 class User {

	 private $id;
	 private $username;
	 private $password;
	 private $name;
	 private $email;

 function __construct($id, $username, $password, $name, $email){
		 $this->id=$id;
		 $this->username=$username;
		 $this->password=$password;
		 $this->name=$name;
		 $this->email=$email;
	}
 
	public static function get($object){
		if(property_exists($object, "User")){
			$object = $object->User;
		}
		return new User ($object->id, $object->username, $object->password, $object->name, $object->email);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

	 public function getId() {
		 return $this->id;
	 }

	 public function setId($id){
		$this->id = $id;
	}

	 public function getUsername() {
		 return $this->username;
	 }

	 public function setUsername($username){
		$this->username = $username;
	}

	 public function getPassword() {
		 return $this->password;
	 }

	 public function setPassword($password){
		$this->password = $password;
	}

	 public function getName() {
		 return $this->name;
	 }

	 public function setName($name){
		$this->name = $name;
	}

	 public function getEmail() {
		 return $this->email;
	 }

	 public function setEmail($email){
		$this->email = $email;
	}
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($User){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($User->getId());
		 $username = $mysql->checkVariable($User->getUsername());
		 $password = $mysql->checkVariable($User->getPassword());
		 $name = $mysql->checkVariable($User->getName());
		 $email = $mysql->checkVariable($User->getEmail());
		return $mysql->insert(
				 " INSERT INTO `user` (`id`,`username`,`password`,`name`,`email`) VALUES ($id,$username,$password,$name,$email)"
		);
	}

	 public static function modify($User){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($User->getId());
		 $username = $mysql->checkVariable($User->getUsername());
		 $password = $mysql->checkVariable($User->getPassword());
		 $name = $mysql->checkVariable($User->getName());
		 $email = $mysql->checkVariable($User->getEmail());
		 return $mysql->update(
				"UPDATE `user` SET`username`=$username,`password`=$password,`name`=$name,`email`=$email WHERE `id` = $id " 
		);
	}

	public static function delete($User){
		$mysql = MysqlDBC::getInstance();
		
		 $id = $mysql->checkVariable($User->getId());
		 $username = $mysql->checkVariable($User->getUsername());
		 $password = $mysql->checkVariable($User->getPassword());
		 $name = $mysql->checkVariable($User->getName());
		 $email = $mysql->checkVariable($User->getEmail());
		 return $mysql->delete("DELETE FROM `user` WHERE `id` = $id LIMIT 1"
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
					$where .= "user." . $keys[$i] . " LIKE " . $filters[$keys[$i]];
				} else {
					$where .= "user." . $keys[$i] . " = '" . $filters[$keys[$i]] . "'";
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
		if (isset($orderby)) {
			$ob = " ORDER BY ";
			for ($i = 0; $i < count($orderby); $i++) {
				$ob .= $orderby[$i];
				if ($i < count($orderby) - 1) {
					$ob .= ", ";
				}
			}
		}
		// </editor-fold>
		$result = MysqlDBC::getInstance()->getResult("SELECT * FROM `user` $where $limit $ob");
		$list = array();
		while ($row = $result->fetch_object()) {
			$Entity = User::get($row);
			array_push($list, $Entity);
		}
		return $list;
	 }

	// </editor-fold>

	public function toArray() {
		return array(
			'id' => $this->getId(),
			'username' => $this->getUsername(),
			'password' => $this->getPassword(),
			'name' => $this->getName(),
			'email' => $this->getEmail()
		 );
	}
}

?>