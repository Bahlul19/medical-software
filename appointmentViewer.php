<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
$apt = $_GET['a'];
?>
<!doctype HTML>
<html>
<head>
<style>
.reqCan {
	background-color:#FF0000;
	color:#FFFFFF;
	font-weight:bold;
	text-decoration:none;
	border: 1px solid #cccccc;

	padding:2px 20px 2px 20px;
}


</style>
<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.datepick.js"></script>
<script>
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

function showDate(date) {
	alert('The date chosen is ' + date);
}
</script>


<title> Itasca</title>
<?php
require("{$legos}/head.php");
?>

<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");




///////////////////////// LOCK //////////////////////////
// locked
/*
$sql = "SELECT locked FROM appointment_requests WHERE id = '{$apt}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$locked = $row['locked'];
if($locked != 0){ // if it is locked
	$sql = "SELECT name_f,name_l FROM users WHERE id = '{$locked}'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	$lb = $row['name_f'] . " " . $row['name_l'];
	echo "<script>";
	echo "alert('This appointment is being edited by {$lb}');";
	echo "</script>";
	die("This appointment is locked");
} else { // lock the appointment
	$sql = "UPDATE appointment_requests SET locked = '{$uInfo['id']}' WHERE id = '{$apt}'";
	$go = mysql_query($sql);
}
///////////////////////////////////////////////////////
*/
?>




<div class = 'siteWrap'>


	<div class = 'aptForm'>
		<div class = 'formTitle'>
		Viewing Appointment Number 
		<?php
		echo $apt;
		?>
		</div>
<?php
//function dataGet($fieldsArray,$table,$where,$clause){
	// fieldsArray can be an array of fields or "*" 
$appt = dataGet("*","appointment_requests",'id',$apt);
$appt = $appt[0];
//print_r($appt);
//hr();
$aptDate = date("m/d/y",$appt['apt_date']);
$aptHour = date("h",$appt['apt_date']);
$aptMin = date("i",$appt['apt_date']);
$aptAmPm = date("A",$appt['apt_date']);
$thisClinic = $appt['clinic'];

$sql = "SELECT email FROM clinics WHERE id = '{$thisClinic}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$defaultEmail = $row['email'];


//function formInput($name,$type,$value,$param){
formForm("",'post','onsubmit="return validateForm();"');


formInput("aptID","hidden",$apt);
if($role == 1 || $role == 2){

	formLabel("clinic","Clinic");
	//formDropdown($name,$table,$fieldV,$fieldW,$defaultValue = 'spec',$default = 'Please Specify', $other = 'other',$params)
	$cln = dataGet("*","clinics","id",$appt['clinic']);
	$cln = $cln[0];
	$cln = $cln['title'];
	echo "<onedrop>";
	//formDropdown("clinic","clinics","id","title",$appt['clinic'],$cln,"other");
	formSelect('clinics',$cln);
	//echo $appt['clinic'];
	echo "</onedrop>";
	clearfix();

}
// date time
formLabel('popupDatepicker','Appointment Date');
formInput('aptDate','text',$aptDate,'readonly="true"');
clearfix();

// time
formLabel('AptTime','Appointment Time');
	/*echo "<onedrop>";
	echo "{$aptHour}:{$aptMin} {$aptAmPm}";
	echo "</onedrop>";*/
	echo "<triselect>";
		formSelect('aptHour',"{$aptHour}","id = 'aptHour'");
		formSelect('aptMin',"{$aptMin}","id = 'aptMin'");
		formSelect('aptAmPm',"{$aptAmPm}","id = 'aptAmPm'");
	echo "</triselect>";
	clearfix();

//ASAP
formLabel("asap","ASAP");
formInput("","text",$appt['asap'],"readonly = 'true'");
clearfix();


// Add duration HERE
formLabel('duration','Duration (In Minutes)');
formInput('duration','text',$appt['duration'],'readonly="true"');
clearfix();
$dept = dataGet("*","departments","id",$appt['department']);
$dept = $dept[0];
$dept = $dept['title'];
formLabel('department','Department / Procedure');
//formInput('department','text',$dept);
echo "<input type = 'text' value = '{$dept}' readonly = 'true'>";
clearfix();

