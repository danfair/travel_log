<?php

class Session {

	public $logged_in;
	public $user_id;
	private $email_message;

	function __construct() {
		session_start();
		$this->check_login();
	}

	public function is_logged_in() {
		return $this->logged_in;
	}

	public function check_login() {
		if (isset($_SESSION["user_id"])) {
			$this->user_id = $_SESSION["user_id"];
			$this->logged_in = true;
		}
		else {
			unset($this->user_id);
			$this->logged_in = false;
		}
	}

	public function login($user_id) {
		$_SESSION["user_id"] = $user_id;
		$this->user_id = $user_id;
		$this->logged_in = true;
	}

	public function logout() {
		unset($this->user_id);
		unset($_SESSION["user_id"]);
		$this->logged_in = false;
	}

	public function get_email_message() {
		return $_SESSION["email_message"];
	}

	public function set_email_message($message) {
		$_SESSION["email_message"] = $message;
	}

	public function check_login_credentials($username, $password) {
		global $database;
		$sql = "SELECT * FROM users ";
		$sql .= "WHERE username='" . $username . "' ";
		$sql .= "LIMIT 1";
		$result = $database->query($sql);
		$user_row = $database->fetch_array($result);
		if (!$result) {
			$_SESSION["error_message"] = "Sorry, username/password not correct.";
			redirect_to("login.php");
		}
		else {
			if ($user_row["password"] == $password) {
				$this->login($username);
				$file = "../logs/user_logins.txt";
				$content = $username . ", " . date("Y-m-d h:i:s A e") . "\r\n";
				if ($handle = fopen($file, 'a')) {
					fwrite($handle, $content);
					fclose($handle);
				}
				redirect_to("admin.php");
			}
			else {
				$_SESSION["error_message"] = "Sorry, username or password are not found.";
				redirect_to("login.php");
			}
		}
	}
}

$session = new Session();

?>