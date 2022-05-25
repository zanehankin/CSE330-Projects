<!--
HTML Validation: X
PHP Validation: X
-->

<!-- on the main page print buttons, that send to story.php with hidden field-->
<!-- form with action story.php method = get
	input type = hidden value =$storyID-->
<?php 
	session_start(); 
	if ($_GET['hiddenvalue'] == "10"){
		$_SESSION['user_id'] = 10;
	}
?> 
<!DOCTYPE html>
<html lang = "en">
	<head>
		<link rel="stylesheet" href="sty.css">
		<title>Story Menu</title>
	</head>

<body>
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/start.php">
        <input class = "button" type = "submit" value="Log Out"/>
</form> 

	<br>

<form method = "POST" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/addstory.php">
    <input class = "button" type = "submit" value="Add Story"/>
</form> 

<h1> See the list of stories below or add your own above! </h1>

<p class = "pm">

<?php
	require 'database.php';
	$stmt = $mysqli->prepare("SELECT story_id, user_id, title FROM stories");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	} 
	$stmt->execute();
	$result = $stmt->get_result();
//$stmt->bind_results($stryID, $stryTitle);
	echo "</ul>\n";

	while($row = $result->fetch_assoc()){
		echo sprintf("<form method = \"GET\" action = \"story.php\">\n\t
			<input type = \"hidden\" name = \"hiddenvalue\" value = \"%s\"/>\n\t
			<input type =\"submit\" value = \"%s\"/>\n\t
			</form>"
			
			,$row["story_id"],$row["title"]);
		echo("<br>");	
		// echo(htmlentities("Story ID: ".$row["story_id"]). " | ");
		// echo(htmlentities("Title ".$row["title"]));
}

	$stmt->close();
?>

</p>
 <?php
if(isset($_GET['storyID'])){
	$_SESSION['story_id'] = $_GET['storyID'];
	header("Location: http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/story.php");
}
?> -->

</body>



<!-- <br><br>
<p> Please input the story ID you would like to visit below </p> 
<br><br>
<form method = "GET">
	<label> Story ID <input type = "number" name = "storyID">
	<input type = "submit" value = "GO" />
</form>
<br><br>

		while($row = $result->fetch_assoc()){
//		echo(htmlentities($row["story_id"]).': ');
		$url = $row["story_url"];
//	echo '<img src="' . $url . '">'; GOOD EXAMPLE FOR IMAGE
		echo('<div name = storyTitle>');
		echo '<a href="'.$url . '">';
		echo($row["title"]);
		echo'</a>';
		echo('</div>');
//	echo("<br>");

		echo($row["short_desc"]);
		if($row["link_ext"] != null){
			echo("<br>");
			echo("external link: ");
			echo("<br>");
			$newUrl = $row["link_ext"];
			echo '<a href="'.$newUrl . '">';
			echo($row["link_desc"]);
			echo'</a>';
		}
		echo("<br>");
//		$addcommURL = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/addcomment.php";
//	echo '<a href="'. $addcommURL . '">';
//	echo "add comment";
//	echo'</a>';
		echo sprintf("<form method = \"GET\" action = \"story.php\">\n\t
			<input type = \"hidden\" value = \"%s\"/>\n\t
			<input type =\"submit\" value = \"%s\"/>\n\t
			</form>"
			
			,$row["story_id"],$row["title"]);
			
		printf("<input type = submit=\"addcomment.php?story_id=%f\">Add Comment</a>", $row["story_id"]); 
		$stmt = $mysqli->prepare("SELECT story_id, user_id, body FROM comments WHERE story_id = ?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		} 
		$stmt->bind_param('i',$row["story_id"]);
		$stmt->execute();
		$resultTwo = $stmt->get_result();
		while($rowTwo = $resultTwo->fetch_assoc()){
			echo("<br>");
			echo("Comment from User " .htmlentities($rowTwo["user_id"]). ": ");
			echo(htmlentities($rowTwo["body"]));
		//	echo("<br>");
		}
		echo("<br><br>");
}

	$stmt->close();
?>
-->
</html>
