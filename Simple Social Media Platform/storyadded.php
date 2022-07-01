<!--
HTML Validation: X
PHP Validation: X
-->
<?php session_start(); ?> 
<?php 
    require 'database.php';

    $userID = $_SESSION["user_id"];
   
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
        <link rel="stylesheet" href="sty.css">
		<title>Comment Added</title>
	</head>

<body>
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/start.php">
        <input class = "button" type = "submit" value="Start Page"/>
    </form> 
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php">
        <input class = "button" type = "submit" value="Story Menu"/>
    </form>  
	<br>

<h1> Your story was succesfully added.</h1>
</body>
</html>