<!--
HTML Validation: X
PHP Validation: X
-->

<?php session_start(); ?> 
<?php 
    require 'database.php';

    $userID = $_SESSION["user_id"];
    $commentID = $_GET['hiddenvalue']; //important for checking if user can edit story or like their own story
    
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
        <link rel="stylesheet" href="sty.css">
		<title>Deleting</title>
	</head>
<body>
   
<?php
$stmt = $mysqli->prepare("DELETE FROM comments WHERE comment_id = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
} 
$stmt->bind_param('i', $commentID);

$stmt->execute();

$stmt->close();

header("Location: deleted.php");
?>

</body>
</html>