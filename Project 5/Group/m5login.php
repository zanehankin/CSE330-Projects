
<?php
require 'database.php';
?>



<?php
// login_ajax.php

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$username = htmlentities($json_obj['username']);
$password = htmlentities($json_obj['password']);
//This is equivalent to what you previously did with $_POST['username'] and $_POST['password']

// Check to see if the username and password are valid via MYSQL
$stmt = $mysqli->prepare("SELECT COUNT(*), user_id, password FROM users WHERE username=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s',$username); 
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_result($cnt, $userID, $pwd_hash);
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->fetch();
    if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	//echo(password_verify($password,$pwd_hash));
	// echo($pwd_hash . " ");
	// echo($cnt . " ");
	if($cnt ==1 && password_verify($password,$pwd_hash)){
        $inTable = true; //maybe True?

	} else {
		$inTable = false;
	}

// send back to javascript
if( $inTable ){
	ini_set("session.cookie_httponly", 1);
	session_start();
	$_SESSION['username'] = htmlentities($username);
	$_SESSION['token'] = bin2hex(random_bytes(32));
	$_SESSION['userID'] = htmlentities($userID);
	// setcookie('username',$username);
	// setcookie('userID',$userID);

	// if (isset($_COOKIE["username"]))
    // {
    //     echo "username is  " . $_COOKIE["username"];
    // }
    // else
    // {
    //     echo "No items for auction.";
    // }

	echo json_encode(array(
		"success" => true,
		"token" => $_SESSION['token']
	));
	exit;
}else{
	echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
}
?>

<br><br>


    </body>
</html>

