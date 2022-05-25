<!--
HTML Validation: X
PHP Validation: X
-->

<?php session_start(); ?> 
<!DOCTYPE html>
<html lang = "en">
	<head>
		<link rel="stylesheet" href="sty.css">
		<title>Edit Story</title>
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
    $storyID = $_GET['hiddenvalue']; 
    require 'database.php';
	?>


<!-- Query 1 + 2-->
	<?php

    $stmt = $mysqli->prepare("SELECT story_body, title, link_ext FROM stories WHERE story_id = ?");
    if(!$stmt){
	 	printf("Query Prep Failed: %s\n", $mysqli->error);
	 	exit;
	 } 
     $bind = $stmt->bind_param('i', $storyID);
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
			$body = $row['story_body'];
            $title = $row['title'];
			$link = $row['link_ext'];
            //echo(htmlentities($title));
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
	 echo sprintf("<form method = \"POST\" name = \"storyinfo\">\n\t 
		<label>Title: <textarea name = \"storyTitle\" required>%s</textarea><br>\n\t	
        <label> Content: <textarea name =\"content\" required>%s</textarea><br>\n\t
        <label>External Link: <input type = \"url\" name = \"linkExt\" value =%s><br>\n\t
		<input type =\"submit\" value = \"Replace Story\"/>\n\t
		</form>"
		,$title,$body,$link);
?>

<!-- replace body -->
<?php
//$pdo->query('SET foreign_key_checks = 0');

	$newBody = $_POST['content'];
    $newTitle = $_POST['storyTitle'];
    $newLink = $_POST['linkExt'];

    //echo(htmlentities($newBody). " | " . htmlentities($newTitle) . " | " . htmlentities($newLink) . " | " . htmlentities($storyID) . " | " . htmlentities($userID));
	if(isset($newBody)){
		$stmt = $mysqli->prepare("REPLACE INTO stories (story_id, user_id, story_body, title, link_ext) VALUES (?, ?, ?, ?,?)");
		if(!$stmt){
			printf("Query 2 Prep Failed: %s\n", $mysqli->error);
			exit;
		} 
	//$stmt->bind_param('iiis', $commentID, $userID , $storyIDBind, $newBody);
	$bind = $stmt->bind_param('iisss', $storyID, $userID , $newBody, $newTitle, $newLink);
    if(!$bind){
        printf("Query 2 Prep Failed: %s\n", $mysqli->error);
        exit;
    } 
	$exec = $stmt->execute();
    if(!$exec){
        printf("Query 2 Prep Failed: %s\n", $mysqli->error);
        exit;
    } 
	$stmt->close();

   // $pdo->query('SET foreign_key_checks = 1');
  // header("Location: storyadded.php");
} 	
?>


</body>
</html>

