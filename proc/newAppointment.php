<?php
$SECURE = TRUE;
require_once("../inc/init.php");
// new appointment processor
// nik Rubenstein 12-01-2014

//print_r($_POST);
//hr();
//facility

$confEmail = $_POST['confEmail'];

$confFax = $_POST['confFax'];
$facility = $_POST['facility_id'];
$clinic = $_POST['clinicID'];
//patient
$patient = $_POST['patId'];
$returnPatient = $_POST['patientName'];
//$returnPatient = str_replace(" ","-",$returnPatient);
$asap = $_POST['asap'];

// make unix stamp from date/time
$aptDate = $_POST['aptDate'];
$aptTime = "{$_POST['aptHour']}:{$_POST['aptMin']} {$_POST['aptAmPm']}";
$aptUnix = $ApptUnix = strtotime("$aptDate $aptTime");

// turns hours and minutes in to just minutes.
$durH = $_POST['aptDurHour'] * 60;
$durM = $_POST['aptDurMin'];
$duration = $durH + $durM;


$patPrefInt = $_POST['patPrefInt'];
unset($_POST['patPrefInt']);
$sql = "UPDATE patients SET prefered_interpreter = '{$patPrefInt}' WHERE id = '{$patient}'";
$go = mysql_query($sql)or die(mysql_error());

//department
if($_POST['department'] == 'other' && $_POST['newDepartment'] != ''){

	$newDept = $_POST['newDepartment'];
	
	$nowDept= newDepartment($newDept);
	unset($_POST['newDepartment']);
	$department = $nowDept;
//	echo "{$newDept} is now id {$nowDept} <hr>";
} else {
	$department = $_POST['department'];
}

//get interpreter userID from string
$intReq = explode('(',$_POST['interpreterReq']);
$intReq = $intReq[1];
$intReq = str_replace(')','',$intReq);


// requested by
$reqBy = $_POST['reqBy'];

//ProviderName Added for new request
$providerName = $_POST['ProviderName'];

// date of request
$requestDate = $_POST['reqDate'];
$reqDateUnix = strtotime("$requestDate");
//comments
$comments = $_POST['comments'];

$baseball = "SELECT language FROM patients WHERE id = '{$patient}'";
$pitch = mysql_query($baseball);
$catch = mysql_fetch_assoc($pitch);
$thisPatLang = $catch['language'];

$insertArray = array(
	'patient' => $patient,
	'language' => $thisPatLang,
	'apt_date' => $aptUnix,
	'duration' => $duration,
	'asap' => $asap,
	'facility' => $facility,
	'clinic' => $clinic,
	'interpreter_req' => $intReq,
	'requested_by' => $reqBy,
	'confirmation_email' => $confEmail,
	'confirmation_fax' => $confFax,
	'department' => $department,
	'date_requested' => $reqDateUnix,
	'status' => '1',
	'comments' => $comments,
	'provider_name'=>$providerName 
);

$ret = insertMany('appointment_requests',$insertArray);
$_SESSION['message'] = "msg: Appointment {$ret} has been created";
//echo $ret;
// create history
updateHistory($patient,$ret);





if($_POST['submit'] == "Submit"){
	header("location: {$htmlRoot}/viewAppointments.php");
} else {
	$_SESSION['returnPatient'] = $returnPatient;
	header("location: {$htmlRoot}/newAppointment.php");
}



?>
