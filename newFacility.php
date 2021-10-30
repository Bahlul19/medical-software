<?php
// Index.php
// Nik Rubenstein -- 11-26-2014
$SECURE = TRUE;
require_once("inc/init.php");
?>
<!doctype HTML>
<html>
<head>
<link href="css/jquery.datepick.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>

<script>
jQuery(function($){
 //  $("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#telephone1").mask("(999) 999-9999");
   $("#telephone2").mask("(999) 999-9999");
   $("#faxnumber").mask("(999) 999-9999");
//   $("#tin").mask("99-9999999");
//   $("#ssn").mask("999-99-9999");
});
</script>
<script src="js/jquery.datepick.js"></script>
<script>
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

function showDate(date) {
	
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
?>

<div class = 'siteWrap'>


	<div class = 'aptForm'>
		<div class = 'formTitle'>
		New Facility
		</div>
	<?php
	include("{$legos}/reqFields.php");
	hr();
	clearfix();
	?>
	<?php
	
	formForm("{$htmlRoot}/proc/newFacility.php",'post','onsubmit="return validateForm();" name = "newClinic"');
	
	
	//date
	
	//clinic title

	//Facility title 24-12-2018

	formLabel('title','Facility Title',true);
	formInput('title','text','','id = "title"');
	clearfix();


	//Headquater Tittle 24-12-2018

	formLabel('headquaters_clinic','Headquarters Clinic',true);
	formInput('headquaters_clinic','text','','id = "headquaters_clinic"');
	clearfix();

    /*formLabel('headquaters_clinic','Headquarters Clinic');
	echo "<oneDrop>";
    // function formDropdown($name,$table,$fieldV,$fieldW,$defaultValue = 'spec',$default = 'Please Specify', $other = 'other',$params){
	formDropdown('headquaters_clinic','clinics','id','title','spec','Choose A Clinic','','');
	echo "</oneDrop>";
	clearfix();*/

	//Address1 24-12-2018

	formLabel('address1','Address 1',true);
	formInput('address1','text','','id = "address1"');
	clearfix();


	//Address2 24-12-2018

	formLabel('address2','Address 2');
	formInput('address2','text','','id = "address2"');
	clearfix();

	//AddressCity 24-12-2018

	formLabel('city','City',true);
	formInput('city','text','','id = "city"');
	clearfix();



	//State 24-12-2018

	formLabel('state','State');
	//formInput('adrState','text','');
	echo "<oneDrop>";
	echo "<select name = 'state'>";
	require("{$legos}/stateDrop.php");
	echo "</select>";
	echo "</oneDrop>";
	clearfix();


	//Zip 24-12-2018

	formLabel('zip','Zip Code',true);
	formInput('zip','text','','id = "zip"');
	clearfix();


	//Email 24-12-2018


	formLabel('email','Email',true);
	formInput('email','text','','id = "email"');
	clearfix();


	//Telephone 1 24-12-2018	

	formLabel('telephone1','Telephone 1',true);
	formInput('telephone1','text','','id = "telephone1"');
	clearfix();


	//Telephone 2 24-12-2018	

	formLabel('telephone2','Telephone 2');
	formInput('telephone2','text','','id = "telephone2"');   
	clearfix();


	//Fax  24-12-2018	

	formLabel('faxnumber','Fax Number');
	formInput('faxnumber','text','','id = "faxnumber"');
	clearfix();


	//Contracted Date 24-12-2018

	formLabel('popupDatepicker','Contracted Date');
	formInput('contracted_date','text','','readonly="true" id="popupDatepicker" onblur="checkBook();"');
	clearfix();

	clearfix();


	clearfix();

	//Auhtorized By 24-12-2018

	formLabel('authorized_by','Authorized  By');
	formInput('authorized_by','text','','id = "authorized_by"');
	clearfix();

	formLabel('blank','');
	formInput('submit','submit','Submit');
	//time
	
	clearfix();
?>


	</div> <!-- aptForm -->
</div> <!-- siteWrap -->


<script>
function validateForm() { 
	var $count = 0;
	/*var $ctitle = document.forms["newClinic"] ["clinicTitle"].value;
	var $hqtitle = document.forms["newClinic"] ["hqTitle"].value;
	var $adr1 = document.forms["newClinic"] ["adr1"].value;
	var $city = document.forms["newClinic"] ["adrCity"].value;
	var $zip = document.forms["newClinic"] ["adrZip"].value;
	var $email = document.forms["newClinic"] ["email"].value;
	var $phone = document.forms["newClinic"] ["phone1"].value;*/


	var $ctitle = document.getElementById("title").value;
	var $hqtitle = document.getElementById("headquaters_clinic").value;
	var $adr1 = document.getElementById("address1").value;
	var $city = document.getElementById("city").value;
	var $zip = document.getElementById("zip").value;
	var $email = document.getElementById("email").value;
	var $phone = document.getElementById("telephone1").value;
	
	if($ctitle=='' || $ctitle==null){
		$count = $count+1;
		document.getElementById('title').style.backgroundColor='#FFAAAA';
	}
	
	if($hqtitle=='' || $hqtitle==null){
		$count = $count+1;
		document.getElementById('headquaters_clinic').style.backgroundColor='#FFAAAA';
	}

	if($adr1=='' || $adr1==null){
		$count = $count+1;
		document.getElementById('address1').style.backgroundColor='#FFAAAA';
	}
	
	if($city=='' || $city==null){
		$count = $count+1;
		document.getElementById('city').style.backgroundColor='#FFAAAA';
	}
	
	if($zip=='' || $zip==null){
		$count = $count+1;
		document.getElementById('zip').style.backgroundColor='#FFAAAA';
	}
	
	if($email=='' || $email==null){
		$count = $count+1;
		document.getElementById('email').style.backgroundColor='#FFAAAA';
	}
	
	if($phone=='' || $phone==null){
		$count = $count+1;
		document.getElementById('telephone1').style.backgroundColor='#FFAAAA';
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


