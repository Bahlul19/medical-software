<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("../inc/init.php");

// $apt = $_POST['aptID'];


$apt = $_GET['id'];
// $cb = $_POST['canceled_by'];
// $cd = $_POST['cancel_date'];
// $agree = $_POST['iAgree'];

if (is_numeric($apt)){ // if there is an appointment

	/*if($cb != '' && $agree == 'ON' && $cd != ''){ // if the rest is kosher
		$cancelString = "Updated requested by {$cb} on {$cd} "; 
		$cancelHistory = "::{$cb}-Replacement REQUEST-{$cd}";
		$sql = "UPDATE appointment_requests SET cancellation = '$cancelString' WHERE id = '$apt'";
		$go = mysql_query($sql); // req in place
		
		//get history
		$sql = "SELECT history FROM appointment_requests WHERE id = '{$apt}'";
		$go = mysql_query($sql);
		$row = mysql_fetch_assoc($go);
		$nowHist = $row['history'];
		$cancelHistoryString = $nowHist . $cancelHistory;
		// update history
		$sql = "UPDATE appointment_requests SET history = '{$cancelHistoryString}' WHERE id = '$apt'";
		$go = mysql_query($sql); // it is now in the history
		*/
		
		$sql = "UPDATE appointment_requests SET status = '8' WHERE id = '$apt'";
		$go = mysql_query($sql); // it is now status cancel requested
		// email stuff here?
		$_SESSION['message'] = 'msg:Your request has been submitted';
		header("location: {$htmlRoot}/viewAppointments.php");
	} else {
		$_SESSION['message'] = 'err:There was an error processing your request';
		header("location: {$htmlRoot}/intAppointments.php?id={$apt}");
	}

	/*
} else {
	$_SESSION['message'] = 'err:There was an error processing your request';
		header("location: {$htmlRoot}/intAppointments.php?a={$apt}");
}
*/
?>

