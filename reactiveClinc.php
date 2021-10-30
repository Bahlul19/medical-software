<?php
	$SECURE = TRUE;
	require("inc/init.php");
	$clinicId = $_GET['id'];
	$sqlQuery = "UPDATE clinics SET inactive_clinic = '0' WHERE id = {$clinicId}";
	$result = mysql_query($sqlQuery);
	header('Location: inactiveClinics.php');
    exit();
?>
