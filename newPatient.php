<?php
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
   $("#phone").mask("(999) 999-9999");
   $("#second_phone").mask("(999) 999-9999");
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
		New Patient
		</div>
	<?php
	include("{$legos}/reqFields.php");
	hr();
	clearfix();
	?>
	
	<?php
	if($_GET['fs']==1){
		formForm("{$htmlRoot}/proc/newPatient.php?ret=search",'post','onsubmit="return validateForm();" id = "newPatient" ');
	} else {
		formForm("{$htmlRoot}/proc/newPatient.php",'post','onsubmit="return validateForm();" id = "newPatient"');
	}
	
	
	
	
	// clinic if adfmin
	if($uInfo['role'] == 1 || $uInfo['role'] == 2){ // if they are admin or Itasca staff
		// make a dropdown of clinics
		formLabel('facility','For Facility',true);
		echo "<oneDrop>";
		formDropdown('facility_id','facilityredo','id','title','spec','Choose A Facility','','id = "facility_id" onclick="controlDefaultClinic()" onChange="facSwitch(this.value,\'Default Clinic\');"');
		echo "</oneDrop>";
		clearfix();
		echo "<div id = 'myBox'></div>";
	} else {
	//	clearfix();
		formLabel('facility_id','Facility',true);
		echo "<input type = 'text' name = 'facility_id' value = '{$uInfo['facility']}' readonly = 'true' id = 'facility_id'>"; // can only do their own clinic
		clearfix();
		if($uInfo['role'] == '3'){ // can only do theior own fac
			$sql = "SELECT * FROM clinics WHERE clinic_id = '{$uInfo['facility']}' ORDER BY title ASC";
			$go = mysql_query($sql);
			formLabel('clinic',"Clinic");
			echo "<oneDrop>";
			echo "<select name = 'clinic_id'>";
			while($row = mysql_fetch_assoc($go)){
				$thisFac = $row['title'];
				$thisID = $row['id'];
				echo "<option value = '{$thisID}'> {$thisFac} </option>";
			}
			echo "</select>";
			echo "</oneDrop>";
			clearfix();
		} elseif($uInfo['role'] == 4) { // staff auto fill
			//echo "<input type = 'hidden' name = 'facility_id' value = '{$uInfo['facility']}'>";
		}
	
	}
	clearfix();
	hr();
	
	//Name
	formLabel('name_f','First Name',true);
	formInput('name_f','text','','id = "name_f"');
	clearfix();
	formLabel('name_l','Last Name',true);
	formInput('name_l','text','','id = "name_l"');
	clearfix();
	
	//MRN
	formLabel('mrn','MRN');
	formInput('mrn','text','');
	clearfix();
	//gender
	formLabel('gender','Gender',true);
	echo "<oneDrop>";
	$MF = array(
		'N' => 'Please Select',
		'M' => 'Male',
		'F' => 'Female'
	);
	formSelect('gender',$MF,'id = "gender"');
	
	echo "</oneDrop>";
	clearfix();
	//language
	// function formDropdown($name,$table,$fieldV,$fieldW,$default = 'Please Specify', $other = 'other', $params){
	formLabel('langauge','Language',true);
	echo "<oneDrop>";
	//formDropdown('language','languages','id','language','Please Specify A Langauge','Please Specify A Language','Patient Language Is Not Listed',' id = "inputLangauge" onChange="spooky(this.value);"'); // onClick
	// okay manually here.
	echo "<select name = 'language' id = 'inputLanguage' onChange = 'spooky(this.value);'>";
		echo "<option value = 'spec'> Please Specify A Language </option>";
		$lsql = "SELECT id, language FROM languages ORDER BY language ASC";
		$lgo = mysql_query($lsql);
		while($lrow = mysql_fetch_assoc($lgo)){
			$lid = $lrow['id'];
			$ltext = $lrow['language'];
			echo "<option value = {$lid}> $ltext </option>";
		}
		echo "<option value = 'nl'> Patient Language Is Not Listed </option>";
	echo "</select>";
	echo "</oneDrop>";
	clearfix();
	
	// specify unlisted langauge (ajaxed in)
	echo "<span id = 'newLanguage'>";
