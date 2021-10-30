<?php
	$SECURE = TRUE;
	require("inc/init.php");
	$isId = $_POST['isId'];
	$sql = "SELECT email FROM users WHERE id = '$isId'";
	$go = mysql_query($sql);
	$row = mysql_fetch_array($go);
	$arr = array('isId' =>  $row['email']);
	echo json_encode($arr);
?>
