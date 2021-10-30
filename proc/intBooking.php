<?php
require('../inc/init.php');
$date = $_GET['date'];
$day = explode(" ",$date);
$day = $day[0];
$endOfDay = strtotime("{$day} 23:59");
$interpreter = $_GET['int'];
$unixDate = strtotime($date);
if($interpreter == 0 || $interpreter == '' ) {

} else{
echo "<div style = 'margin-top:10px;margin-bottom:10px;width:95%;border:3px solid #000;padding:10px;'>";
echo "<b> Schedule for {$day} </b> ";
echo "<hr>";
$before = $unixDate -3600;
$beginOfDay = strtotime("{$day} 00:01");

//$checkQL = "SELECT id, apt_date, duration FROM appointment_requests WHERE interpreter_confirmed = '{$interpreter}' AND apt_date > '{$before}' AND apt_date < '{$endOfDay}' ORDER BY apt_date ASC";




//This code is for adding the appointment into the project start

/*

$blame = $uInfo['id'];
$nowStat = $_POST['status'];
$statusFUD = $_POST['status'];
$rightNow = date("m/d/y H:i");


$intConf= $_POST['interpreter_confirmed'];
$update = $_POST;
if($update['status'] == 'other'){
	$update['status'] = '1';
}
$sendEmail = $update['sendEmail'];
$emailTo = $update['emailTo'];

unset($update['emailTo']);
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
$thisID = $update['aptID'];


//get some current data Start

$sql = "SELECT history,status,confirmed_by FROM appointment_requests WHERE id = '{$thisID}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$nowHist = $row['history'];
$nowStat = $row['status'];
$confBy = $row['confirmed_by'];


$sql = "SELECT title FROM appointment_status WHERE id = '{$update['status']}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$theStatus = $row['title'];


//get interpreterName
$interpreterName = $_POST['interpreter_confirmed'];
$sql2 = "SELECT name_f,name_l FROM users where id = '{$interpreterName}' ";
$go = mysql_query($sql2);
$row = mysql_fetch_assoc($go);
$interpreterFullName = $row['name_f'] . " " . $row['name_l'];


$sql = "SELECT name_f,name_l FROM users WHERE id = '{$blame}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$theBlame = $row['name_f'] . " " . $row['name_l'];



$sql = "SELECT name_f,name_l FROM patients WHERE id = '{$update['patient']}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$MailToName = $row['name_f']. " " . $row['name_l'];


$cln = dataGet("*","clinics","id",$_POST['clinic']);
$clinicName = $cln[0];

$clinicName = $clinicName['title'];
$clinicAddress = $cln[0];
$clinicAddress = $clinicAddress['addr_1']." ".$clinicAddress['addr_2'];
//create or append history.
$newHist = "{$theBlame}-{$theStatus}-{$rightNow}-{$clinicName}<br><b>Address </b> : {$clinicAddress} <hr>";
$nextHist = "{$nowHist}::{$newHist}";
$update['history'] = $nextHist;
$update['locked'] = 0; // unlock


if($update['status'] == 3){ // status is confirmed
	if($confBy == 0 || $confBy == ''){ // if it is not already confirmed
		$update['confirmed_by'] = $blame;
	}


}
*/

//This code is for adding the appointment into the project END

$checkQL = "SELECT id, apt_date, duration, clinic, status FROM appointment_requests WHERE interpreter_confirmed = '{$interpreter}' AND apt_date > '{$beginOfDay}' AND apt_date < '{$endOfDay}' ORDER BY apt_date ASC";
$checkGO = mysql_query($checkQL) or die (mysql_error());
if(mysql_num_rows($checkGO) > 0){
	while($checkROW = mysql_fetch_assoc($checkGO)){



//this is start


$blame = $uInfo['id'];
//$nowStat = $_POST['status'];
$nowStat = $checkROW['status'];
$statusFUD = $_POST['status'];
$rightNow = date("m/d/y H:i");


$intConf= $_POST['interpreter_confirmed'];
$update = $_POST;
if($update['status'] == 'other'){
	$update['status'] = '1';
}
$sendEmail = $update['sendEmail'];
$emailTo = $update['emailTo'];

unset($update['emailTo']);
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
$thisID = $update['aptID'];

//get some current data Start

$sql = "SELECT history,status,confirmed_by FROM appointment_requests WHERE id = '{$thisID}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$nowHist = $row['history'];
//$nowStat = $row['status'];
$confBy = $row['confirmed_by'];


// $sql = "SELECT title FROM appointment_status WHERE id = '{$update['status']}'";

$sql = "SELECT title FROM appointment_status WHERE id = '{$nowStat}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$theStatus = $row['title'];
// $theStatus = 3;


//get interpreterName
$interpreterName = $_POST['interpreter_confirmed'];
$sql2 = "SELECT name_f,name_l FROM users where id = '{$interpreterName}' ";
$go = mysql_query($sql2);
$row = mysql_fetch_assoc($go);
$interpreterFullName = $row['name_f'] . " " . $row['name_l'];

$sql = "SELECT name_f,name_l FROM users WHERE id = '{$blame}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$theBlame = $row['name_f'] . " " . $row['name_l'];


$sql = "SELECT name_f,name_l FROM patients WHERE id = '{$update['patient']}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$MailToName = $row['name_f']. " " . $row['name_l'];


$cln = dataGet("*","clinics","id", $checkROW['clinic']);

//$cln = dataGet("*","clinics","id",2);


$clinicName = $cln[0];

$clinicName = $clinicName['title'];




//print_r($clinicName);

//echo $clinicName."<br/>";

$clinicAddress = $cln[0];
$clinicAddress = $clinicAddress['addr_1']." ".$clinicAddress['addr_2'];

//print_r($clinicAddress);
//create or append history.

//print_r($clinicAddress);

//$newHist = "{$theStatus}-{$clinicName}<br><b>Address </b> : {$clinicAddress} <hr>";
$newHist = "{$theStatus}-{$clinicName}<hr>";

 //$newHist = "{$theBlame}-{$theStatus}-{$rightNow}-{$clinicName}<br><b>Address </b> : {$clinicAddress} <hr>";

//print_r($newHist);

$nextHist = "{$nowHist}::{$newHist}";
$update['history'] = $nextHist;
$update['locked'] = 0; // unlock


if($update['status'] == 3){ // status is confirmed
	if($confBy == 0 || $confBy == ''){ // if it is not already confirmed
		$update['confirmed_by'] = $blame;
	}


}


//this is end



//old code 


		$startUnix = $checkROW['apt_date'];
		$startDate = date("Y/m/d H:i",$startUnix);
		//echo "$checkDate <br>";
		$durSeconds = $checkROW['duration'] * 60;
		$aptEndUnix = $startUnix + $durSeconds;
		$endDate = date("H:i",$aptEndUnix);
		// echo "appointment {$checkROW['id']} From $startDate - $endDate {$newHist}";
		echo "appointment {$checkROW['id']} From $startDate - $endDate {$newHist}";

		//foa adding 

		$endTarget = $aptEndUnix + 3600;
	
		// now.. we need to know if any of the appointments fall between between the start time and one hour after the
	}
} else {
	echo "No appointments for this interpreter on {$day}";
}

echo "</div>";
}
?>
