<?php
	require_once("../includes/initialize.php");
	include_layout_template("public_header.php");

	if (isset($_GET["post_id"])) {
		$post_id = $database->sanitize($_GET["post_id"]);
		$post = Post::get_post_info($post_id);
		$photo = Photograph::get_image_by_id($post_id);
	}
	else {
		redirect_to("index.php");
	}
?>
<div class="panel small-3 columns">
	<h3>More from <?php echo $post->author; ?></h3> 
		<?php
			$author_posts = Post::get_posts_by_author($post->author_id);
			foreach($author_posts as $item) {
				echo "<h5>" . $item->title . "</h5>";
				echo "<h6>" . $item->author . ",   " . $item->date . "</h6>";
				echo "<a href=\"posts.php?post_id=" . $item->post_id . "\">See post..." . "</a><br /><br />";
			}
		?>
	<br /><br /><h3>Recent Posts</h3><br />
	<?php generate_front_sidebar(); ?>
</div><!-- end of panel -->
<div name="postarea" class="small-9 columns" style="padding:0px 20px;">
<?php 
	echo "<h2>" . $post->title . "</h2>";
	echo "<h4>By " . $post->author . ",  " . $post->date . "</h4>";
	echo "<div style=\"float:left;width:300;padding:10;\"><img src=\"img/" . $photo->filename . "\" /><br /><p style=\"font-style:italic;\">" . $photo->caption . "</p></div>";
	echo "<div><p>" . $post->content . "</p></div>";
?>
</div><!-- end of postarea div-->