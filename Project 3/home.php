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
		<title>Home Page</title>
	</head>

<body>

	<!-- Login a User -->
	<p>Log In:</p>
	<form method = "POST">
		<label>Username:<input type = "text" name = "user"></label><br><br>
		<label>Password:<input type = "text" name = "pass"></label><br>
		<input type = "submit" value = "Log In"/>
	<br><br><br>

	<!-- Create a New User -->
</form>
	<p>Create New User:</p>
	<form method = "POST">
		<label>Username:<input type = "text" name = "newUser"></label><br><br>
		<label>Password:<input type = "text" name = "newPass"></label><br>
		<input type = "submit" value = "Add"/>
</form>

	<?php
	require 'database.php';
	
	$newUser = $_POST['newUser'];
	$newPass = $_POST['newPass'];
	$pass_hash = password_hash($newPass, PASSWORD_BCRYPT);

	$NUstrlen = strlen($_POST['newUser']);
	$NPstrlen = strlen($_POST['newPass']);

	// Check if exists?

	// CREAT USER
if(isset($newUser, $newPass)){
//  Jordans version (username, password instead of user_name, user_pass)
if (2 < $NUstrlen && $NUstrlen < 10 && 2 < $NPstrlen && $NPstrlen < 20) {
	$stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	

	$stmt->bind_param('ss', $newUser, $pass_hash);
	
	
	$stmt->execute();
	
	$stmt->close();
	echo("You successfully registered! You can now log in to view and comment on new stories.");
}
else{
	echo("Username and Passwords must be between 3-20 characters in length.");
}
}

/* 
THIS IS THE VERSION WITH ZANES TABLE... slightly different variables
	if (2 < $NUstrlen && $NUstrlen < 10 && 2 < $NPstrlen && $NPstrlen < 10) {
		$stmt = $mysqli->prepare("insert into users (user_name, user_pass) values (?, ?)");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		
		$stmt->bind_param('ss', $user, $pass);
		
		$stmt->execute();
		
		$stmt->close();
	}
	else{
		echo("Username and Passwords must be between 2-10 characters in length.");
	}
}
*/


/*
Jordans attempt: check if the user is in the table for LOG IN
*/



//LOGIN
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
		echo("login failed. Try Again or Create a user.");
		exit;
	}
}
	?>

<br><br>
<header> If you would like to continue without registering, click the link below </header>

	
	<?php
$_SESSION['user_id'] = 10;
$viewonlyURL = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php";
echo '<a href="'. $viewonlyURL . '">';
echo "View Only";
echo'</a';

?>

</body>
<html>






<!-- $stmt = $mysqli->prepare("select username, password from users where username = ? AND password = ?"); //issue with this
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('ss',$user,$pass);

$stmt->execute();
echo("here1 ");
$result = $stmt->get_result();
echo("here2");

// echo("before while");
// while ($row = $result_>fetch_assoc()){
// 	echo(htmlentities($row));
// 	echo("in while");
// }
// echo("out of while");

if((strcmp("$result[password]","$pass") == 0) && (strcmp("$result[username]","$user")==0)){
  header("Location: main.php");
  echo("If we got here, something went wrong but also right");
} else {
	echo ("It doesn't look like your user is in the table: you can add the user or continue with view only");
} -->


<!-- 
// $NUstrlen = strlen($_POST['user']);
// $NPstrlen = strlen($_POST['pass']);
// $newUser = mysql_real_escape_string($user);
// $result = mysql_query("SELECT COUNT(*) AS num_rows FROM my_table WHERE username='{$user}' LIMIT 1;");
// $row = mysql_fetch_array($result);
// echo("here");
// echo(htmlentities($row["num_rows"]));
// if($row["num_rows"] > 0){
//   header("Location: main.php");
//   echo("If we got here, something went wrong but also right");
// } else {
// 	echo ("It doesn't look like your user is in the table: you can add the user or continue with view only");
// } -->
</html>