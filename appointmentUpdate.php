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
.delete{
	background-color:#FF0000;
	color:#FFFFFF;
	font-weight:bold;

}


</style>
<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.datepick.js"></script>


<title> Itasca</title>
<?php
require("{$legos}/head.php");
?>

<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");



?>




<div class = 'siteWrap'>


	<div class = 'aptForm'>
		<div class = 'formTitle'>
		Update Appointment Number 
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
formForm("{$htmlRoot}/proc/appointmentUpdate.php",'post','onsubmit="return validateForm();"');


formInput("aptID","hidden",$apt);


	formLabel("facility","Facility");
	//formDropdown($name,$table,$fieldV,$fieldW,$defaultValue = 'spec',$default = 'Please Specify', $other = 'other',$params)
	$fac = dataGet("*","facilityredo","id",$appt['facility']);
	$fac = $fac[0];
	$fac = $fac['title'];
	echo "<input type = 'text' readonly = 'true' value = '{$fac}'>";
	clearfix();
// date time
formLabel('popupDatepicker','Appointment Date');
formInput('','text',$aptDate,'readonly="true"');
clearfix();
// time
formLabel('AptTime','Appointment Time');
	
	echo "<input type = 'text' readonly= 'true' value = '{$aptHour} {$aptMin} {$aptAmPm}'>";
	clearfix();



//formLabel("id","Appointment ID");
//formInput("id","text",$appt['id'],"readonly = 'true'");


$patInfo = dataGet("*","patients","id",$appt['patient']);
$patInfo = $patInfo[0];
formInput("","hidden",$appt['patient']);

formLabel("","Patient First Name");
formInput("","text",$patInfo['name_f'],"readonly = 'true'");
clearfix();
formLabel("","Patient Last Name");
formInput("","text",$patInfo['name_l'],"readonly = 'true'");
clearfix();
formLabel("","Patient Date Of Birth");
formInput("","text",$patInfo['dob'],"readonly = 'true'");
clearfix();
hr();
hr();
$rBy = dataGet("*","users","id",$uInfo['id']);
$rBy = $rBy[0];
$rbf = $rBy['name_f'];
$rbl = $rBy['name_l'];
formLabel("cancelled_by","Update Reason/Requested by");
//formInput("canceled_by","text",$rbf . " " . $rbl,"readonly = 'true'");
 formInput("canceled_by","text","","id = 'cancelledBy'");
clearfix();

$reqDate = date("m/d/y h:i A");
formLabel("date_cancel_requested","Date Of Request");
formInput("cancel_date","text",$reqDate,"readonly = 'true'");
clearfix();

formLabel('sendEmail','Update this Appointment');
formInput('iAgree','checkbox','ON',"id = 'iAgree'");
clearfix();


clearfix();
formInput('submit','submit','Submit Update Request','id="submit" class = "nextButton"');

formClose();
	
clearfix();




?>




	</div> <!-- aptForm -->
</div> <!-- siteWrap -->
<script>
function validateForm(){
	var $count = 0;
	var $cb = document.getElementById('cancelledBy').value;
	var $agree = document.getElementById('iAgree').checked;
	var $string = ' ';
	if($cb == ''){
		$string=$string+' You must sign your name in the "Update Requested By" field. ';
		$count++;
		document.getElementById('cancelledBy').style.backgroundColor="#FFCCCC";
	}
	if($agree == false){
		$string=$string+' You must check the box next to "Cancel This Appointment". ';
		$count++;
		document.getElementById('iAgree').style.backgroundColor="#FFCCCC";
	}
	if($count > 0){
		alert("Please correct the following: "+$string); 
		return false;
	}
	
}
</script>

<?php
require("scripts.php");
?>


</body>
</html>