//Provider Name
formLabel("provider_name","Provider Name");
formInput("provider_name","text",$appt['provider_name'],"readonly = 'true'");
clearfix();

hr();
$patInfo = dataGet("*","patients","id",$appt['patient']);
$patInfo = $patInfo[0];
formInput("patient","hidden",$appt['patient']);


//NAME
formLabel("name_f","Patient First Name");
formInput("","text",$patInfo['name_f'],"readonly = 'true'");
clearfix();
formLabel("name_l","Patient Last Name");
formInput("","text",$patInfo['name_l'],"readonly = 'true'");
clearfix();

//MRN
formLabel("mrn","MRN");
formInput("","text",$patInfo['mrn'],"readonly = 'true'");
clearfix();

// dob
formLabel("dob","Patient Date Of Birth");
formInput("","text",$patInfo['dob'],"readonly = 'true'");
clearfix();

// gender
formLabel("gen","Gender");
formInput("","text",$patInfo['gender'],"readonly = 'true'");
clearfix();


$lang = dataGet("*","languages","id",$patInfo['language']);
$lang = $lang[0];
$lang = $lang['language'];

formLabel("language","Language");
formInput("","text",$lang,"readonly = 'true'");
clearfix();

// prefered int
formLabel("pi","Preferred Interpreter");
formInput("","text",$patInfo['prefered_interpreter'],'readonly = "true"');
clearfix();

//address stuff
formLabel("ad1","Address 1");
formInput("","text",$patInfo['addr_1'],"readonly = 'true'");
clearfix();
formLabel("ad2","Address 2");
formInput("","text",$patInfo['addr_2'],"readonly = 'true'");
clearfix();
formLabel("adC","City");
formInput("","text",$patInfo['addr_city'],"readonly = 'true'");
clearfix();
formLabel("adS","State");
formInput("","text",$patInfo['addr_state'],"readonly = 'true'");
clearfix();
formLabel("adZ","Zip");
formInput("","text",$patInfo['addr_zip'],"readonly = 'true'");
clearfix();

// phone
formLabel("ph","Phone");
formInput("","text",$patInfo['phone'],"readonly = 'true'");
clearfix();

//second phone number
formLabel("secondPhone","Second Phone");
formInput("","text",$patInfo['second_phone'],"readonly = 'true'");
clearfix();

$speakers = getIntsByLanguage($patInfo['language'],'byID','TRUE');
asort($speakers); // alphabetical


// Itasca Int Req
/*formLabel("interpreter_req","Itasca Requested Interpreter");
echo "<onedrop>";
//	formSelect('interpreter_confirmed',$speakers,'id = "interpreter_conf"');
if($appt['interpreter_req'] != '' && $appt['interpreter_req'] != 'ANY'){ // there is a currenly confirmed int.
	$intInfo = dataGet("*","users","id",$appt['interpreter_req']);
	$intInfo = $intInfo[0];
	$ifn = $intInfo['name_f'];
	$iln = $intInfo['name_l'];
	$iid = $intInfo['id'];
	echo " {$ifn} {$iln} ";
}
echo "</onedrop>";*/

clearfix();



// Itasca Int Req
formLabel("interpreter_req","Itasca Requested Interpreter");
echo "<onedrop>";
echo "<select name = 'interpreter_req'>";

//	formSelect('interpreter_confirmed',$speakers,'id = "interpreter_conf"');
if($appt['interpreter_req'] != '' && $appt['interpreter_req'] != 'ANY'){ // there is a currenly confirmed int.
	$intInfo = dataGet("*","users","id",$appt['interpreter_req']);
	$intInfo = $intInfo[0];
	$ifn = $intInfo['name_f'];
	$iln = $intInfo['name_l'];
	$iid = $intInfo['id'];
	echo " {$ifn} {$iln} ";
	echo "<option value = '{$iid}'> {$ifn} {$iln} </option>";
}
else {
	echo "<option> {$appt['interpreter_req']} </option>";
}
echo "</select>";
echo "</onedrop>";

clearfix();



