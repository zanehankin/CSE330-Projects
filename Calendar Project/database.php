
<?php
// Content of database.php
$mysqli = new mysqli('localhost', 'm5', 'm5', 'mod5');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>