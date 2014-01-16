<?php
	
require_once("../includes/initialize.php");

if (isset($_POST["submit"]) && $session->logged_in == true) {
	if (!empty($_POST["title"]) && !empty($_POST["category"]) && !empty($_POST["author"]) && !empty($_POST["postcontent"])) {
		$post = new Post();
		$post->title = $database->sanitize($_POST["title"]);

		$author = $database->sanitize($_POST["author"]);
		$post->author_id = User::get_author_id_by_name($author);

		$category_name = $database->sanitize($_POST["category"]);
		$post->category = Category::get_category_id_by_name($category_name);

		$post->date = date("Y-m-d");

		$post->content = $database->sanitize($_POST["postcontent"]);

		if ($_FILES["file_upload"]["error"] != UPLOAD_ERR_NO_FILE) {
			if ($_FILES["file_upload"]["error"] == 0) {
				$tmp_name = $_FILES["file_upload"]["tmp_name"];
				$target_file = basename($_FILES["file_upload"]["name"]);
				$upload_dir = "img";
				if ($_FILES["file_upload"]["type"] == "image/jpg" || $_FILES["file_upload"]["type"] == "image/png" || $_FILES["file_upload"]["type"] == "image/jpeg") {
					if (move_uploaded_file($tmp_name, $upload_dir . "/" . $target_file)) {
						$result = $post->add_post();
						$photo = new Photograph();
						$photo->filename = $target_file;
						$photo->post_id = Post::get_post_id_by_title($post->title);
						$photo->type = $_FILES["file_upload"]["type"];
						$result_photo = $photo->add_photo();
						if ($result && $result_photo) {
							$_SESSION["success_message"] = "Post and photo added successfully.";
							redirect_to("admin.php");
						}
						else {
							$_SESSION["error_message"] = "There was an error adding the picture and post.";
							redirect_to("add_post.php");
						}
					}
				}
				else {
					$_SESSION["error_message"] = "Sorry, the file must be PNG or JPG. Yours: " . $_FILES["file_upload"]["type"];
					redirect_to("add_post.php");
				}
			}
			else {
				$_SESSION["error_message"] = "File upload error no. " . $_FILES["file_upload"]["error"];
				redirect_to("add_post.php");
			}
		}
		else {
			$result = $post->add_post();
			if ($result) {
				$_SESSION["success_message"] = "The post was added successfully.";
				redirect_to("admin.php");
			}
			else {
				$_SESSION["error_message"] = "There was an error adding the post.";
				redirect_to("add_post.php");
			}
		}
	}
	else {
		$_SESSION["error_message"] = "Please enter all required information.";
		redirect_to("add_post.php");
	}
}
else {
	redirect_to("admin.php");
}

?>