<?php
$SECURE = TRUE;
require_once("../inc/init.php");
// new appointment processor
// nik Rubenstein 12-01-2014




$blame = $uInfo['id'];
$nowStat = $_POST['status'];
$statusFUD = $_POST['status'];
$rightNow = date("m/d/y H:i");


//////////////////////////////////////////////////////////
$intConf= $_POST['interpreter_confirmed'];
//$intConf = explode('(',$intConf);
//$intConf = $intConf[1];
//$intConf = str_replace(')','',$intConf);
/////////////////////////////////////////////////////////
//print_r($_POST);
$update = $_POST;

if($update['status'] == 'other'){
	$update['status'] = '1';
}
$sendEmail = $update['sendEmail'];

$emailToOnce = $update['emailToOnce'];


$emailTo = $update['emailTo'];





/*
print_r($update);
hr();
echo $sendEmail;
br();
echo $emailTo;
*/
unset($update['emailTo']);

unset($update['emailToOnce']);

unset($update['sendEmail']);


if($update['submit'] == 'DELETE THIS APPOINTMENT'){
	$DELETETHIS = true;

} elseif ($update['submit'] == 'REQUEST CANCELLATION'){
	$CANCELREQTHIS = true;
} else {
	$UPDATETHIS = true;
}




$update['interpreter_confirmed'] = $intConf;
// make unix stamp from date/time
$aptDate = $_POST['aptDate'];
$aptTime = "{$_POST['aptHour']}:{$_POST['aptMin']} {$_POST['aptAmPm']}";
$aptUnix = $ApptUnix = strtotime("$aptDate $aptTime");

$update['apt_date'] = $aptUnix;

// $update['provider_name'] = $provider_name;

$thisID = $update['aptID'];


//get some current data
$sql = "SELECT history,status,confirmed_by, interpreter_twilio_link, requested_by FROM appointment_requests WHERE id = '{$thisID}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
//$nowHist = $row['history'];
$nowHist = htmlspecialchars($row['history'], ENT_QUOTES);

//print_r($nowHist);
$nowStat = $row['status'];
$confBy = $row['confirmed_by'];
$interpreter_twilio_link = $row['interpreter_twilio_link'];
$requested_by = $row['requested_by'];

$sql = "SELECT title FROM appointment_status WHERE id = '{$update['status']}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$theStatus = $row['title'];


//get interpreterName
$interpreterName = $_POST['interpreter_confirmed'];
$sql2 = "SELECT name_f,name_l, phone_1 FROM users where id = '{$interpreterName}' ";
$go = mysql_query($sql2);
$row = mysql_fetch_assoc($go);
$interpreterFullName = $row['name_f'] . " " . $row['name_l'];
$interpreterPhone = $row['phone_1'];

$sql = "SELECT name_f,name_l FROM users WHERE id = '{$blame}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$theBlame = $row['name_f'] . " " . $row['name_l'];



$sql = "SELECT name_f,name_l, phone FROM patients WHERE id = '{$update['patient']}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$MailToName = $row['name_f']. " " . $row['name_l'];
$patientPhone = $row['phone'];

$cln = dataGet("*","clinics","id",$_POST['clinic']);
$clinicName = $cln[0];

$clinicName = $clinicName['title'];
$clinicAddress = $cln[0];
$clinicAddress = $clinicAddress['addr_1']." ".$clinicAddress['addr_2'];
//create or append history.
// $newHist = "{$theBlame}-{$theStatus}-{$rightNow}-{$clinicName}<br><b>Address </b> : {$clinicAddress} <hr>";

$newHist = "{$theBlame}-{$theStatus}-{$rightNow}";
$nextHist = "{$nowHist}::{$newHist}";
$update['history'] = $nextHist;
$update['locked'] = 0; // unlock


if($update['status'] == 3){ // status is confirmed
	if($confBy == 0 || $confBy == ''){ // if it is not already confirmed
		$update['confirmed_by'] = $blame;
	}


}


