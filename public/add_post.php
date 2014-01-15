<?php
	require_once("../includes/initialize.php");
	include_layout_template("public_header.php");
?>
<div class="small-8 columns small-offset-2">
<h2>Add a post</h2>
<?php
	if (!empty($_SESSION["error_message"])) {
		echo "<p style=\"color:red\">" . $_SESSION["error_message"] . "</p>";
		unset($_SESSION["error_message"]);
	}
?>
<form action="process_post.php" enctype="multipart/form-data" method="post">
		<div class="row">
			<div class="small-12 columns">
				<label for="title">Title of Post: </label>
				<input type="text" name="title" />
			</div>
		</div>
		<div class="row">
			<div class="small-6 columns">
				<label for="category">Category: </label>
				<select name="category">
					<?php
						$categories_array = Category::get_categories();
						foreach ($categories_array as $category) {
							echo "<option>" . $category->name . "</option>";
						}
					?>
				</select>
			</div>
			<div class="small-6 columns">
				<label for="author">Author: </label>
				<select name="author">
				<?php
					$authors = User::generate_author_list();
					foreach ($authors as $author) {
						echo "<option";
						if ($session->user_id == $author->username) { 
							echo " selected"; 
						}
			 			echo ">" . $author->first_name . "</option>";
					}
				?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<label for="postcontent">Post content: </label>
					<textarea name="postcontent" style="height:400px;"></textarea><br />
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<input type="hidden" name="MAX_FILE_SIZE" value="2,100,000" />
				<label for"file_upload">Add a picture:</label>
				<input type="file" name="file_upload" />
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<input type="submit" class="button right" name="submit" value="Submit Post" />
			</div>
		</div>
	</form>
</div>
