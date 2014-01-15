<?php
require_once(LIB_PATH . DS . "database.php");

class Pagination {
	
	public $current_page;
	public $per_page;
	public $total_count;

	public function __construct($page=1, $per_page=10, $total_count=0) {
		$this->current_page = (int)$page;
		$this->per_page = (int)$per_page;
		$this->total_count = (int)$total_count;
	}

	public function total_pages() {
		return ceil($this->total_count / $this->per_page);
	}

	public function previous_page() {
		return $this->current_page - 1;
	}

	public function next_page() {
		return $this->current_page + 1;
	}

	public function has_previous_page() {
		return $this->previous_page() >= 1 ? true : false;
	}

	public function has_next_page() {
		return $this->next_page() <= $this->total_pages() ? true : false;
	}

	public function generate_pagination_footer() {
		echo "<div class=\"pagination-centered\"><ul class=\"pagination\">";
		echo "<li class=\"arrow\"><a href=\"index.php\">&laquo;</a></li>";
		if ($this->has_previous_page()) {
			$start_point = $this->current_page - 3;
			if ($start_point <= 0) {
				$start_point = 1;
			}
			for ($i = $start_point; $i < $this->current_page; $i++) {
				echo "<li><a href=\"index.php?page=" . $i . "\">" . $i . "</a></li>";
			}
		}

		// if ($this->current_page > 1) {
		// 	for ($i = $this->current_page - 1; $i > 0; $i--) {
		// 	echo "<li><a href=\"index.php?page=" . $i . "\">" . $i . "</a></li>";
		// 	}
		// }
		echo "<li class=\"current\"><a href=\"\">" . $this->current_page . "</a></li>";
		if ($this->total_pages() > $this->current_page) {
			for ($i = $this->current_page + 1; $i <= $this->total_pages() && $i < $this->current_page + 3; $i++) {
				echo "<li><a href=\"index.php?page=" . $i . "\">" . $i . "</a></li>";
			}
		}
		echo "<li class=\"arrow\"><a href=\"index.php?page=" . $this->total_pages() . "\">&raquo;</a></li>";
		echo "</ul></div>";
	}
}


?>