if($theStatus == 'CONFIRMED'){
		$subject = "Appointment {$thisID} has been confirmed.";
		$statusMessageForClinic = "This email is to confirm your Itasca online Interpreter request for appointment date {$aptDate} {$aptTime} for Patient {$MailToName} {$interpreterFullName} is confirmed. Please contact Itasca for any changes to the appointment at 651-457-7400. This is an automatically generated email, please do not reply to this address. Thank you for using Itasca Interpretation Services.";
		//$statusMessageForInterpreter = "This is for testing for Interpreter User.";
	//	$sendEmail = TRUE;

		$statusMessageForInterpreter = "This email is to remind you that you have confirmed an appointment {$aptDate} for {$MailToName} at {$clinicName}.If you feel this is an error please contact Itasca at 651-457-7400 immediately to prevent any fee charges to you.";

	} elseif ($theStatus == 'DENIED'){
		$subject = "Sorry, Itasca is unable to provide an interpreter for your Appointment {$thisID}.";
		$statusMessageForClinic = "This email is to confirm that Itasca is unable to provide an interpreter for your online request appointment date {$aptDate} {$aptTime} for Patient {$MailToName}. Please contact Itasca at 651-457-7400 if you should have any questions. This is an automatically generated email, please do not reply to this address. Thank you for using Itasca Interpretation Services.";
		//$statusMessageForInterpreter = "This is for testing for Interpreter User.";
	//	$sendEmail = TRUE;
		$statusMessageForInterpreter = "This email is to remind you that you have confirmed an appointment {$aptDate} for {$MailToName} at {$clinicName}.If you feel this is an error please contact Itasca at 651-457-7400 immediately to prevent any fee charges to you.";

	} elseif ($theStatus == 'CANCELLED'){
		$subject = "Appointment {$thisID} has been cancelled.";
		$statusMessageForClinic = "This email is to confirm that Itasca have received a cancellation request from your facility for appointment date {$aptDate}{$aptTime} for Patient {$MailToName}. If you feel that this is an error please contact Itasca at 651-457-7400. This is an automatically generated email, please do not reply to this address. Thank you for using Itasca Interpretation Services.";
		//$statusMessageForInterpreter = "This is for testing for Interpreter User.";
	//	$sendEmail = TRUE;

		$statusMessageForInterpreter = "This email is to remind you that you have confirmed an appointment {$aptDate} for {$MailToName} at {$clinicName}.If you feel this is an error please contact Itasca at 651-457-7400 immediately to prevent any fee charges to you.";
	}



// Clean the update array
unset($update['aptDate']); // all in apt_date
unset($update['aptHour']); // all in apt_date
unset($update['aptMin']); // all in apt_date
unset($update['aptAmPm']); // all in apt_date
// unset($update['department']);

unset($update['patient']); // not needed.. that woudl be a delete
unset($update['aptID']); // is called $thisID now, and needed for the WHERE but not the update.
//unset($update['department']); 
unset($update['submit']); // just a button
//hr();
//print_r($update);
//	header("location: {$htmlRoot}/viewAppointments.php");
//updateTable($table,$col,$id,$array){
// $sql = "UPDATE {$table} SET {$key} = '{$value}' WHERE {$col} = '{$id}'";

$patientEmailToSend = $update['patientEmailToSend'];
unset($update['patientEmailToSend']);
$sendPatientEmail = $update['sendPatientEmail'];
unset($update['sendPatientEmail']);

$regenerate_twilio_links = $update['regenerate_twilio_links'];
unset($update['regenerate_twilio_links']);

