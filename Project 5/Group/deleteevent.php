
<?php
require 'database.php';

ini_set("session.cookie_httponly", 1);

session_start();
?>

<?php
// login_ajax.php

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$title = htmlentities($json_obj['title']);
$userID = htmlentities($_SESSION['userID']);

$token = htmlentities($json_obj['token']);


if(strcmp($token,$_SESSION['token']) != 0){
	echo json_encode(array(
		"success" => false,
		"message" => "You may be getting hacked, CSRF token did not match"
	));
	exit;
}


$worked = true;
//This is equivalent to what you previously did with $_POST['username'] and $_POST['password']

// Check to see if the username and password are valid. 
$stmt = $mysqli->prepare("DELETE FROM events where user_id = ? and title = ?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
        $worked = false;
		exit;
	}
	$stmt->bind_param('is',$userID, $title); 
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
        $worked = false;
		exit;
	}
	$stmt->execute();
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
        $worked = false;
		exit;
	}
if ($worked){
	echo json_encode(array(
		"success" => true,
        "message" => "deleted " . $title
	));
	exit;
}else{
	echo json_encode(array(
		"success" => false,
		"message" => "Failed to delete " . $title
	));
	exit;
}
?>
<!-- 
<br><br>


    </body>
</html> -->

