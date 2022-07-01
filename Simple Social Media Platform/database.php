<!--
PHP Validation: X
-->

<?php
	// Content of database.php

	$mysqli = new mysqli('localhost', 'm3', 'm3', 'mod3');

	if($mysqli->connect_errno) {
		printf("Connection Failed: %s\n", $mysqli->connect_error);
		exit;
	}
	?>