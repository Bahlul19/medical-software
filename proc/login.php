<?php
// login.php
// Nik Rubenstein -- 11-26-2014
// Log in processor
require("../inc/init.php");
$uname = $_POST['uname'];
$pass = $_POST['pass'];

//Passwords must be md5 hashed for security.
$pass = md5($pass);

//echo $pass;


//query for user
$sql = "SELECT * FROM users WHERE uname = '$uname'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$thisU = $row['uname'];


//pass reset logic
$passNeeded = $row['pass_reset'];
//echo "Pass needed -- $passNeeded <hr>";
if($passNeeded == '1'){
	$passReset = TRUE;
} else {
	$passReset = FALSE;
}

// if not user name try email
if($thisU == ''){
	$sql = "SELECT * FROM users WHERE email = '$uname'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	$thisU = $row['email'];
}

//no such user
if ($thisU == ''){
	$_SESSION['message'] = 'err:Sorry, there was an error with your log in. Please try again.';
	header("location:{$htmlRoot}");
}

// okay we have a user so check password
$thisP = $row['password'];

// password incorrect
if($pass != $thisP){
	$_SESSION['message'] = 'err:Sorry, there was an error with your log in. Please try again.';
	header("location:{$htmlRoot}");
}

//Everything is groovy we think, but lets tripple check
if($thisU && $thisP == $pass){

	
	$_SESSION['logged'] = TRUE;
	$_SESSION['uInfo'] = $row;
	$_SESSION['message'] = "msg:Successfully Logged in as {$uname} ( {$row['name_f']} {$row['name_l']} )";

	loggedInTrack($thisU);
	// Now... do they need to chnage their password?
	if($passReset){
		header("location: {$htmlRoot}/passChange.php");
		//echo "p needed";
	} else {
		//echo "not needed";
		header("location: {$htmlRoot}");
	}
}

function loggedInTrack($thisU){

	$sql ="SELECT user FROM loggedin_userdata WHERE user='$thisU'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

		if(isset($row['user'])){
		
		
		}else{

			$currentTimestamp = date("Y-m-d h:i:s");
			$currentUser = $_SESSION['uInfo']['uname'];
			$currentUserRole = $_SESSION['uInfo']['role'];
			$sql = "INSERT INTO loggedin_userdata(user,date_time_stamp,edit_mode,admin_role) VALUES ('$currentUser','$currentTimestamp', '0','$currentUserRole')";
			$result = mysql_query($sql);

		
	}
}
?>
