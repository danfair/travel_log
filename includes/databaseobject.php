<?php

class DatabaseObject {
	
	protected $id;
	protected $table_name;


	public function find_all() {

		global $database;
		$sql = "SELECT * FROM " . $this->table_name;
		$result = mysqli_query($sql);
		if ($result) {
			return $result;
		}
		else {
			die("Database connection error.");
		}
	}

	public function find_by_id($id) {
		global $database;
		$sql = "SELECT * FROM " . $this->table_name . " ";
		$sql .= "WHERE id=" . $this->id . "LIMIT 1";
		$result = mysqli_query($sql);
		if ($result) {
			$user_row = $database->fetch_array($result);
			return $user_row;
		}
		else {
			die("Database find by id error.");
		}
	}
}

?>