if($sendEmail == 'ON'){ // send an email
	$emailHeaders = "From: appointments@itascainterpreter.biz\r\n";
	$emailHeaders .= "MIME-Version: 1.0\r\n";
	$emailHeaders .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
//	$subject = "Change to appointment number {$thisID} -- The current status is {$theStatus}";
	$messageForClinic = "Appointment number {$thisID} has changed. <br>";
	$messageForClinic .= "{$statusMessageForClinic} <br>";
	$messageForClinic .= " Please log in to <a href = 'https://itascainterpreter.biz/portal'> The Itasca Portal </a> to view this appointment.";

	$messageForInterpreter = "Appointment number {$thisID} has changed. <br>";
	$messageForInterpreter .= "{$statusMessageForInterpreter} <br>";
	$messageForInterpreter .= " Hello, Interpreter! Please log in to <a href = 'https://itascainterpreter.biz/portal'> The Itasca Portal </a> to view this appointment.";

	mail($emailTo,$subject,$messageForInterpreter,$emailHeaders);//or die("error sending email");

	mail($emailToOnce, $subject,$messageForClinic,$emailHeaders);
	
	// mail also to scheduling for record keeping
	mail('scheduling@itascainterpreter.biz',$subject,$messageForClinic,$emailHeaders);//or die("error sending email");
	
	
} else {
	$subj = "Appt {$thisID} changed, but no email sent to client.";
	$emailHeaders = "From: appointments@itascainterpreter.biz\r\n";
	$emailHeaders .= "MIME-Version: 1.0\r\n";
	$emailHeaders .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$message = "Appointment number {$thisID} has changed. <br>";
	$message .= "{$statusMessageForClinic} <br>";
	$message .= "<b>HOWEVER,</b> No email was sent to the client";
	mail('scheduling@itascainterpreter.biz',$subj,$message,$emailHeaders);//or die("error sending email");
}

