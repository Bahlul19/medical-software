<?php
// Index.php
// Nik Rubenstein -- 12-05-2014
$SECURE = TRUE;
require_once("inc/init.php");

?>
<!doctype HTML>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>

<script>
jQuery(function($){
 //  $("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#phone1").mask("(999) 999-9999");
   $("#phone2").mask("(999) 999-9999");
   $("#fax").mask("(999) 999-9999");
//   $("#tin").mask("99-9999999");
//   $("#ssn").mask("999-99-9999");
});
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
?>

<div class = 'siteWrap'>


	<div class = 'aptForm'>
		<div class = 'formTitle'>
		New Clinic
		</div>
	<?php
	include("{$legos}/reqFields.php");
	hr();
	clearfix();
	?>
	
	<?php
	
	formForm("{$htmlRoot}/proc/newClinic.php",'post','onsubmit="return validateForm();" name = "newClinic" id = "newClinic"');
	
	
	if($uInfo['role'] == 1 || $uInfo['role'] == 2){ // if they are admin or Itasca staff
		// make a dropdown of clinics
		formLabel('clinic','For Facility');
		echo "<oneDrop>";
		formDropdown('clinicID','facilityredo','id','title','Choose A Facility');
		echo "</oneDrop>";
	} else {
		echo "<input type = 'hidden' name = 'clinicID' value = '{$uInfo['facility']}'>";
	
	}
	clearfix();
	hr();
	// Facility info
	formLabel('hqTitle','Clinic Title',true);
	formInput('facTitle','text','','id = "facTitle"');
	clearfix();
	
	// HQ address
	formLabel('adr1','Address 1',true);
	formInput('adr1','text','','id = "adr1"');
	clearfix();
	formLabel('adr2','Address 2');
	formInput('adr2','text','');
	clearfix();
	formLabel('adrCity','City',true);
	formInput('adrCity','text','','id = "adrCity"');
	clearfix();
	formLabel('adrState','State');
	//formInput('adrState','text','');
	echo "<oneDrop>";
	echo "<select name = 'adrState'>";
	require("{$legos}/stateDrop.php");
	echo "</select>";
	echo "</oneDrop>";
	clearfix();
	formLabel('adrZip','Zip Code',true);
	formInput('adrZip','text','','id = "adrZip"');
	// email
	clearfix();
	formLabel('email','Email',true);
	formInput('email','text','','id = "email"');
	//HQ phone numbers
	clearfix();
	formLabel('phone1','Telephone 1',true);
	formInput('phone1','text','','id="phone1"');
	clearfix();
	formLabel('phone2','Telephone 2');
	formInput('phone2','text','','id="phone2"');
	clearfix();
	formLabel('fax','Fax Number');
	formInput('fax','text','','id="fax"');
	clearfix();
	//added note section
	formLabel('note','Note');
	formInput('note','text','','id="note"');
	clearfix();
	
	
	//submit
	formLabel('blank','');
	formInput('submit','submit','Submit');
	//time
	
	clearfix();
?>


	</div> <!-- aptForm -->
	
	<?php
//	print_r($uInfo);
	?>
</div> <!-- siteWrap -->


<script>


function validateForm() { 
	var $count = 0;
	var $ftitle = document.forms["newClinic"] ["facTitle"].value;
	var $adr1 = document.forms["newClinic"] ["adr1"].value;
	var $city = document.forms["newClinic"] ["adrCity"].value;
	var $zip = document.forms["newClinic"] ["adrZip"].value;
	var $email = document.forms["newClinic"] ["email"].value;
	var $phone = document.forms["newClinic"] ["phone1"].value;

	if($ftitle=='' || $ftitle==null){
		$count = $count+1;
		document.getElementById('facTitle').style.backgroundColor='#FFAAAA';
	}
	
	if($adr1=='' || $adr1==null){
		$count = $count+1;
		document.getElementById('adr1').style.backgroundColor='#FFAAAA';
	}
	
	if($city=='' || $city==null){
		$count = $count+1;
		document.getElementById('adrCity').style.backgroundColor='#FFAAAA';
	}
	
	if($zip=='' || $zip==null){
		$count = $count+1;
		document.getElementById('adrZip').style.backgroundColor='#FFAAAA';
	}
	
	if($email=='' || $email==null){
		$count = $count+1;
		document.getElementById('email').style.backgroundColor='#FFAAAA';
	}
	
	if($phone=='' || $phone==null){
		$count = $count+1;
		document.getElementById('phone1').style.backgroundColor='#FFAAAA';
	}
	
	//ret false if any required fields are blank.
	if($count > 0){
		alert("The fields highlighted in red are required.");
		return false;
	}
	
}
</script>




<?php
require("scripts.php");
?>


</body>
</html>


