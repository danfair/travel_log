<?php

function redirect_to($new_location) 
{
    header("Location: " . $new_location);
    exit;
}

function include_layout_template($template) {
	include(LIB_PATH . DS . "templates" . DS . $template);
}

function __autoload($class_name) {
	$class_name = strtolower($class_name);
	$path = LIB_PATH . DS . "includes" . DS . $class_name . ".php";
	if (file_exists($path)) {
		require_once($path);
	}
	else {
		die("File " . $class_name . ".php was unfound by autoload.");
	}
}

function generate_front_sidebar() {
	global $database;
	$posts_array = Post::get_all_post_info(5);
	foreach ($posts_array as $post) {
		echo "<h4>" . $post->title . "</h4>";
		echo "<h5>" . $post->author . "</h5>";
		echo "<span class=\"label [round-radius]\">" . $post->category . "</span><br />";
		echo "<p>" . substr($post->content, 0, 100) . "...";
		echo "<a href=\"posts.php?post_id=" . $post->post_id . "\">&nbsp;&nbsp;Read more...</a></p>";
	}
}

?>