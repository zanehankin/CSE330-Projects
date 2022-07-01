
<?php
require 'database.php';
?>

<?php

ini_set("session.cookie_httponly", 1);

session_start();
if (!(isset($_SESSION["userID"]))){
  echo json_encode(array(
    "success" => false,
    "user" => false
  ));
  exit;
} else {

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:

$day = htmlentities($json_obj['day']);
$month = htmlentities($json_obj['month']);
$year = htmlentities($json_obj['year']);
$userID = htmlentities($_SESSION["userID"]);

$token = htmlentities($json_obj['token']);

$timearray = array();
$titlearray = array();

if(strcmp($token,$_SESSION['token']) != 0){
	echo json_encode(array(
		"success" => false,
		"message" => "You may be getting hacked, CSRF token did not match"
	));
	exit;
}
//If NONE IS NULL
$stmt = $mysqli->prepare("SELECT timestring, title from events where user_id = ? AND day = ? AND month = ? AND year = ?;");
if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('iiii',$userID, $day, $month, $year); 
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
  $result = $stmt->get_result();

  while($row = $result->fetch_assoc()){
    array_push($timearray,$row['timestring']);
    array_push($titlearray,$row['title']);
  }
//If NONE IS NULL^
//If DAY IS NULL
$stmt = $mysqli->prepare("SELECT timestring, title from events where user_id = ? AND day = 0 AND month = ? AND year = ?;");
if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('iii',$userID, $month, $year); 
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
  $result = $stmt->get_result();

  while($row = $result->fetch_assoc()){
    array_push($timearray,$row['timestring']);
    array_push($titlearray,$row['title']);
  }
//If DAY IS NULL^
//If MONTH IS NULL
$stmt = $mysqli->prepare("SELECT timestring, title from events where user_id = ? AND day = ? AND month = 0 AND year = ?;");
if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('iii',$userID, $day, $year); 
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
  $result = $stmt->get_result();

  while($row = $result->fetch_assoc()){
    array_push($timearray,$row['timestring']);
    array_push($titlearray,$row['title']);
  }
//If MONTH IS NULL^
//If YEAR IS NULL
$stmt = $mysqli->prepare("SELECT timestring, title from events where user_id = ? AND day = ? AND month = ? AND year = 0;");
if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('iii',$userID, $day, $month); 
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
  $result = $stmt->get_result();

  while($row = $result->fetch_assoc()){
    array_push($timearray,$row['timestring']);
    array_push($titlearray,$row['title']);
  }
//If YEAR IS NULL^
  if (sizeof($titlearray)>0){
  echo json_encode(array(
    "success" => true,
    "time" => $timearray,
    "title" => $titlearray
  ));
  exit;
  } else {
    echo json_encode(array(
    "success" => false,
    "user" => true
  ));
    exit;
  }
}
?>