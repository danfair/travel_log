<?php
require_once(LIB_PATH . DS . "database.php");
class Post extends DatabaseObject {
	
	public $title;
	public $author;
	public $content;
	public $category;
	public $date;
	public $author_id;
	public $post_id;
	protected $table_name = "posts";

	public static function get_all_post_info($limit=0, $offset=0) {
		global $database;
		$posts = array();
		$sql = "SELECT * FROM posts ";
		$sql .= "LEFT JOIN users "; 
		$sql .= "ON posts.user_id = users.id ";
		$sql .= "LEFT JOIN photos ";
		$sql .= "ON posts.post_id = photos.post_no ";
		$sql .= "LEFT JOIN categories ";
		$sql .= "ON posts.category_id = categories.category_id ";
		$sql .= "WHERE posts.visible=1 ";
		$sql .= "ORDER BY posts.date DESC ";
		if ($limit != 0) {
			$sql .= "LIMIT " . $limit;
		}		
		if ($offset != 0) {
			$sql .=" OFFSET " . $offset;
		}
		$result = $database->query($sql);
		$result = $database->query($sql);
		while ($row = $database->fetch_array($result)) {
			$post = new Post();
			$post->title = $row["post_title"];
			$post->author = $row["first_name"] . " " . $row["last_name"];
			$post->content = $row["content"];
			$post->category = $row["category_name"];
			$post->date = $row["date"];
			$post->post_id = $row["post_id"];
			$posts[] = $post;
		}
		return $posts;
	}

	public static function get_posts_by_author($user_id) {
		global $database;
		$posts = array();
		$sql = "SELECT * FROM posts ";
		$sql .= "LEFT JOIN users "; 
		$sql .= "ON posts.user_id = users.id ";
		$sql .= "LEFT JOIN categories ";
		$sql .= "ON posts.category_id = categories.category_id ";
		$sql .= "WHERE posts.visible=1 ";
		$sql .= "AND user_id=" . $user_id . " ";
		$sql .= "ORDER BY posts.date DESC ";
		$sql .= "LIMIT 5 ";	
		$result = $database->query($sql);
		while ($row = $database->fetch_array($result)) {
			$post = new Post();
			$post->title = $row["post_title"];
			$post->author = $row["first_name"] . " " . $row["last_name"];
			$post->content = $row["content"];
			$post->category = $row["category_name"];
			$post->date = $row["date"];
			$post->post_id = $row["post_id"];
			$posts[] = $post;
		}

		return $posts;
	}

	public static function get_post_info($post_id) {
		global $database;
		$sql = "SELECT * FROM posts ";
		$sql .= "LEFT JOIN users "; 
		$sql .= "ON posts.user_id = users.id ";
		$sql .= "LEFT JOIN photos ";
		$sql .= "ON posts.post_id = photos.post_no ";
		$sql .= "LEFT JOIN categories ";
		$sql .= "ON posts.category_id = categories.category_id ";
		$sql .= "WHERE posts.post_id=" . $post_id . " ";
		$sql .= "LIMIT 1";
		$result = $database->query($sql);
		$row = $database->fetch_array($result);

		$post = new Post();
		$post->title = $row["post_title"];
		$post->author = $row["first_name"] . " " . $row["last_name"];
		$post->content = $row["content"];
		$post->category = $row["category_name"];
		$post->date = $row["date"];
		$post->author_id = $row["id"];
		$post->post_id = $row["post_id"];
		return $post;
	}

	public function add_post() {
		global $database;
		$sql = "INSERT INTO posts (";
		$sql .= "post_title, user_id, date, category_id, visible, content) ";
		$sql .= "VALUES (";
		$sql .="'" . $this->title . "'," . $this->author_id . ", '" . $this->date . "', '" . $this->category . "', 1, '" . $this->content . "')";
		// visible hard-coded for convenience, since there's no way to edit it later in the CMS
		
		$result = $database->query($sql);
		if ($result) {
			return true;
		}
		else {
			die("Did not add post, database error.");
		}
	}

	public static function get_post_id_by_title($title) {
		global $database;
		$sql = "SELECT * FROM posts ";
		$sql .= "WHERE post_title='" . $title . "' ";
		$sql .= "LIMIT 1";
		$result = $database->query($sql);
		$row = $database->fetch_array($result);
		return $row["post_id"];
	}
}


?>