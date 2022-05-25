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
		<title>Menu</title>
	</head>
<body>
    <br>
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/start.php">
        <input type = "submit" value="Home Page"/>
    </form> 
  
 <form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php">
      <input type = "submit" value="Back"/>
</form>    
  <!-- check if view only -->
  <?php
if ($userID == 10){
  //  echo("Please register at the home page if you would like to make and edit comments!");
    header("Location: viewonly.php");
    exit;
} 
?>
<br><br>
<form method= "POST" name = "storyinfo">
    <label>Title: <input type = "text" name = "storyTitle" required></label><br>
    <label>Content: <textarea name = "content" required> Enter Content Here... </textarea></label><br>
    <label>External Link: <input type = "url" name = "linkExt"></label><br>
    <input type = "submit" value = "Add Story" />
</form>



<!-- add to database -->
<?php
$stmt = $mysqli->prepare("INSERT INTO stories (user_id, link_ext, story_body, title) VALUES (?, ?, ?,?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	} 
	$stmt->bind_param('isss', $userID, $_POST['linkExt'], $_POST['content'], $_POST['storyTitle']);
	$stmt->execute();
	$stmt->close();
    if(isset($_POST['content'])){
    header("Location: storyadded.php");
    }
    ?>

</body>
</html>