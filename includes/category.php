<?php
require_once(LIB_PATH . DS . "database.php");
class Category extends DatabaseObject {
	
	public $name;
	public $category_id;

	public function __construct($id, $name) {
		$this->category_id = $category_id;
		$this->name = $name;
	}

	public static function get_categories() {
		global $database;
		$categories_array = array();
		$sql = "SELECT * FROM categories ";
		$sql .= "WHERE visible=1";
		$result = $database->query($sql);
		while ($row = $database->fetch_array($result)) {
			$category = new Category($row["category_id"], $row["category_name"]);
			$categories_array[] = $category;
		}
		return $categories_array;
	}

	public static function get_category_id_by_name($name) {
		global $database;
		$sql = "SELECT * FROM categories ";
		$sql .= "WHERE category_name= '" . $name . "' ";
		$sql .= "LIMIT 1";
		$result = $database->query($sql);
		if ($result) {
			$row = $database->fetch_array($result);
			$category_id = $row["category_id"];
		}
		else {
			die("Category database error.");
		}

		return $category_id;
	}
}

?>