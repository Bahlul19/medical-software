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


	<!-- <div class = 'aptForm appointment-edit'> -->
		<div class = 'aptForm'>
		<div class = 'formTitle'>
		Add Signature for users
		<?php
		echo $apt;
		?>
		</div>

		<?php

		formForm("{$htmlRoot}/proc/appointmentEditor.php",'post','onsubmit="return validateForm();"');

			formLabel('signature','Upload Your Signature',true);
			formInput('signature','file','','id = "email"');
			clearfix();
			
			formLabel('blank','');
			formInput('submit','submit','Submit');
		//time
	
			clearfix();
		?>

	</div>
</div>
</body>
</head>