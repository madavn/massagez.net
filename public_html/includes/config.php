<?php
    ob_start();
	session_start();
	ob_clean();
	defined('DB_SERVER')? null : define('DB_SERVER','localhost');
    defined('DB_USER')? null : define('DB_USER','massagez_dt');
    defined('DB_PASS')? null : define('DB_PASS','yri4cuCQeD');
    defined('DB_NAME')? null : define('DB_NAME','massagez_all');
?>