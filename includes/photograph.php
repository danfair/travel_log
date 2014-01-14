<?php

require_once(LIB_PATH . DS . "database.php");
class Photograph extends DatabaseObject {
	
	public $id;
	public $filename;
	public $type;
	public $size;
	public $caption;

	private $temp_path;
	protected $upload_dir = "images";
	public $errors = array();
	
	public function attach_file($file) {

		if (!file || empty($file) || !is_array($file)) {
			$this->errors[] = "No file was uploaded.";
			return false;
		}
		elseif ($file["error"] != 0) {
			$this->errors[] = "There was an error with the upload.";
			return false;
		}
		else {
			$this->temp_path = $file["tmp_name"];
			$this->filename = basename($file["name"]);
			$this->type = $file["type"];
			$this->size = $file["size"];
			return true;
		}

	}

	public function save() {
		if (isset($this->id)) {

		}
	}

	public function image_path() {
		return $this->upload_dir . DS . $this->filename;
	}

	public static function get_image_by_id($post_id) {
		global $database;
		$sql = "SELECT * FROM photos ";
		$sql .= "WHERE post_no=" . $post_id . " ";
		$sql .= "LIMIT 1";
		$result = $database->query($sql);
		$row = $database->fetch_array($result);
		$photo = new Photograph();
		$photo->id = $row["photo_id"];
		$photo->filename = $row["file_path"];
		$photo->caption = $row["caption"];
		return $photo;
	}

}


?>