<?php
// passChange.php
// Nik Rubenstein -- 3-5-2014

require("../inc/init.php");
$p1 = $_POST['pass1'];


//Passwords must be md5 hashed for security.
$pass = md5($p1);
$thisUser = $uInfo['id'];
$sql = "UPDATE users SET password = '{$pass}' WHERE id = '{$thisUser}'";
$go = mysql_query($sql);
$sql = "UPDATE users SET pass_reset = '0' WHERE id = '{$thisUser}'";
$go = mysql_query($sql);
//echo $pass;


	$_SESSION['message'] = "msg:You have succesfully updated your password.";
	// Now... do they need to chanage their password?

		header("location: {$htmlRoot}");


?>
