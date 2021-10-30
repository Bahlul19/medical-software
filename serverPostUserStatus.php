<?php

	$SECURE = TRUE;
	require("inc/init.php");
	$userName = $_POST['token'];
	$editModeValue = $_POST['taskStatus'];
	$pageId = $_POST['pageId'];

	$sql = "SELECT user,edit_mode,pageId FROM loggedin_userdata WHERE pageId='$pageId' AND edit_mode='3' AND user!='$userName'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row['edit_mode']!='3' && $row['pageId']!=$pageId && $row['userName']!=$userName && $editModeValue == 1) {
		$sql = " UPDATE loggedin_userdata SET edit_mode ='3', pageId='$pageId' WHERE user='$userName'";
		$result = mysql_query($sql);
	} else if($editModeValue == 0) {
		$sql = " UPDATE loggedin_userdata SET edit_mode ='0', pageId='0' WHERE user='$userName'";
		$result = mysql_query($sql);
	}
	
?>