// pending intgerpreter
formInput("","hidden",$appt['interpreter_claim']);
$intInfo = dataGet("*","users","id",$appt['interpreter_claim']);
$intInfo = $intInfo[0];
$ifn = $intInfo['name_f'];
$iln = $intInfo['name_l'];
formLabel("intclaim","Interpreter Claim");
if($role == 1 || $role == 2){
echo "<onedrop>";
echo "<select name = 'interpreter_claim'>";
echo "<option value = '{$intInfo['id']}'> {$ifn} {$iln} </option>";
echo "</select>";
echo "</onedrop>";
} else {
formInput("interpreter_claim","text",$ifn . " " . $iln,"readonly = 'true'");
}
clearfix();


// CONFIRMED INT
/*formLabel("interpreter_confirmed","Confirmed Interpreter");
	// INTERP CONF DROPDOWN LOGIC
//	$speakers = getIntsByLanguage($patInfo['language'],'byID');
//	asort($speakers); // alphabetical
	echo "<onedrop>";
//	formSelect('interpreter_confirmed',$speakers,'id = "interpreter_conf"');
	if($appt['interpreter_confirmed'] != '' && $appt['interpreter_confirmed'] != '0'){ // there is a currenly confirmed int.
		$intInfo = dataGet("*","users","id",$appt['interpreter_confirmed']);
		$intInfo = $intInfo[0];
		$ifn = $intInfo['name_f'];
		$iln = $intInfo['name_l'];
		$iid = $intInfo['id'];
		echo " {$ifn} {$iln} ";
	}
	echo "</onedrop>";
clearfix();*/


// CONFIRMED INT
formLabel("interpreter_confirmed","Confirmed Interpreter");
	echo "<onedrop>";
	echo "<select name = 'interpreter_confirmed' onChange = 'interpreterBook(this.value);'>";
	if($appt['interpreter_confirmed'] != '' && $appt['interpreter_confirmed'] != '0'){ // there is a currenly confirmed int.
		$intInfo = dataGet("*","users","id",$appt['interpreter_confirmed']);
		$intInfo = $intInfo[0];
		$ifn = $intInfo['name_f'];
		$iln = $intInfo['name_l'];
		$iid = $intInfo['id'];
		echo "<option value = '{$iid}'> {$ifn} {$iln} </option>";
	}
	else { 
		echo "<option value = '0'> None </option>";
	}
	echo "</select>";
	echo "</onedrop>";
clearfix();



if($uInfo['role'] == 1 || $uInfo['role'] == 2){

	formLabel("status","Appointment Status");
	$as = dataGet("*","appointment_status","id",$appt['status']);
	$as = $as[0];
	$asw = $as['title'];

	echo "<oneDrop>";
	//formDropdown("status","appointment_status","id","title",$appt['status'],$asw,'','id = "status"');
	formSelect('appointment_status',$asw);
	echo "</oneDrop>";
	clearfix();
}


hr();


$rBy = dataGet("*","users","id",$appt['requested_by']);
$rBy = $rBy[0];
$rbf = $rBy['name_f'];
$rbl = $rBy['name_l'];
formLabel("requested_by","Requested By");
formInput("","text",$appt['requested_by'],"readonly = 'true'");
clearfix();



$reqDate = date("m/d/y h:i A",$appt['date_requested']);
formLabel("date_requested","Date Of Request");
formInput("","text",$reqDate,"readonly = 'true'");

clearfix();
formLabel('comments','Comments');
clearfix();

echo "<div style = 'width:100%;height:100px;border:1px solid #666;'>";
echo $appt['comments'];
echo "</div>";

clearfix();


?>




	</div> <!-- aptForm -->
</div> <!-- siteWrap -->
<script>
function confirmDelete(){
var $conf = confirm("You are about to DELETE this appointment. This process is NOT REVERSIBLE. Press OK to PERMANENTLY DELETE this appointment, or Cancel to cancel.");
	if($conf == true){
	//	alert("DELETED");
		return true;
	}else{
		return false;
	}
}

function validateForm(){
	var $status = document.getElementById('status').value;
	var $intConf = document.getElementById('interpreter_conf').value;
	if($status == 3 && $intConf == 0){
		alert('An appointment can not be confirmed without a confirmed interpreter.');
		return false;
	} 


//	return false; 
}
</script>
<?php
require("scripts.php");
?>


</body>
</html>


