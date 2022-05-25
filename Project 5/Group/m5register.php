
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
$username = $json_obj['username'];
$password = $json_obj['password'];

$hash_pass = password_hash($password, PASSWORD_BCRYPT);

$worked = true;
//This is equivalent to what you previously did with $_POST['username'] and $_POST['password']

// Check to see if the username and password are valid. 
$stmt = $mysqli->prepare("INSERT INTO users (username, password) values (?,?)");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
        $worked = false;
		exit;
	}
	$stmt->bind_param('ss',$username, $hash_pass); 
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
	// session_start();
	// $_SESSION['username'] = $username;
	// $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 
	// setcookie('username',$username);

	echo json_encode(array(
		"success" => true
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

