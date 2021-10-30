<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("../inc/init.php");

$apt = $_POST['aptID'];
$cb = $_POST['canceled_by'];
$cd = $_POST['cancel_date'];
$agree = $_POST['iAgree'];
if (is_numeric($apt)){ // if there is an appointment
	if($cb != '' && $agree == 'ON' && $cd != ''){ // if the rest is kosher
		$cancelString = "Cancelation requested by {$cb} on {$cd} "; 
		$cancelHistory = "::{$cb}-CANCELLATION REQUEST-{$cd}";
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
		
		
		$sql = "UPDATE appointment_requests SET status = '6' WHERE id = '$apt'";
		$go = mysql_query($sql); // it is now status cancel requested
		// email stuff here?
		$_SESSION['message'] = 'msg:Your request has been submitted';
		header("location: {$htmlRoot}/viewAppointments.php");
	} else {
		$_SESSION['message'] = 'err:There was an error processing your request';
		header("location: {$htmlRoot}/appointmentCancel.php?a={$apt}");
	}
} else {
	$_SESSION['message'] = 'err:There was an error processing your request';
		header("location: {$htmlRoot}/appointmentCancel.php?a={$apt}");
}

?>

