<!--
HTML Validation: X
PHP Validation: X
-->

<?php session_start(); ?> 
<!DOCTYPE html>
<html lang = "en">
	<head>
		<link rel="stylesheet" href="sty.css">
		<title>Edit Comment</title>
	</head>
<body>
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/start.php">
        <input class = "button" type = "submit" value="Start Page"/>
    </form> 
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php">
        <input class = "button" type = "submit" value="Story Menu"/>
    </form>  
	<br>
<?php 
   // require 'database.php';
	$userID = $_SESSION["user_id"];
    $commentID = $_GET['hiddenvalue']; 
	require 'database.php';
	?>


<!-- Query 1 + 2-->
	<?php

    $stmt = $mysqli->prepare("SELECT body, story_id FROM comments WHERE comment_id = ?");
    if(!$stmt){
	 	printf("Query Prep Failed: %s\n", $mysqli->error);
	 	exit;
	 } 
     $bind = $stmt->bind_param('i', $commentID);
	 if(!$bind){
		printf("Bind Failed: %s\n", $mysqli->error);
		exit;
	} 
	 $execute = $stmt -> execute();
	 if(!$execute){
		printf("Execute Failed: %s\n", $mysqli->error);
		exit;
	} 
	// $bindRes = $stmt->bind_result($comment_body, $storyIDBind);
	// if(!$bindRes){
	// 	printf("Bind Result Failed: %s\n", $mysqli->error);
	// 	exit;
	// } 
	$result = $stmt -> get_result();
	$rowcount = mysqli_num_rows($result);
	if($rowcount > 0){
		while($row = $result->fetch_assoc()){
			// echo(htmlentities($row['body']));
			// echo("<br>");
			// echo(htmlentities($row['story_id']));
			$body = $row['body'];
			$storyID = $row['story_id'];
		}
	} else {
		echo("something went wrong");
		exit;
	}


	// echo(htmlentities($comment_body)); //NOT Printing
	// echo(htmlentities($storyIDBind)); //FOR TOMORROW: THESE ARE COMING UP EMPTY
	$stmt->close();
?>

<!-- FORM -->
<?php
	 echo sprintf("<form method = \"POST\" name = \"comment\">\n\t 
			<label> Content: <textarea name =\"content\" required>%s</textarea><br>\n\t
			<input type =\"submit\" value = \"Replace Comment\"/>\n\t
			</form>"
		,$body);
?>

<?php
	$newBody = $_POST['content'];
//	echo(htmlentities($newBody));
	if(isset($newBody)){
		
		$stmt = $mysqli->prepare("REPLACE INTO comments (comment_id, user_id, story_id, body) VALUES (?, ?, ?, ?)");
		if(!$stmt){
			printf("Query 2 Prep Failed: %s\n", $mysqli->error);
			exit;
		} 
	//$stmt->bind_param('iiis', $commentID, $userID , $storyIDBind, $newBody);
	$stmt->bind_param('iiis', $commentID, $userID , $storyID, $newBody);
	$stmt->execute();
	$stmt->close();


    header("Location: commentadded.php");
} 
		
?>

</body>
</html>