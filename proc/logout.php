<?php
//logout.php (processor)
// Nik Rubenstein -- 11-26-2014
// Log out.
require("../inc/init.php");
$_SESSION['logged'] = FALSE;

    $userDeleteData = $_SESSION['uInfo']['uname'];	
	$sql = "DELETE FROM loggedin_userdata WHERE user ='$userDeleteData' ";
	$result = mysql_query($sql);




session_destroy();
session_start();
$_SESSION['message'] = 'msg:You have logged out. Goodbye!';
header("location:{$htmlRoot}");
?>
