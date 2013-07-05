<?php 
 class User {

	 private $email;
	 private $username;
	 private $id;
	 private $name;
	 private $password;

 function __construct($email, $username, $id, $name, $password){
		 $this->email=$email;
		 $this->username=$username;
		 $this->id=$id;
		 $this->name=$name;
		 $this->password=$password;
	}
 
	public static function get($object){
		if(property_exists($object, "User")){
			$object = $object->User;
		}
		return new User ($object->email, $object->username, $object->id, $object->name, $object->password);
	}

	// <editor-fold defaultstate="collapsed" desc="Get and Set">

	 public function getEmail() {
		 return $this->email;
	 }

	 public function setEmail($email){
		$this->email = $email;
	}

	 public function getUsername() {
		 return $this->username;
	 }

	 public function setUsername($username){
		$this->username = $username;
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

	 public function getPassword() {
		 return $this->password;
	 }

	 public function setPassword($password){
		$this->password = $password;
	}
	// </editor-fold>

 // <editor-fold defaultstate="collapsed" desc="CRUD">

	 public static function create($User){
		$mysql = MysqlDBC::getInstance();
		
		 $email = $mysql->checkVariable($User->getEmail());
		 $username = $mysql->checkVariable($User->getUsername());
		 $id = $mysql->checkVariable($User->getId());
		 $name = $mysql->checkVariable($User->getName());
		 $password = $mysql->checkVariable($User->getPassword());
		return $mysql->insert(
				 " INSERT INTO `user` (`email`,`username`,`id`,`name`,`password`) VALUES ('$email','$username','$id','$name','$password')"
		);
	}

	 public static function modify($User){
		$mysql = MysqlDBC::getInstance();
		
		 $email = $mysql->checkVariable($User->getEmail());
		 $username = $mysql->checkVariable($User->getUsername());
		 $id = $mysql->checkVariable($User->getId());
		 $name = $mysql->checkVariable($User->getName());
		 $password = $mysql->checkVariable($User->getPassword());
		 return $mysql->update(
				"UPDATE `user` SET`email`='$email',`username`='$username',`name`='$name',`password`='$password' WHERE `id` = '$id' " 
		);
	}

	public static function delete($User){
		$mysql = MysqlDBC::getInstance();
		
		 $email = $mysql->checkVariable($User->getEmail());
		 $username = $mysql->checkVariable($User->getUsername());
		 $id = $mysql->checkVariable($User->getId());
		 $name = $mysql->checkVariable($User->getName());
		 $password = $mysql->checkVariable($User->getPassword());
		 return $mysql->delete("DELETE FROM `user` WHERE `id` = '$id' LIMIT 1"
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
					$where .= "user." . $keys[$i] . " = '" . $filters[$keys[$i]] . "'";
					if ($i < count($keys) - 1) {
						$where .= " AND ";
					}
				}
			}
		}
		$result = MysqlDBC::getInstance()->getResult("SELECT * FROM `user` $where $limit");
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
			'email' => $this->getEmail(),
			'username' => $this->getUsername(),
			'id' => $this->getId(),
			'name' => $this->getName(),
			'password' => $this->getPassword()
		 );
	}
}

?>