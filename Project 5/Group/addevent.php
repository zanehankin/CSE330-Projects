
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
$time = htmlentities($json_obj['time']);
$userID = htmlentities($_SESSION['userID']);
$day = htmlentities($json_obj['day']);
$month = htmlentities($json_obj['month']);
$year = htmlentities($json_obj['year']);
$token = htmlentities($json_obj['token']);


if(strcmp($token,$_SESSION['token']) != 0){
	echo json_encode(array(
		"success" => false,
		"message" => "You may be getting hacked, CSRF token did not match"
	));
	exit;
}

//This is equivalent to what you previously did with $_POST['username'] and $_POST['password']

$worked = true;
// Check to see if the username and password are valid. 
$stmt = $mysqli->prepare("INSERT INTO events (user_id, day, month, year, timestring, title) values (?,?,?,?,?,?)");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
        $worked = false;
		exit;
	}
	$stmt->bind_param('iiiiss',$userID, $day, $month, $year, $time, $title); 
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
		"message" => "event added to calendar"
	));
	exit;
}else{
	echo json_encode(array(
		"success" => false,
		"message" => "Failed to register"
	));
	exit;
}
?>

<br><br>


    </body>
</html>