//	formLabel('','Please Specify A Langauge',true);
//	formLabel('','In the comments section of the first appointment',true);
	echo "</span>";
	clearfix();
	
	// Prefered Interp
	formLabel('prefered_interpreter','Preferred Interpreter');
	formInput('prefered_interpreter','text','');
	clearfix();

	//provider name 
	/*
	formLabel('provider_name','Provider Name');
	formInput('provider_name','text','');
	clearfix();
	*/

	
	// DOB info
	formLabel('dob','Date Of Birth',true);
	echo "<triselect>";
	formSelect ('dobM','1:January,2:February,3:March,4:April,5:May,6:June,7:July,8:August,9:September,10:October,11:November,12:December');
	formSelect('dobD','1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31');
	$yrs = '1900';
	//not typing over 100 years... for 1900 to 2014
	$thisYear = date("Y");
	$thisYear++;
	//$tenYears= $thisYear+10;
	for($x=1901;$x<$thisYear;$x++){
		$yrs .= ",{$x}";
	}
	formSelect('dobY',"$yrs");
	echo "</triselect>";
	clearfix();
	
	// address
	formLabel('addr_1','Address 1',true);
	formInput('addr_1','text','','id = "addr_1"');
	clearfix();
	formLabel('addr_2','Address 2');
	formInput('addr_2','text','');
	clearfix();
	formLabel('addr_city','City',true);
	formInput('addr_city','text','','id = "addr_city"');
	clearfix();
	formLabel('addr_state','State');
	//formInput('addr_state','text','');
	echo "<oneDrop>";
	echo "<select name = 'addr_state'>";
	require("{$legos}/stateDrop.php");
	echo "</select>";
	echo "</oneDrop>";
	clearfix();
	formLabel('addr_zip','Zip Code',true);
	formInput('addr_zip','text','','id = "addr_zip"');
	clearfix();
	
	//insurance
	formLabel('phone','Telephone',true);
	// $("#phone").mask("(999) 999-9999");
	formInput('phone','text','','id = "phone"');
	clearfix();

	formLabel('second_phone','Second Telephone',false);
	// $("#phone").mask("(999) 999-9999");
	formInput('second_phone','text','','id = "second_phone"');
	clearfix();

	formLabel('email','Email');
	formInput('email','email','');
	clearfix();
	
	// phone numbers
	formLabel('ins_provider', 'Insurance Provider',true);
	echo "<oneDrop>";
	formDropdown('insurance_provider','insurance_providers','id','title','spec','Please Specify','other','id="insurance_provider"');
	echo "</oneDrop>";
	clearfix();
	formLabel('insurance_id','Insurance ID');
	formInput('insurance_id','text','');
	clearfix();

    clearfix();
	formLabel('note','Note');
	formTextArea('notes','10','','30','id = "notes"','class = "notes"');
	clearfix();
	
	
	
	
	
	
	//submit
	formLabel('blank','');
	formInput('submit','submit','Submit');
	//time
	
	clearfix();
	
	formClose();
?>


	</div> <!-- aptForm -->
</div> <!-- siteWrap -->

<script>
var controlDefaultClinic = function() {
    var $for_facility = document.getElementById("facility_id").value;
    var $for_default_clinic = document.getElementById("fClinic").value;
    if($for_facility == "spec" || $for_facility == "other") {
        document.getElementById("myBox").style.display = "none";
        document.querySelector('option[value=spec]').selected = true;
    } else{
        document.getElementById("myBox").style.display = "block";
    }
};
function validateForm() { 
	
	var $count = 0;
	var $facility = document.forms["newPatient"] ["facility_id"].value;
	console.log($facility);
	//var $spec = 'spec';
	//alert($facility);
	var $fname = document.forms["newPatient"] ["name_f"].value; // X
	var $lname = document.forms["newPatient"] ["name_l"].value; // X
	var $gen = document.forms["newPatient"] ["gender"].value; // N //
	var $lang = document.forms["newPatient"] ["language"].value; //'Please Specify A Langauge' //
	var $insuranceProvider = document.forms["newPatient"] ["insurance_provider"].value;

	//newLanguage
	//var $langN = document.forms["newPatient"] ["newLanguage"].value;
	// dob
	var $dobm = document.forms["newPatient"] ["dobM"].value;
	var $dobd = document.forms["newPatient"] ["dobD"].value;
	var $doby = document.forms["newPatient"] ["dobY"].value;
	
	var $adr1 = document.forms["newPatient"] ["addr_1"].value; // 
	var $city = document.forms["newPatient"] ["addr_city"].value; // 
	var $zip = document.forms["newPatient"] ["addr_zip"].value; // 
	var $phone = document.forms["newPatient"] ["phone"].value; //

/*	if($ftitle=='' || $ftitle==null){
		$count = $count+1;
		document.getElementById('facTitle').style.backgroundColor='#FFAAAA';
	}
	*/
	
	if($facility=='spec' || $facility==null){
		$count = $count+1;
		document.getElementById('facility_id').style.backgroundColor='#FFAAAA';
	}
	
	if($fname=='' || $fname==null){
		$count = $count+1;
		document.getElementById('name_f').style.backgroundColor='#FFAAAA';
	}
	
	if($lname=='' || $lname==null){
		$count = $count+1;
		document.getElementById('name_l').style.backgroundColor='#FFAAAA';
	}
	
	if($gen=='N'){
		$count = $count+1;
		document.getElementById('gender').style.backgroundColor='#FFAAAA';
	}
	
	//if($lang =='Please Specify A Langauge' ){ //&& ($langN=='' || $langN==null)){
	//	$count = $count+1;
	//	document.getElementById('inputLanguage').style.backgroundColor='#FFAAAA';
	//}	
	
	if($adr1=='' || $adr1==null){
		$count = $count+1;
		document.getElementById('addr_1').style.backgroundColor='#FFAAAA';
	}
	
	if($city=='' || $city==null){
		$count = $count+1;
		document.getElementById('addr_city').style.backgroundColor='#FFAAAA';
	}
	
	if($zip=='' || $zip==null){
		$count = $count+1;
		document.getElementById('addr_zip').style.backgroundColor='#FFAAAA';
	}
	
	
	if($phone=='' || $phone==null){
		$count = $count+1;
		document.getElementById('phone').style.backgroundColor='#FFAAAA';
	}

	if($insuranceProvider =='spec' ){ 
		$count = $count+1;
		document.getElementById('insurance_provider').style.backgroundColor='#FFAAAA';
	}
	
	//ret false if any required fields are blank.
	if($count > 0){
		alert("The fields highlighted in red are required.");
		return false;
	}
	

}

</script>

<script>
function spooky($str){
//	alert($str);
	if($str == 'nl'){
		document.getElementById("newLanguage").innerHTML="<label for 'newLanguage' style = 'color:#009900;'> Please Specify A Language </label> <label style = 'color:#009900;'> In The Comments Section In The Request </label>";
	} else {
		document.getElementById("newLanguage").innerHTML="";
	}
	
}

</script>


<?php
require("scripts.php");
?>


</body>
</html>


