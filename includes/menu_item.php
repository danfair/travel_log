<?php

class MenuItem {
	
	private $name;
	private $link;

	public function __construct ($row) {
		$this->name = $row["name"];
		$this->link = $row["link"];
	}

	public function get_name($id=0) {
		return $this->name;
	}

	public function get_link($id=0) {
		return $this->link;
	}

	public static function get_menu_items() {
		global $database;
		$query = "SELECT * FROM menu_items ";
		$query .= "WHERE visible=1 ";
		$query .= "ORDER BY position ASC";
		$result = $database->query($query);
		return $result;
	}
}


?>