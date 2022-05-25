<!--
HTML Validation: X
PHP Validation: X
-->
<?php session_start(); ?> 
<?php 
    require 'database.php';
    $storyID = $_GET['hiddenvalue'];
    $userID = $_SESSION["user_id"];
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
        <link rel="stylesheet" href="sty.css">
		<title>Add Comment</title>
	</head>
<body>
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/start.php">
        <input type = "submit" value="Home Page"/>
    </form> 
	<br>
    <form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php">
        <input type = "submit" value="Main Menu"/>
    </form> 

<?php
if ($userID == 10){
  //  echo("Please register at the home page if you would like to make and edit comments!");
    header("Location: viewonly.php");
    exit;
} 
?>


<form method= "POST" name = "comment">
    <label>Content: <textarea name = "content" required> Add Comment Here... </textarea></label><br>
    <input type = "submit" value = "Add Comment" />
</form>


<?php
// echo(htmlentities($_SESSION["user_id"]));
// echo(htmlentities($storyID));
$body = $_POST['content'];

if (isset($body)){

$stmt = $mysqli->prepare("INSERT INTO comments (user_id, story_id, body) VALUES (?, ?, ?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	} 
	$stmt->bind_param('iis', $userID , $storyID, $body);
	$stmt->execute();
	$stmt->close();


    header("Location: http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/commentadded.php",$storyID);
} 
 ?>


</body>
</html>