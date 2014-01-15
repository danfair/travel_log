<?php
	
require_once("../includes/initialize.php");

if (isset($_POST["submit"]) && $session->logged_in == true) {
	if (!empty($_POST["title"]) && !empty($_POST["category"]) && !empty($_POST["author"]) && !empty($_POST["postcontent"])) {
		$post = new Post();
		$post->title = $database->sanitize($_POST["title"]);

		$author = $database->sanitize($_POST["author"])
		$post->author_id = User::get_author_id_by_name($author);

		$category_name = $database->sanitize($_POST["category"]);
		$post->category = Category::get_category_id_by_name($category_name);

		$post->date = date("Y-m-d");

		$post->content = $database->sanitize($_POST["postcontent"]);

		$result = $post->add_post();
		if ($result) {
			if (isset($_FILES["file_upload"])) {
				if ($_FILES["file_upload"]["error"] == 0) {
					$tmp_name = $_FILES["file_upload"]["tmp_name"];
					$target_file = basename($_FILES["file_upload"]["name"]);
					$upload_dir = "img";
					$exists = file_exists($upload_dir . $target_file);
					for ($i = 1, $exists == true; $i++) {
						$target_file .= $i;
						$exists = file_exists($upload_dir . $target_file);
					}
					if ($_FILES["file_upload"]["type"] == "image/jpg" || $_FILES["file_upload"]["type"] == "image/png") {
						if (move_uploaded_file($tmp_file, $upload_dir . "/" . $target_file)) {
							$photo = new Photograph();
							$photo->filename = $target_file;
							$photo->post_id = Post::get_post_id_by_title($post->title);
							$photo->type = $_FILES["file_upload"]["type"];
							$photo->add_photo();
							$_SESSION["success_message"] = "Post and "
						}
					}
					else {
						$_SESSION["error_message"] = "Sorry, the file must be PNG or JPG.";
						redirect_to("add_post.php");
					}
				}
				else {
					$_SESSION["error_message"] = "File upload error no. " . $_FILES["file_upload"]["error"];
					redirect_to("add_post.php");
				}
			}
			else {
				$_SESSION["success_message"] = "The post was added successfully.";
				redirect_to("admin.php");
			}
		}
		else {
			$_SESSION["error_message"] = "An error occurred adding the post. Sorry.";
			redirect_to("add_post.php");
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