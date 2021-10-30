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

.reqCanUpdate {
	background-color:#228B22;
	color:#FFFFFF;
	font-weight:bold;
	text-decoration:none;
	border: 1px solid #cccccc;
	/*float: right;*/
	margin-left: 130px;
	padding:2px 20px 2px 20px;
}

.redx{
background-color:#FF0000;
color:#FFFFFF;
font-weight:bold;
display:inline-block;
}

.wofStyle 
{
	float: left;
    /*width: 50%;*/
    border: 1px solid #AAAAAA;
	/*margin-top: 15px;
    margin-bottom: 15px;*/
    cursor: pointer;
    text-decoration: none;
    margin-top: 14px;
    margin-bottom: 15px;
    padding: 1px 6px;
    background:   #ebe8ea;
    color: black;
    width: 44%;
    text-align: center;
}

</style>
<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.datepick.js"></script>
<script src="js/custom.js"></script>
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


	<div class = 'aptForm appointment-edit'>
		<div class = 'formTitle'>
		Editing Appointment Number 
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
formForm("{$htmlRoot}/proc/appointmentEditor.php",'post','onsubmit="return validateForm();"');


formInput("aptID","hidden",$apt);
if($role == 1 || $role == 2){

	formLabel("clinic","Clinic");
	//formDropdown($name,$table,$fieldV,$fieldW,$defaultValue = 'spec',$default = 'Please Specify', $other = 'other',$params)
	$cln = dataGet("*","clinics","id",$appt['clinic']);
	$cln = $cln[0];
	$cln = $cln['title'];
	echo "<onedrop>";
	formDropdown("clinic","clinics","id","title",$appt['clinic'],$cln,"other");
	echo "</onedrop>";
	clearfix();

}
// date time
formLabel('popupDatepicker','Appointment Date');
if($role == 1 || $role == 2){
	formInput('aptDate','text',$aptDate,'readonly="true" id="popupDatepicker" class = "aptDateClass"');
} else {
	formInput('aptDate','text',$aptDate,'readonly="true" class = "aptDateClass"');
}
clearfix();
// time
formLabel('AptTime','Appointment Time');
if($role == 1 || $role == 2){
	echo "<triselect>";
	formSelect('aptHour',"{$aptHour},12,1,2,3,4,5,6,7,8,9,10,11","id = 'aptHour'");
	formSelect('aptMin',"{$aptMin},00,05,10,15,20,25,30,35,40,45,50,55","id = 'aptMin'");
	formSelect('aptAmPm',"{$aptAmPm},AM,PM","id = 'aptAmPm'");
	echo "</triselect>";
} else {
//	echo "<onedrop>";
//		echo "{$aptHour}:{$aptMin} {$aptAmPm}";
//	echo "</onedrop>";
	formSelect('aptHour',"{$aptHour}","id = 'aptHour'");
	formSelect('aptMin',"{$aptMin}","id = 'aptMin'");
	formSelect('aptAmPm',"{$aptAmPm}","id = 'aptAmPm'");

}
	clearfix();

formLabel("asap","ASAP");
if($role == 1 || $role == 2){
	echo "<onedrop>";
	formSelect('asap',"{$appt['asap']},YES,NO,CC");
	echo "</onedrop>";
} else {
	formInput("","text",$appt['asap'],"readonly = 'true'");
}
clearfix();

// Add duration HERE
formLabel('duration','Duration (In Minutes)');
if($role == 1 || $role == 2){
	formInput('duration','text',$appt['duration']);
} else {
	formInput('duration','text',$appt['duration'],'readonly="true"');
}
clearfix();

// for department just comment out id

$dept = dataGet("*","departments","id",$appt['department']);
$dept = $dept[0];
$dept = $dept['title'];
formLabel('department','Department / Procedure');
formInput('department','text',$dept);
//echo "<input type = 'text' value = '{$dept}' readonly = 'true'>";
//echo "<input type = 'text' value = '{$dept}'>";
clearfix();


//new department start
/*
$dept = dataGet("*","departments","id",$appt['department']);
formLabel('department','Department / Procedure');
echo "<onedrop>";
	formSelect('department',$dept);
	echo "</onedrop>";
clearfix();
*/
//new department start end

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
if($role == 1 || $role == 2){
	formInput("","text",$patInfo['prefered_interpreter']);
} else {
	formInput("","text",$patInfo['prefered_interpreter'],'readonly="true"');
}
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


