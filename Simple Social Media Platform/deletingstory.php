<!--
HTML Validation: X
PHP Validation: X
-->

<?php session_start(); ?> 
<?php 
    require 'database.php';

    $userID = $_SESSION["user_id"];
    $storyID = $_GET["hiddenvalue"]; //important for checking if user can edit story or like their own story
    
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
        <link rel="stylesheet" href="sty.css">
		<title>Deleting</title>
	</head>
<body>
<!-- Delete associated comments -->    
   <?php
$stmt = $mysqli-> prepare("DELETE FROM comments WHERE story_id =?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
} 
$bind = $stmt -> bind_param('i',$storyID);
if(!$bind){
    printf("Bind Failed: %s\n", $mysqli->error);
    exit;
} 

$execute = $stmt->execute();
if(!$execute){
    printf("Execute Failed: %s\n", $mysqli->error);
    exit;
} 

$stmt->close();
?>


<!-- Delete story-->
<?php
$stmt = $mysqli->prepare("DELETE FROM stories WHERE story_id = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
} 
$bind = $stmt->bind_param('i', $storyID);
if(!$bind){
    printf("Bind Failed: %s\n", $mysqli->error);
    exit;
} 

$execute = $stmt->execute();
if(!$execute){
    printf("Execute Failed: %s\n", $mysqli->error);
    exit;
} 

$stmt->close();

header("Location: deletedstory.php");
?>

</body>
</html>