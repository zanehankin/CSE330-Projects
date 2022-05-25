<!--
PHP Validation: X
-->

<?php
	$_SESSION['user_id'] = 10;
	$viewonlyURL = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php";
	echo '<a href="'. $viewonlyURL . '">';
	echo "View Only";
	echo'</a';
?>