$insurance = dataGet("*","insurance_providers","id",$patInfo['insurance_provider']);
$insurance = $insurance[0];
$insurance = $insurance['title'];

formLabel("insurance","Insurance");
formInput("","text",$insurance,"readonly = 'true'");

clearfix();

formLabel("insuranceId","Insurance ID");
formInput("","text",$patInfo["insurance_id"],"readonly = 'true'");

clearfix(); 

$speakers = getIntsByLanguage($patInfo['language'],'byID','TRUE');
asort($speakers); // alphabetical


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
	echo "<option value = '{$iid}'> {$ifn} {$iln} </option>";
}
if($role == 1 || $role == 2){
	echo "<option value = 'ANY'> Any </option>";
	foreach($speakers as $sk => $sv){
		echo "<option value = '{$sk}'> {$sv} </option>";
	}
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
//echo "<input type='text' name='interpreter_confirmed' id = 'interpreter_conf' value='' size = '20' class='autoInterp'>";


if($role == 1 || $role == 2){
echo "<onedrop>";
//echo "<input type = 'text' name = 'interpreter_claim' value = '{$ifn} {$iln}' id = 'intClaim' readonly = 'true'>";
//formInput("interpreter_claim","text",$ifn . " " . $iln,"readonly = 'true' id = 'intClaim'");
echo "<select name = 'interpreter_claim'>";
echo "<option value = '{$intInfo['id']}'> {$ifn} {$iln} </option>";
echo "<option value = '' style = 'background-color:#ff0000;'> REMOVE THIS CLAIM </option>"; 
echo "</select>";
echo "</onedrop>";
//echo "<span class = 'redx' onclick = 'remClaim()'>X</span>";
} else {
formInput("interpreter_claim","text",$ifn . " " . $iln,"readonly = 'true'");
}


clearfix();



// CONFIRMED INT
formLabel("interpreter_confirmed","Confirmed Interpreter");
	// INTERP CONF DROPDOWN LOGIC
//	$speakers = getIntsByLanguage($patInfo['language'],'byID');
//	asort($speakers); // alphabetical
	echo "<onedrop>";
	echo "<select name = 'interpreter_confirmed' onChange = 'interpreterBook(this.value);'>";
//	formSelect('interpreter_confirmed',$speakers,'id = "interpreter_conf"');
	if($appt['interpreter_confirmed'] != '' && $appt['interpreter_confirmed'] != '0'){ // there is a currenly confirmed int.
		$intInfo = dataGet("*","users","id",$appt['interpreter_confirmed']);
		$intInfo = $intInfo[0];
		$ifn = $intInfo['name_f'];
		$iln = $intInfo['name_l'];
		$iid = $intInfo['id'];
		echo "<option value = '{$iid}'> {$ifn} {$iln} </option>";
	}
	
	if($role == 1 || $role == 2){
		echo "<option value = '0'> None </option>";
		foreach($speakers as $sk => $sv){
			echo "<option value = '{$sk}'> {$sv} </option>";
		}
	}
	
	
	echo "</select>";
	echo "</onedrop>";


clearfix();

echo "<span id = 'interpreterBooking'></span>";

clearfix();


if($uInfo['role'] == 1 || $uInfo['role'] == 2){

	formLabel("status","Appointment Status");
	$as = dataGet("*","appointment_status","id",$appt['status']);
	$as = $as[0];
	$asw = $as['title'];

	echo "<oneDrop>";
	formDropdown("status","appointment_status","id","title",$appt['status'],$asw,'','id = "status"');
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

formInput('printWOF','submit','Print WOF', 'class="printWOF-btn"');
echo "<a href='wordorderform.php' class='wofStyle'>Work Order Form</a>";

clearfix();
	if($uInfo['role'] == 1 || $uInfo['role'] == 2){
	formLabel('comments','Comments');
	clearfix();
	echo "<textarea name = 'comments'>";
	echo $appt['comments'];
	echo "</textarea>";

	clearfix();
} else {
	formLabel('','Comments');
	clearfix();
	echo "<div style = 'width:95%;border:1px solid #333;background-color:#e6e6e6;padding:2%;min-height:100px;margin-bottom:20px;'>";
		echo $appt['comments'];
	echo "</div>";
	clearfix();
}
if($uInfo['role'] == 1 || $uInfo['role'] == 2){ // admin and itasca staff only.
	formLabel('comments','Internal Comments');
	clearfix();
	echo "<textarea name = 'comments_internal'>";
	echo $appt['comments_internal'];
	echo "</textarea>";
	
	
}


clearfix();
	formLabel("history","Changes History");
	br();
	clearfix();
	$qq = explode('::',$appt['history']);

	//echo '<pre>'.print_r($qq).'</pre>';

	foreach($qq as $kk => $vv){
		echo "{$vv}<br>";
	 }
	//echo $appt['history'];
	hr();



if($uInfo['role'] == 1 || $uInfo['role'] == 2){

	formLabel('sendEmail','Send Email');
	formInput('sendEmail','checkbox','ON');
	clearfix();
	
	formLabel('emailTo',"Email Address");
	 if($appt['confirmation_email'] == ''){ // if there is not a confirmation email
	 	$theEmail = $defaultEmail; // set it to default
	 } else { // if there is
	 	$theEmail = $appt['confirmation_email']; // set it to the one we have
	 }
	formInput('emailTo','text',$theEmail); 
	clearfix();
	
	
	formLabel('fax','Fax number');
	formInput('confirmation_fax','text',$appt['confirmation_fax']);
	clearfix();




	//This is for interpreter users
	formLabel('Interpreter','Interpreter address ');
	// formInput("","text",'benson.dasilva@sjinnovation.com',"readonly = 'true'");

	if($appt['confirmation_email'] == ''){ // if there is not a confirmation email
	 	$theEmail = $defaultEmail; // set it to default
	 } else { // if there is
	 	$theEmail = $appt['confirmation_email']; // set it to the one we have
	 }
	formInput('emailTo','text',$theEmail); 
	clearfix();


	clearfix();
	formInput('submit','submit','Submit Changes','id="submit" class = "nextButton"');
}
clearfix();
if($uInfo['role'] != 1 && $uInfo['role'] != 2){
	//formInput('submit','submit','REQUEST CANCELLATION','class = "delete"');
	echo "<a href = '{$htmlRoot}/appointmentCancel.php?a={$apt}' class = 'reqCan'> Request Cancellation </a>";
}

// create a new field for adding the upate data mechanism into the update

if($uInfo['role'] != 1 && $uInfo['role'] != 2){
	//formInput('submit','submit','REQUEST CANCELLATION','class = "delete"');
	echo "<a href = '{$htmlRoot}/appointmentUpdate.php?a={$apt}' class = 'reqCanUpdate'> Update Request </a>";
}


formClose();
	
clearfix();
if($uInfo['role'] == 1 || $uInfo['role'] == 2){
	br();
	hr();
	br();
	formForm('deleteAppointment.php','post','onsubmit = "return confirmDelete();"');
	formInput('delID','hidden',$appt['id']);
	echo "<input type = 'submit' value = 'Delete This Appointment' class = 'delete' >";
	formClose();
	clearfix();
}

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
<script>
// onChange = 'interpreterBook(this.value);'
function interpreterBook($str){
	//alert($str);
	/*
	formInput('aptDate',
	formSelect('aptHour',"{$aptHour},12,1,2,3,4,5,6,7,8,9,10,11");
	formSelect('aptMin',"{$aptMin},00,05,10,15,20,25,30,35,40,45,50,55");
	formSelect('aptAmPm',"{$aptAmPm},AM,PM");
	*/
	var $dateList = document.getElementsByClassName('aptDateClass');
	var $date = $dateList[0].value;
	var $hour = document.getElementById('aptHour').value;
	var $minute = document.getElementById('aptMin').value;
	var $ampm = document.getElementById('aptAmPm').value;
	var $dateString = $date+" "+$hour+":"+$minute+" "+$ampm;
//	alert($dateString+" int = "+$str);
	
	
	//JAX
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		//	alert("READY "+xmlhttp.readyState+" status "+xmlhttp.status);
			document.getElementById("interpreterBooking").innerHTML=xmlhttp.responseText;
		}
	} 
	xmlhttp.open("GET","proc/intBooking.php?date="+$dateString+"&int="+$str,true);
	xmlhttp.send();
	
	
	
	
	
}
</script>
<script>
function remClaim(){
	alert('Hang on a second....');
}
</script>
<?php
require("scripts.php");
?>


</body>
</html>


