<!--
HTML Validation: X
PHP Validation: X
-->

<?php session_start(); ?> 
<?php 
    require 'database.php';
    $_SESSION["story_id"] = $_GET['story_id'];
    $storyID = $_SESSION["story_id"];
    $userID = $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<title>Deleted</title>
	</head>
    <link rel="stylesheet" href="sty.css">
<body>
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/start.php">
        <input class = "button" type = "submit" value="Start Page"/>
    </form> 
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php">
        <input class = "button" type = "submit" value="Story Menu"/>
    </form>  
	<br>    

<h1> Your comment was successfully deleted.</h1>
</body>
</html>