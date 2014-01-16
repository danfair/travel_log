<?php

class User extends DatabaseObject{

	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $id;

	public function __construct() {
		$this->table_name = "users";
	}

	public function instantiate($user_row) {
		$user = new self;
		$user->id = $user_row["id"];
		$user->username = $user_row["username"];
		$user->password = $user_row["password"];
		$user->first_name = $user_row["first_name"];
		$user->last_name = $user_row["last_name"];
		return $user;
	}

	public static function generate_author_list() {
		global $database;
		$array = array();
		$sql = "SELECT * FROM users";
		$result = $database->query($sql);
		while ($row = $database->fetch_array($result)) {
			$user = new User();
			$user->id = $row["id"];
			$user->username = $row["username"];
			$user->first_name = $row["first_name"];
			$user->last_name = $row["last_name"];
			$array[] = $user;
		}
		return $array;
	}

	public static function get_author_id_by_name($name) {
		global $database;
		$sql = "SELECT * FROM users ";
		$sql .= "WHERE first_name= '" . $name . "' ";
		$sql .= "LIMIT 1";
		$result = $database->query($sql);
		if ($result) {
			$row = $database->fetch_array($result);
			$user_id = $row["id"];
		}
		else {
			die("Author/user database error.");
		}

		return $user_id;
	}
}

?>