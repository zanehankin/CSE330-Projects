
<?php

ini_set("session.cookie_httponly", 1);

session_start();
$username = htmlentities($_SESSION['username']);
// if (isset($_SERVER['HTTP_COOKIE'])) {
//     $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
//     foreach($cookies as $cookie) {
//         $parts = explode('=', $cookie);
//         $name = trim($parts[0]);
//         setcookie($name, '', time()-1000);
//         setcookie($name, '', time()-1000, '/');
//     }
// }

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$token = htmlentities($json_obj['token']);

if(strcmp($token,$_SESSION['token']) == 0){
	echo json_encode(array(
		"success" => true,
	    "message" => $username ." is logged out"
));
	session_destroy();
	exit;
} else {
	echo json_encode(array(
		"success" => false,
	    "message" => "Be careful you may be getting hacked"
));
exit;
}


    // unset($_COOKIE['username']); 
    // setcookie('username', null, -1, '/'); 
	// unset($_COOKIE['userID']); 
    // setcookie('userID', null, -1, '/'); 

// if (!(isset($_SESSION['username']))){
//     echo json_encode(array(
// 		"success" => true,
//         "message" => "$username is logged out"
// 	));
//     session_destroy();
// 	exit;
// } else {
//     echo json_encode(array(
// 		"success" => false,
// 		"message" => "You are still logged in"
// 	));
// 	exit;
// }
?>