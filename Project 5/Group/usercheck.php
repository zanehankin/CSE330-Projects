
<?php
ini_set("session.cookie_httponly", 1);
session_start();

if (isset($_SESSION['username'])){
 //   $_SESSION["username"] = $_COOKIE['username'];
    $username = htmlentities($_SESSION['username']);
    $userID = htmlentities($_SESSION["userID"]);
    echo json_encode(array(
		"success" => true,
        "message" => "$username is logged in",
        "name" => "$username"
	));
	exit;
} else {
    echo json_encode(array(
		"success" => false,
		"message" => "You are not logged in"
	));
	exit;
}
?>