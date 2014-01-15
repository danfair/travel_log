<?php
	require_once("../includes/initialize.php");
	require_once("../includes/PHPMailer/class.phpmailer.php");
	require_once("../includes/PHPMailer/class.smtp.php");
	include_layout_template("public_header.php");

	$posts_per_page = 5; 
	$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
	$offset = $page != 1 ? ($page - 1) * $posts_per_page : 0;
	$posts_array = Post::get_all_post_info($posts_per_page, $offset);
	$total_count = count(Post::get_all_post_info());
	$pagination = new Pagination($page, $posts_per_page, $total_count);
?>
<div class="panel small-3 columns">
	<h3>Get email updates</h3> 
		<p>Enter your email address below to get an email everytime this blog is updated.</p> 
		<?php if(isset($_SESSION["email_message"])) {
			echo "<p style=\"color:red\">" . $session->get_email_message() . "</p>";
			unset($_SESSION["email_message"]);
		}
		?>
	<form action="email_signup.php" method="POST">
	  	<div class="row">
	    	<div class="large-12 columns">
	      		<div class="row">
	      			<div class="row collapse">
			        	<div class="small-10 columns">
			          		<input name="email" type="text" placeholder="you@email.com">
			        	</div>
			        	<div class="small-2 columns">
			          		<input type="submit" name="submit" class="alert button postfix" value="Go"></input>
			        	</div>
			    	</div>
	      		</div>
	  		</div>
		</div>
	</form>
	<h3>Recent Posts</h3><br />
	<?php generate_front_sidebar(); ?>
</div><!-- end of panel -->
<div name="postarea" class="small-9 columns" style="padding:0px 20px;">
<?php
	if ($page == 1) {
		echo "<h2>Welcome to TraveLog!</h2>";
	}
	else {
		echo "<ul class=\"button-group right\">";
		if ($pagination->has_previous_page()) {
			echo "<li><a href=\"index.php?page=" . $pagination->previous_page() . "\" class=\"button tiny right\"><< Previous page</a></li>"; 
		}
		if ($pagination->has_next_page()) {
			echo "<li><a href=\"index.php?page=" . $pagination->next_page() . "\" class=\"button tiny right\">Next page >></a></li>"; 
		}
		echo "</ul><br />";
	}

	foreach ($posts_array as $post) {
		$image = Photograph::get_image_by_id($post->post_id);
		echo "<div name=\"rightpost\"><h3>" . $post->title . "</h3>";
		echo "<h5>" . $post->author . "</h5>";
		if (!empty($image->id)) {
			echo "<div name=\"postpic\" style=\"float:left;\"><img src=\"img/" . $image->filename . "\" style=\"width:200; margin-right: 10;\" /></div>";
		}
		echo "<p>" . $post->content . "<p>";
		echo "<span class=\"label [round-radius]\">" . $post->category . "</span>";
		echo "<a href=\"posts.php?post_id=" . $post->post_id . "\" class=\"right\">See post...</a></div><br />";
	}
	// echo "<ul class=\"button-group right\">";
	// if ($pagination->has_previous_page()) {
	// 	echo "<li><a href=\"index.php?page=" . $pagination->previous_page() . "\" class=\"button tiny right\"><< Previous page</a></li>"; 
	// }
	// if ($pagination->has_next_page()) {
	// 	echo "<li><a href=\"index.php?page=" . $pagination->next_page() . "\" class=\"button tiny right\">Next page >></a></li>"; 
	// }
	// echo "</ul><br />";
	$pagination->generate_pagination_footer();
?>
</div><!-- end of postarea div-->
<?php
	include_layout_template("footer.php");
?>