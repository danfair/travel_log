<?php
	require_once("../includes/initialize.php");
	include_layout_template("public_header.php");

	if ($session->is_logged_in()) {
		redirect_to("admin.php");
	}

	if (isset($_POST["submit"])) {
		$username = $database->sanitize($_POST["username"]);
		$password = $database->sanitize($_POST["password"]);
		$session->check_login_credentials($username, $password);
	}


?>
<div name="loginarea" class="small-8 small-offset-2 columns">
	<div style="margin:0 auto">
		<h2>Admin login area</h2>
		<?php
			if (!empty($_SESSION["error_message"])) {
				echo "<p style=\"color:red\">" . $_SESSION["error_message"] . "</p>";
				unset($_SESSION["error_message"]);
			}
		?>
			<form action="login.php" method="POST">
			  	<div class="row">
			    	<div class="large-12 columns">
			    		<div class="row">
			    			<input name="username" type="text" placeholder="Username" /><br />
			    		</div>
			      		<div class="row">
			      			<div class="row collapse">
					        	<div class="small-10 columns">
					          		<input name="password" type="password" placeholder="Password" />
					        	</div>
					        	<div class="small-2 columns">
					          		<input type="submit" name="submit" class="alert button postfix" value="Go"></input>
					        	</div>
					    	</div>
			      		</div>
			  		</div>
				</div>
			</form>
	</div>
</div><!-- end of loginarea div-->