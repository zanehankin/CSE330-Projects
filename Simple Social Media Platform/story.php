<!--
HTML Validation: X
PHP Validation: X
-->

<!-- get story id from hidden field in button that sent me here

Things we need to do: 
Print out content of a story
Print out comments on a story
make it so users can edit and delete their posts
make it so users can edit and delete their comments

-->
<?php
session_start();

require 'database.php';

$storyID = $_GET['hiddenvalue'];
$userID = $_SESSION['user_id']; //important for checking if user can edit story or like their own story
?>

<!-- <?php
$stmt = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param('i',$userID);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()){
    $username = $row['username'];
}
$stmt->close();
?> -->
<!DOCTYPE html>
<html lang = "en">
	<head>
        <link rel="stylesheet" href="sty.css">
		<title>Story Page</title>
	</head>

<body>
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/start.php">
        <input type = "submit" value="Log Out"/>
    </form> 
    <br>
    
<form method = "get" action = "http://ec2-3-92-199-246.compute-1.amazonaws.com/~jordanshonfeld/module3-group-module3-486498-487413/menu.php">
      <input type = "submit" value="Back"/>
</form>   
<br><br>
<!-- print out the contents of the story -->
<?php
    $stmt = $mysqli->prepare("SELECT story_body, user_id, title, link_ext FROM stories WHERE story_id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	} 
    $stmt->bind_param('i', $storyID);
	$stmt->execute();
	$result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        echo("Title: ");
        echo(htmlentities($row['title']));
        echo("<br>");
        echo("Body: ");
        echo(htmlentities($row['story_body']));
        echo("<br>");
        echo("Link: ");
        echo"<a href='".$row['link_ext']."'>";
        echo(htmlentities($row['link_ext']));
        echo("</a>");
        echo("<br>");	
      //  echo(htmlentities($userID) . " | " . htmlentities($row['user_id']));
        if($userID == $row['user_id']){
            echo sprintf("<form method = \"GET\" action = \"deletingstory.php\">\n\t
            <input type = \"hidden\" name = \"hiddenvalue\" value = \"%s\"/>\n\t
            <input type =\"submit\" value = \"Delete Story\" name = \"delete\"/>\n\t
            </form>"

            ,$storyID);
        
       
            echo sprintf("<form method = \"GET\" action = \"editstory.php\">\n\t
            <input type = \"hidden\" name = \"hiddenvalue\" value = \"%s\"/>\n\t
            <input type =\"submit\" value = \"Edit Story\" name = \"delete\"/>\n\t
            </form>"

            ,$storyID);
        } 
    }
?>
<?php
    // $stmt = $mysqli->prepare("SELECT COUNT(*) FROM likes WHERE story_id=?");
    // $stmt->bind_param('i', $storyID);
	// $stmt->execute();
	// $result = $stmt->get_result();
    // echo("Likes: " . htmlentities($result));
    // echo sprintf("<form method = \"GET\" action = \"addlike.php\">\n\t
    // <input type = \"hidden\" name = \"hiddenvalue\" value = \"%s\"/>\n\t
    // <input type =\"submit\" value = \"ADD LIKE\" name = \"like\"/>\n\t
    // </form>"

    // ,$storyID);
?>
<!-- print out the LIKES -->
<!-- needs to have a where storyID = ??? -->
<!--
<?php
    //$stmt = $mysqli->prepare("SELECT comment_id, user_id, body FROM comments WHERE story_id=?");
    // DOES THIS WORK? Trying to get the user's name so we can print "Comment by [user] "
    $stmt = $mysqli->prepare("SELECT comments.comment_id, comments.user_id, comments.body, users.username FROM comments INNER JOIN users ON comments.user_id = users.id");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	} 
   // $stmt->bind_param('i', $storyID); UNCOMMMENT THIS WHEN FIXED
	$stmt->execute();
	$result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        //echo("Comment by ". htmlentities($row['user_id']).": ");
        echo("Comment by ". htmlentities($row['username']).": ");

        echo(htmlentities($row['body']));
        if($row['user_id'] == $userID){ //make a form that sends to edit comment
            echo("<br>");
            echo sprintf("<form method = \"GET\" action = \"editcomment.php\">\n\t
			    <input type = \"hidden\" name = \"hiddenvalue\" value = \"%s\"/>\n\t
			    <input type =\"submit\" value = \"Edit Comment\"/>\n\t
			    </form>"

			
			    ,$row['comment_id']);
                                        //to delete comment
             echo sprintf("<form method = \"GET\" action = \"deleting.php\">\n\t
			    <input type = \"hidden\" name = \"hiddenvalue\" value = \"%s\"/>\n\t
			    <input type =\"submit\" value = \"Delete Comment\" name = \"delete\"/>\n\t
			    </form>"

                ,$row["comment_id"]);
        }
        echo("<br>");
    }
    if ($userID != 10){
    echo("<br>");
    echo sprintf("<form method = \"GET\" action = \"addcomment.php\">\n\t
    <input type = \"hidden\" name = \"hiddenvalue\" value = \"%s\"/>\n\t
    <input type =\"submit\" value = \"Add Comment\"/>\n\t
    </form>"

    ,$storyID);
    }
?>
-->

<?php
    $stmt = $mysqli->prepare("SELECT comment_id, user_id, body FROM comments WHERE story_id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	} 
    $stmt->bind_param('i', $storyID);
	$stmt->execute();
	$result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        echo("Comment: ");
        echo(htmlentities($row['body']));
        if($row['user_id'] == $userID){ //make a form that sends to edit comment
            echo("<br>");
            echo sprintf("<form method = \"GET\" action = \"editcomment.php\">\n\t
			    <input type = \"hidden\" name = \"hiddenvalue\" value = \"%s\"/>\n\t
			    <input type =\"submit\" value = \"Edit Comment\"/>\n\t
			    </form>"

			
			    ,$row['comment_id']);
                                        //to delete comment
             echo sprintf("<form method = \"GET\" action = \"deleting.php\">\n\t
			    <input type = \"hidden\" name = \"hiddenvalue\" value = \"%s\"/>\n\t
			    <input type =\"submit\" value = \"Delete Comment\" name = \"delete\"/>\n\t
			    </form>"

                ,$row["comment_id"]);
        }
        echo("<br>");
    }
    if ($userID != 10){
    echo("<br>");
    echo sprintf("<form method = \"GET\" action = \"addcomment.php\">\n\t
    <input type = \"hidden\" name = \"hiddenvalue\" value = \"%s\"/>\n\t
    <input type =\"submit\" value = \"Add Comment\"/>\n\t
    </form>"

    ,$storyID);
    }

?>

</body>
</html>