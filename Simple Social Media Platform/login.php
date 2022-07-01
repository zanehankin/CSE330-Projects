<!--
HTML Validation: X
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

<?php 

	session_start(); 
?> 

<!DOCTYPE html>
<html lang = "en">
	<head>
		<link rel="stylesheet" href="sty.css">
		<title>Login</title>
	</head>

<body>
	<!-- Back Button -->
	<form action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/start.php">
		<button type = "submit" class = "b">Back</button>
	</form> 

	<!-- Login a User -->
	<!--<p>Log In:</p>-->
	<form method = "POST">
	<br>
	<p>
		<label>Username:<input class = "u" type = "text" name = "user"><br><br></label>
		<label>Password:<input class = "p" type = "text" name = "pass"><br><br></label>
	</p>
		<input type = "submit" class = "button" value = "Login"/>
	<br><br><br>
</form>

	<?php

// LOGIN
 if (isset($_POST['user'], $_POST['pass'])){
	$stmt = $mysqli->prepare("SELECT COUNT(*), id, password FROM users WHERE username=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$userVar = $_POST['user'];
	$stmt->bind_param('s',$userVar); 
	$stmt->execute();
	$stmt->bind_result($cnt, $userID, $pwd_hash);
	$stmt->fetch();


	$pwd_guess = $_POST['pass'];
	// echo($pwd_hash . " ");
	// echo($cnt . " ");
	if($cnt ==1 && password_verify($pwd_guess,$pwd_hash)){
		// success
		$_SESSION["user_id"] = $userID;
		//echo((htmlentities($_SESSION["user_id"])));
		header("Location: http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php");
		exit;
	} else {
		echo("Login failed! Try Again or Create a user.");
		exit;
	}
}
	?>

<br><br>

<!--
<header> If you would like to continue without registering, click the link below </header>
	<?php
/*
$_SESSION['user_id'] = 10;
$viewonlyURL = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/main.php";
echo '<a href="'. $viewonlyURL . '">';
echo "View Only";
echo'</a';
*/
    ?>
-->

    </body>
</html>