if ( ($_POST['status'] === '3' && $update['need_video_conference'] === '1') || isset($regenerate_twilio_links) ) {
	if ( !$interpreter_twilio_link || empty($interpreter_twilio_link) 
			|| isset($regenerate_twilio_links) ) {
		
		if ( isset($regenerate_twilio_links) ) {
			$update['history'] = $update['history'] . '::' . 'Twilio Link is regenerated' . '-' . $rightNow;
		}

		$siteUrl = $_SERVER['HTTP_ORIGIN'];
		$roomName = uniqid('ROOM_');
		$update['interpreter_twilio_link'] = $siteUrl . '/portal/twilio?name=' . urlencode($interpreterFullName) . '&room=' . $roomName;
		$update['patient_twilio_link'] = $siteUrl . '/portal/twilio?name=' . urlencode($MailToName) . '&room=' . $roomName;		
	
		$patientMessage = 'You have video conference scheduled with ' . $interpreterFullName . ' at ' . $appointmentTime . '. Please use this link to join ' . $update['patient_twilio_link'];
		$interpreterMessage = 'You have video conference scheduled with ' . $MailToName . ' at ' . $appointmentTime . '. Please use this link to join ' . $update['interpreter_twilio_link'];
		
		try {
			sendSms($patientMessage, $patientPhone);
			$update['history'] = $update['history'] . '::' . 'Send SMS to Patient' . '-' . $rightNow;
		} catch (Exception $e) {
			// echo $e->getMessage();
		}
		try {
			sendSms($interpreterMessage, $interpreterPhone);
			$update['history'] = $update['history'] . '::' . 'Send SMS to Interpreter' . '-' . $rightNow;
		} catch (Exception $e) {
			// echo $e->getMessage();
		}
		$dayStr = date('m/d/Y', strtotime($aptDate));
		$appointmentTime = $aptTime . ' on ' . $dayStr;

		if ( $sendEmail === 'ON' || isset($regenerate_twilio_links) ) {
			$interpreterEmail = $emailTo;
			$twilioMailSubject = 'Your video conference link';
			$twilioMailBodyText = 'You have video conference scheduled with ' . $MailToName . ' at ' . $appointmentTime . '. Please use this <a href="' . $update['interpreter_twilio_link'] . '">link</a> to join.';
			try {
				mail($interpreterEmail, $twilioMailSubject, $twilioMailBodyText, $emailHeaders);
				$update['history'] = $update['history'] . '::' . 'Send Email to Interpreter' . '-' . $rightNow;
			} catch (Exception $e) {
				// echo $e->getMessage();
			}
			$twilioStaffMailSubject = 'Video Conference Link';
			$staffTwilioLink = $siteUrl . '/portal/twilio?name=' . urlencode($requested_by) . '&room=' . $roomName;
			$twilioStaffMailBodyText = 'Video conference scheduled between ' . $MailToName . ' and ' . $interpreterFullName . ' at ' . $appointmentTime . '. Please use this <a href="' . $staffTwilioLink . '">link</a> to join.';
			$staffEmail = $emailToOnce;
			try {
				mail($staffEmail, $twilioStaffMailSubject, $twilioStaffMailBodyText, $emailHeaders);
				$update['history'] = $update['history'] . '::' . 'Send Email to ' . $requested_by . '-' . $rightNow;
			} catch (Exception $e) {
				// echo $e->getMessage();
			}
		}

		if ( $sendPatientEmail === 'ON' || isset($regenerate_twilio_links) ) {
			$twilioMailSubject = 'Your video conference link';
			$twilioMailBodyText = 'You have video conference scheduled with ' . $interpreterFullName . ' at ' . $appointmentTime . '. Please use this <a href="' . $update['patient_twilio_link'] . '">link</a> to join.';
			try {
				mail($patientEmailToSend, $twilioMailSubject, $twilioMailBodyText, $emailHeaders);
				$update['history'] = $update['history'] . '::' . 'Send Email to Patient' . '-' . $rightNow;
			} catch (Exception $e) {
				// echo $e->getMessage();
			}
		}
	} else {
		$update['interpreter_twilio_link'] = $row['interpreter_twilio_link'];
		$update['patient_twilio_link'] = $row['patient_twilio_link'];
	}
} else {
	$update['need_video_conference'] = 0;
}
// here's some logic to handle interpreter history.
$confInt = $_POST['interpreter_confirmed'];
if($nowStat != '3'){ // if this appointment is not already confirmed
	if($statusFUD == '3'){ // if it is getting confirmed.
		$ihist = "SELECT history FROM interpreters WHERE id = '{$confInt}'";
		$gg = mysql_query($ihist);
		$rr = mysql_fetch_assoc($gg);
		$nhist = $rr['history'];
		$newiHist = "{$thisID}";
		$NIH = "{$nhist},{$newiHist}";
		$updhist = "UPDATE interpreters SET history = '{$NIH}' WHERE id = '{$confInt}'";
		$updint = mysql_query($updhist); 
		
	}
}




updateTable('appointment_requests','id',$thisID,$update);
header("location: {$htmlRoot}/viewAppointments.php");


/*
if($Status == 'Confirmed'){
		$subject = "Appointment {$id} has been confirmed.";
		$message = "This email is to confirm your Itasca online Interpreter request for appointment ID# {$id}.  Please contact Itasca for any changes to the appointment at 651-457-7400. This is an automatically generated email, please do not reply to this address. Thank you for using Itasca Interpretation Services.";
		$sendEmail = TRUE;
	} elseif ($Status == 'Denied'){
		$subject = "Sorry, Itasca is unable to provide an interpreter for your Appointment {$id}.";
		$message = "This email is to confirm that Itasca is unable to provide an interpreter for your online request appointment ID# {$id}. Please contact Itasca at 651-457-7400 if you should have any questions. This is an automatically generated email, please do not reply to this address. Thank you for using Itasca Interpretation Services."; 
		$sendEmail = TRUE;
	} elseif ($Status == 'Cancelled'){
		$subject = "Appointment {$id} has been cancelled.";
		$message = "This email is to confirm that Itasca have received a fax or phone cancellation from your facility for ID# {$id}. If you feel that this is an error please contact Itasca at 651-457-7400. This is an automatically generated email, please do not reply to this address. Thank you for using Itasca Interpretation Services.";
		$sendEmail = TRUE;
	} else {
		$sendEmail = FALSE;
	}


*/
?>
