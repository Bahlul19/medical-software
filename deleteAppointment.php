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

$apt = $_POST['delID'];

?>




<div class = 'siteWrap'>


	<div class = 'aptForm'>
		<div class = 'formTitle'>
		Deleteing Appointment Number 
		<?php
		echo $apt;
		?>
		</div>
<?php
//function dataGet($fieldsArray,$table,$where,$clause){
	// fieldsArray can be an array of fields or "*" 
$appt = dataGet("*","appointment_requests",'id',$apt);


formForm("{$htmlRoot}/proc/deleteAppointment.php",'post','onsubmit="return validateForm();"');
formInput('delID','hidden',$apt);
formLabel("DeletedBy","Deleted By");
formInput('delBy','text',$uInfo['name_f'] . " " . $uInfo['name_l'],'id = "delBy"');
clearfix();
formLabel('delReason','Reason For Deleting');
clearfix();
echo "<textarea name = 'delReason' id = 'delReason'>";
echo "</textarea>";
clearfix();
echo "<input type = 'submit' value = 'Delete This Appointment' class = 'delete' >";
clearfix();

//formLabel('duration','Duration (In Minutes)');
//formInput('duration','text',$appt['duration']);
formClose();

?>



	</div> <!-- aptForm -->
</div> <!-- siteWrap -->
<script>

function validateForm(){
	var $string="Sorry, There was an error. ";
	var $count = 0;
	var $db = document.getElementById('delBy').value;
	var $dr = document.getElementById('delReason').value;
	if($db == ''){
		$count++;
		$string=$string+" You must sign your name in the Deleted By field ";
		document.getElementById('delBy').style.backgroundColor="#FFDDDD";
	}
	
	if($dr == ''){
		$count++;
		$string=$string+" You must provide a reason for deleteing this appointment ";
		document.getElementById('delReason').style.backgroundColor="#FFDDDD";
	}
	
	if($count > 0){
		$string=$string+" Please correct the above errors.";
		alert($string);
		return false; 
	}
}
</script>
<?php
require("scripts.php");
?>


</body>
</html>


