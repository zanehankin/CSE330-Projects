<!--
HTML Validation: X
PHP Validation: X
-->
<?php 
	session_destroy();
	session_start(); 
?> 

<!DOCTYPE html>
<html lang = "en">
	<head>
		<link rel="stylesheet" href="sty.css">
		<title>Start</title>
	</head>


	<body>

	<!-- Log In Button Real Link: http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/login.php -->
	<!-- Test Link: http://ec2-54-151-98-104.us-west-1.compute.amazonaws.com/~zane/module3-group-module3-486498-487413/login.php -->
	<form action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/login.php">
		<button type = "submit" class = "LI">Login</button>
	</form> 
	<!-- Create User Button -->
	<form action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/createuser.php">
		<button type = "submit" class = "NU">Create a User</button>
	</form> 

	<!-- Use Guest User Button -->
	
	<form action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php">
		<input type = "hidden" name = "hiddenvalue" value = "10" />
		<button type = "submit" class = "GU">Guest User</button>
	</form>
	
<br><br>

<!--
	<header> If you would like to 
	continue without registering, 
	click the link below </header>

	Old Version of Viewing as Guest User Button
-->
<!--
	<?php
	$guestID = "true";
	echo sprintf ("<form action = \"http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php\">\n\t
		<input type = \"hidden\" name = \"hiddenvalue\" value = \"%s\"/> \n\t
		<button type = \"submit\" class = \"GU\"> Guest User </button>\n\t
		</form>"
		,$guestID)
	?>
	-->

	</body>
</html>