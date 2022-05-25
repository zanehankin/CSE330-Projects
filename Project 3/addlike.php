<!--
HTML Validation: X
PHP Validation: X
-->


<!DOCTYPE html>
<html lang = "en">
	<head>
        <link rel="stylesheet" href="sty.css">
		<title>Menu</title>
	</head>
<body>

<?php session_start();  
    require 'database.php';
  //  $storyID = $GET['hiddenvalue']; 
?>

    <p>This page is still building...</p>
    <form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/start.php">
        <input class = "button" type = "submit" value="Start Page"/>
    </form> 
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php">
        <input class = "button" type = "submit" value="Story Menu"/>
    </form>  
	<br>


</body>
</html>

