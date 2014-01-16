<?php
	require_once("../includes/initialize.php");
	include_layout_template("public_header.php");

	if (!$session->is_logged_in()) {
		$_SESSION["error_message"] = "You must login to view that page.";
		redirect_to("login.php");
	}
	
	$posts_per_page = 10; 
	$page = !empty($_GET["page"]) ? (int)$_GET["page"] : 1;
	$offset = $page != 1 ? ($page - 1) * $posts_per_page : 0;
	$posts_info = Post::get_all_post_info($posts_per_page, $offset);
	$total_count = count(Post::get_all_post_info());
	$pagination = new Pagination($page, $posts_per_page, $total_count);
	
?>
<div name="adminarea" class="small-10 small-offset-1 columns" style="margin-bottom:10;">
<?php
	echo "<div data-alert class=\"alert-box info radius\">";
	echo "Welcome, " . strtoupper($session->user_id);
	echo "</div>";
?>
	<h2>Blog posts</h2>
	<?php
		if (isset($_SESSION["success_message"])) {
			echo "<div data-alert class=\"alert-box success radius\">";
			echo $_SESSION["success_message"];
			echo "</div>";
			unset($_SESSION["success_message"]);
		}
	?>
	<a href="add_post.php" class="button small">+ Add a post</a>
	<table style="width:100%;">
		<thead>
			<tr>
				<th>Title</th>
				<th>Author</th>
				<th>Date</th>
				<th>Edit</th>
				<th>DELETE</th>
			</tr>
		</thead>
	<?php
		foreach($posts_info as $post) {
			echo "<tr>";
			echo "<td>" . $post->title . "</td>";
			echo "<td>" . $post->author . "</td>";
			echo "<td>" . $post->date . "</td>";
			echo "<td><a href=\"edit_post?post_id=" . $post->post_id . "\">Edit</a></td>";
			echo "<td><a href=\"delete_post?post_id=" . $post->post_id . "\">DELETE</a></td>";
			echo "</tr>";
		}
	?>
	</table>
	<?php
		if ($pagination->has_previous_page()) {
			echo "<div class=\"text-left\"><a href=\"admin.php?page=" . $pagination->previous_page() . "\"><< Previous page</a></div>"; 
		}
		if ($pagination->has_next_page()) {
			echo "<div class=\"text-right\"><a href=\"admin.php?page=" . $pagination->next_page() . "\">Next page >></a></div>"; 
		}
	?>
</div>
<?php
	include_layout_template("footer.php");
?>