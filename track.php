<?php
require_once 'config.php';
if (TRACK_ACCESSES !== True) {
	return;
}
require_once 'mysql.php';
global $mysqli;
$user_agent = $mysqli->real_escape_string($_SERVER['HTTP_USER_AGENT']);
$mysqli->query("INSERT INTO accesses VALUES ('{$_SERVER['REMOTE_ADDR']}', NOW(), '$user_agent')");

?>