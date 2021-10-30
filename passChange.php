<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
$patient = $_GET['p'];
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
		Choose A New Password
		<?php
		echo $patient;
		?>
		</div>
<?php
//formForm('proc/deletePatient.php','post','onsubmit = "return confirmDelete();"');
formForm('proc/passChange.php','post','onsubmit = "return passMatch();"');
formLabel('pass1',"Enter A New Password");
formInput('pass1','password','','id = "pass1"');
clearfix();
formLabel('pass2',"Repeat Password");
formInput('pass2','password','','id = "pass2"');
clearfix();
formLabel('',"&nbsp;");
formInput('','submit','Submit');
clearfix();
?>




	</div> <!-- aptForm -->
</div> <!-- siteWrap -->

<script>
function passMatch(){
	var $p1 = document.getElementById('pass1').value;
	var $p2 = document.getElementById('pass2').value;
	//alert($p1+" - "+$p2);
	if($p1 != $p2){
		alert("Passwords Do Not Match");
		return false;
	}
}

</script>
<?php
//require("scripts.php");
?>


</body>
</html>
