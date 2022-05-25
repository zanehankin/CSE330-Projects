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
		<title>Create New User</title>
	</head>

<body>
    <!-- Back Button -->
	<form action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/start.php">
		<button type = "submit" class = "b">Back</button>
	</form> 

	<!-- Create New User: -->
	<form method = "POST">
        <br>
        <p>
		<label>Username:<input class = "u" type = "text" name = "newUser"></label><br><br>
        
		<label>Password:<input class = "p" type = "text" name = "newPass"></label><br><br>
		</p>
		<input type = "submit" class = "button" value = "Create New User"/>
        <br><br><br>
    </form>

	<?php
	require 'database.php';
	
	$newUser = $_POST['newUser'];
	$newPass = $_POST['newPass'];
	$pass_hash = password_hash($newPass, PASSWORD_BCRYPT);

	$NUstrlen = strlen($_POST['newUser']);
	$NPstrlen = strlen($_POST['newPass']);

	// CREATE USER
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
	?>

    </body>
</html>