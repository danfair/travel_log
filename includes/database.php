<?php
	
defined("DB_SERVER") ? null : define("DB_SERVER", "localhost");
defined("DB_USER") ? null : define("DB_USER", "travel_log_site");
defined("DB_PASS") ? null : define ("DB_PASS", "pass");
defined("DB_NAME") ? null : define("DB_NAME", "travel_log");

class MySQLDatabase {

	private $connection;

	function __construct() {
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		if (!$this->connection) {
			die("Sorry, there was a database error.");
		}
	}

	function close_connection() {
		if (isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}

	public function query($sql) {
		$result = mysqli_query($this->connection, $sql);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result) {
		if (!$result) {
			die ("Database connection failed.");
		}
	}

	public function fetch_array($result_set) {
		$result = mysqli_fetch_assoc($result_set);
		return $result;
	}

	public function sanitize($value) {
		return mysqli_real_escape_string($this->connection, $value);
	}
}

$database = new MySQLDatabase();

?>