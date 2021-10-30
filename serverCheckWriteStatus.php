<?php

	$SECURE = TRUE;
	require("inc/init.php");
	$pageId = $_POST['isPage'];
	$loggedUser = $_SESSION['uInfo']['uname'];
	$sql = "SELECT user,edit_mode,pageId  FROM loggedin_userdata WHERE pageId='$pageId' AND user!='$loggedUser'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$arr = array('edit_mode' => $row['edit_mode'], 'pageId' =>  $row['pageId'], 'user' => $row['user']);
	echo json_encode($arr);


 ?>
