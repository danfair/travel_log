<?php

defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
//defined("SITE_ROOT") ? null : define ("SITE_ROOT", DS . "xampp" . DS . "htdocs" . DS . "travel_log"); // Windows
defined("SITE_ROOT") ? null : define ("SITE_ROOT", DS . "xampp" . DS . "htdocs" . DS . "travel_log");  // MAC
defined("LIB_PATH") ? null : define("LIB_PATH", SITE_ROOT . DS . "includes");

require_once(LIB_PATH . DS . "database.php");
require_once(LIB_PATH . DS . "functions.php");
require_once(LIB_PATH . DS . "session.php");
require_once(LIB_PATH . DS . "menu_item.php");
require_once(LIB_PATH . DS . "databaseobject.php");
require_once(LIB_PATH . DS . "user.php");
require_once(LIB_PATH . DS . "post.php");
require_once(LIB_PATH . DS . "photograph.php");
require_once(LIB_PATH . DS . "pagination.php");
require_once(LIB_PATH . DS . "category.php");

?>