<?php
	include_once("../includes/initialize.php");
	global $session;
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>TravelLog</title>
		<link rel="stylesheet" type="text/css" href="css/foundation.css" />
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<script src="/js/custom.modernizr.js"></script>
		<script src="/js/vendor/jquery.js"></script>
		<script src="/js/foundation.min.js"></script>
	</head>
	<body style="background-image: url('img/background.jpg')">
		<div name="wrapper" style="margin: 10px auto" class="row">
		<div class="row">
		<img src="img/prague_banner.jpg" class="small-12 columns"/>
		</div><!--end of img row -->
		
<nav class="top-bar" data-topbar> 
	<ul class="title-area"> 
		<li class="name"> 
			<h1><a href="#">TraveLog</a></h1> 
		</li> 
	</ul> 
	<section class="top-bar-section"> <!-- Right Nav Section --> 
		<ul class="left"> 
		<?php 
			$result = MenuItem::get_menu_items();
				while ($row = mysqli_fetch_assoc($result)) {
					$menu_item = new MenuItem($row);
					echo "<li><a href=\"" . $menu_item->get_link() . "\">";
					echo $menu_item->get_name();
					echo "</a></li>";
				}
		if ($session->is_logged_in()) {
			echo "<li><a href=\"admin.php\"><span style=\"color:orange\"><strong>Admin area</strong></span></a></li>";
			echo "<li><a href=\"logout.php\"><span style=\"color:orange\"><strong>Logout</strong></span></a></li>";
		}
		?>
		</ul>
	</section> 
</nav>
<div name="body" class="small-12 columns" style="background-color:white;padding-top:20px;">




