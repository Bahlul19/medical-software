<?php
// Index.php
// Nik Rubenstein -- 11-26-2014
$SECURE = TRUE;
require_once("inc/init.php");
$thisPat = $_SESSION['returnPatient'];
unset($_SESSION['returnPatient']);
if($thisPat == ''){
	$thisPat=$_POST['p'];
}
if($thisPat == ''){
	header("location: searchPatients.php");
}
$p = explode(' ',$thisPat);
	$patID = $p[0];
	$sql = "SELECT facility_id, prefered_interpreter, provider_name FROM patients WHERE id = '{$patID}'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	$patFacId = $row['facility_id'];
	$patPrefInt = $row['prefered_interpreter'];
    //echo $patFacId;

	//new field added for provider name
	//$patProviderName = $row['provider_name'];

	//$providerName = $row['']

	$sql = "SELECT title FROM facilityredo WHERE id = '$patFacId'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	$patFacTitle = $row['title'];
?>
<!doctype HTML>
<html>
<head>
<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

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
<style>
#patsy{
display:none;
}
#overlap{
	display:none;
/*	background-color:#FF00FF;
	color:#000000;
	width:100%;
	height:50px; */
}
</style>


<title> Itasca</title>
<?php
require("{$legos}/head.php");
?>


</head>
<?php
if($thisPat != ''){
	echo "<body onload = 'autoLoadPatient();facSwitch({$patFacId});'>";
} else {
	echo "<body>";
}

require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");

echo "<div id = 'patsy'>";
echo $thisPat;
echo "</div>";
?>

<div class = 'siteWrap'>


	<div class = 'aptForm'>
	<div class = 'formTitle'>
	New Appointment Request
	<?php
	//echo "<a class = 'helpButton2' href = '{$htmnlRoot}/help/newAppointment.php' target = 'blank' ";
	//echo "title = 'Click Here To Open the New Appointment Request help document in a new window or tab' .> ? </a>";
	//print_r($thisPat);
	?>
	</div>
	
	
	<?php
	
	
	formForm("{$htmlRoot}/proc/newAppointment.php",'post',"onsubmit='return validateForm();'");
	
	if($uInfo['role'] == 1 || $uInfo['role'] == 2){ // if they are admin or Itasca staff
		// make a dropdown of clinics
		formLabel('facility','For Facility');
		echo "<oneDrop>";
		formDropdown('facility_id','facilityredo','id','title',$patFacId,$patFacTitle,'','onChange="facSwitch(this.value);" id = "fFacility"');
		echo "</oneDrop>";
		clearfix();
		echo "<div id = 'myBox'></div>";
		
	} else { // managers can select facility but only their own clinic.
		//echo "<input type = 'hidden' name = 'clinicID' value = '{$uInfo['clinic']}'>";
		echo "<input type = 'hidden' name = 'facility_id' id = 'fFacility' value = '{$uInfo['facility']}'>";
		if($uInfo['role'] == '3'){ // managers
			
	
			$sql = "SELECT * FROM clinics WHERE clinic_id = '{$uInfo['facility']}'";
			$go = mysql_query($sql);
			formLabel('Clinic',"Clinic");
			echo "<oneDrop>";
			echo "<select name = 'clinicID' id = 'fClinic'>";
			while($row = mysql_fetch_assoc($go)){
				$thisClin = $row['title'];
				$thisID = $row['id'];
				echo "<option value = '{$thisID}'> {$thisClin} </option>";
			}
			echo "</select>";
			echo "</oneDrop>";
		
		} 
	
	}
	clearfix();
	hr();
	
	//date
	formLabel('popupDatepicker','Appointment Date');
	formInput('aptDate','text','','readonly="true" id="popupDatepicker" onblur="checkBook();"');
	clearfix();
	//time
	formLabel('AptTime','Appointment Time');
	echo "<triselect>";
	formSelect('aptHour','12,1,2,3,4,5,6,7,8,9,10,11','id="timeH" onchange="checkBook();"');
	formSelect('aptMin','00,05,10,15,20,25,30,35,40,45,50,55','id="timeM" onchange="checkBook();"');
	formSelect('aptAmPm','AM,PM','id="timeA" onchange="checkBook();"');
	echo "</triselect>";
	clearfix();
	
	//duration
	formLabel('aptDur','Duration');
	echo "<duration>";
	formSelect('aptDurHour','0,1,2,3,4,5,6,7,8','id = "durH"');
	echo 'hours and ';
	formSelect('aptDurMin','0,15,30,45', 'id = "durM"');
	echo "minutes";
	echo "</duration>";
	clearfix();
	formLabel('department','Department/Procedure');
	echo "<oneDrop>";
	formDropdown('department','departments','id','title','Please Specify A Department','Please Specify A Department','My Department Is Not Listed','onclick="specDepartment();" id = "inputDepartment"');

	echo "</oneDrop>";
	clearfix();

   // Added the new provider name new entry into the site as per new requirement.

	formLabel('ProviderName','Provider Name');
	formInput('ProviderName','text','','id="ProviderName"'); 


	
	// ////////////////////////////////////////////////////////
	echo "<span id = 'newDepartment' style = 'display:none;'>";
	echo "<label for 'newDepartment' style = 'color:#009900;'> Specify An Unlisted Department </label>";
	echo "<oneDrop>";
	//echo "<input type = 'text' name = 'newDepartment' id = 'newDept'>";
	echo "Please specify an unlisted department in the comments section";
	echo "</oneDrop>";
	echo "</span>";
	clearfix();
	//////////////////////////////////////////////////////////
	
	if($uInfo['role'] == 1 || $uInfo['role'] == 2 || $uInfo['role'] == 3){
		
		formLabel('asap','Is This an ASAP/Same Day?');
		echo "<onedrop>";
		formSelect('asap','NO,YES,CC');
		echo "</onedrop>";
		
	}
	clearfix();
	hr();

	
	
	//requested interpreter (Ajax autofill)
//	formLabel('interp','Requested Interpreter');
//	formInput('interp','text','','id = "interp" class = "search"');
	?>
	
	

	
	<!-- <label>Patient Name (search) OR</label> -->
	
	<?php
	echo "<input type='hidden' name='patientName' class='autoPatient' value = '{$thisPat}' id = 'patient' onBlur = 'patientParse(this.value);'>";
	clearfix();
	?>

	<!-- <div class = 'labelButton'> -->
	<?php
	//echo "<a href = '{$htmlRoot}/newPatient.php' target = 'blank'> Create A New Patient </a>";
	?>
	<!-- </div> -->

	
	
	
	<a id = 'patData'></a> <!-- this gets populated -->
	
<!--	<label>Requested Interpreter</label>
	<input type='text' name='interpreterReq' value='' class='autoInterp'> 
	-->
	<?php
	clearfix();
	formLabel('patPrefInt','Preferred Interpreter');
	formInput('patPrefInt','text',$patPrefInt);
	clearfix();

/* Provider Name just comment for new entry as per requirements

	formLabel('patProviderName','Provider Name');
	formInput('patProviderName','text',$patProviderName);
	clearfix();
	hr();
*/
	?>

	<?php
	// clearfix();
	// formLabel('patPrefInt','Preferred Interpreter');
	// formInput('patPrefInt','text',$patPrefInt);
	// clearfix();
	// hr();
	?>
	
	
	<?php
	
	clearfix();
	hr();
	// requested by
	//formInput('reqById','hidden',$uInfo['id']);
	formLabel('reqBy','Requested By');
	formInput('reqBy','text','','id="fReqBy"'); 
	clearfix();
	
	//conf email // FLAG
	formLabel('confEmail','Confirmation Email');
	formInput('confEmail','text',$uInfo['email'],'id = "fEmail"');
	//department // working here.....
	clearfix();
	formLabel('confFax','Confirmation Fax');
	formInput('confFax','text','','id = "fFax"');
	clearfix();
	
	
	
	//formLabel('department','Department');
	//formInput('department','text','');
	
	clearfix();
	
	//req date
	formLabel('reqDate','Date Of Request');
	formInput('reqDate','text',"{$today} {$todayNow}",'readonly = true');
	//submit
	clearfix();
	hr();
	formLabel('comments','Comments');
	clearfix();
	echo "<textarea name = 'comments'>";
	echo "</textarea>";
	formInput('submit','submit','Submit','id="submit"');
	formInput('submit','submit','Save and New (Same Patient)','id="submit"');
	formClose();
	br();
	br();
	clearfix();
	?>



	</div> <!-- aptForm -->
	<div id = 'overlap' ></div> 
</div> <!-- siteWrap -->


<?php
require("scripts.php");
?>


<script type="text/javascript">
//autocomplete Interpreter requested


function autoLoadPatient(){
	var $x = document.getElementById("patsy").innerHTML;
	patientParse($x);
	
}


function validateForm(){

//	alert("ran");
	

	checkBook();
	
//	alert("still ok");
	
	//return false;


	var $fac = document.getElementById("fFacility").value; // "spec" is none;
	var $date = document.getElementById("popupDatepicker").value; // "" is none;
	var $th = document.getElementById("timeH").value; // "" is none;
	var $tm = document.getElementById("timeM").value; // "" is none;
	var $ta = document.getElementById("timeA").value; // "" is none;
	var $datetime = $date+"_"+$th+"_"+$tm+"_"+$ta;
	
	var $durH = Number(document.getElementById("durH").value*60); // convert h to m
	var $durM = Number(document.getElementById("durM").value); // get m
	var $dur = $durH+$durM; // fine.. must exist and be greater than 0;
	var $sig =  document.getElementById("fReqBy").value;
	var $email = document.getElementById("fEmail").value;
	var $fax = document.getElementById("fFax").value;
	var $dept = document.getElementById("inputDepartment").value;//
//	var $nDept = document.getElementById("newDept").value;//
	var $patient = document.getElementById("patient").value;//
	var $trouble = document.getElementById("overlap").innerHTML;
//	alert($trouble);
	
//	alert ("problem not here");
//	return false;

	
	var $count = 0;
	var $string = 'Sorry there was an error. ';
	//alert($nDept);
	if($fac == '0' || $fac == 0){
		$string=$string+" You must specify a facility. ";
		$count++;
		//document.getElementById('lablfacility').style.backgroundColor="#FFCCCC";
		document.getElementById('fFacility').style.backgroundColor="#FFCCCC";
	}
	
	if($date == ''){
		$string=$string+" You must specify a date. ";
		$count++;
		document.getElementById('popupDatepicker').style.backgroundColor="#FFCCCC";
	}
	if($dur == 0){
		$string=$string+" Duration must be greater than 0 minutes. ";
		$count++;
		//document.getElementById('lablaptDur').style.backgroundColor="#FFCCCC";
		document.getElementById('durH').style.backgroundColor="#FFCCCC";
		document.getElementById('durM').style.backgroundColor="#FFCCCC";
	}

	//Please Specify A Department
	if($dept == 'Please Specify A Department'){
		$string=$string+" You must specify a department or procedure. ";
		$count++;
		document.getElementById('inputDepartment').style.backgroundColor="#FFCCCC";
	}
	// specify
	if($dept == 'other'){ //$specify == 'other'
		if($nDept == ''){
		//	alert('Trixy');
			$count++;
			$string=$string+" You must either select an existing department, or specify an unlisted department. ";
			document.getElementById("newDept").style.backgroundColor="#FFCCCC";
		}
	
	}
	
	if($sig == ''){
		$string=$string+" You must type your name in the Requested By field. ";
		$count++;
		document.getElementById('fReqBy').style.backgroundColor="#FFCCCC";
	}
	if($email == ''){
		if ($fax == ''){
			$string=$string+" You must provide either an email address or fax number for confirmation and updates.  ";
			$count++;
			//document.getElementById('lablconfEmail').style.backgroundColor="#FFCCCC";
			document.getElementById('fEmail').style.backgroundColor="#FFCCCC";
			//document.getElementById('lablconfFax').style.backgroundColor="#FFCCCC";
			document.getElementById('fFax').style.backgroundColor="#FFCCCC";
		
		
		}
	}
	
	if($trouble != 'OKAY'){
		$string=$string+" The date and time you selected conflict with "+$trouble+". ";
		$count++;
	}
	
	if($count > 0){
		$string=$string+" Please correct the above issues.";
		$string=$string+" ... ";
		alert($string);
		return false;
	}
//	return false;
	
//	alert("everything ran");

}


function checkBook(){
	//alert("Checking");
	
	
	
	var $fac = document.getElementById("fFacility").value; // "spec" is none;
	var $date = document.getElementById("popupDatepicker").value; // "" is none;
	var $th = document.getElementById("timeH").value; // "" is none;
	var $tm = document.getElementById("timeM").value; // "" is none;
	var $ta = document.getElementById("timeA").value; // "" is none;
	var $durH = Number(document.getElementById("durH").value*60); // convert h to m
	var $durM = Number(document.getElementById("durM").value); // get m
	var $dur = $durH+$durM; // fine.. must exist and be greater than 0;
	var $sig =  document.getElementById("fReqBy").value;
	var $email = document.getElementById("fEmail").value;
	var $fax = document.getElementById("fFax").value;
	var $dept = document.getElementById("inputDepartment").value;//
	var $patient = document.getElementById("patient").value;//
	var $datetime = $date+"_"+$th+"_"+$tm+"_"+$ta;
	
	// now finally, some logic from PHP to determine overlap
	// JAXY
	// gotta send PHP ($user,$field,$start,$dur,$thresh) to work.
	$getString = 'dur='+$dur+"&user="+$patient+"&field=patient&start="+$datetime+"&thresh=60"; //thresh changed to 30
	
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("overlap").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/doubleBook.php?"+$getString,true);
	xmlhttp.send();
	//trouble();
	
	
}


// parse patient 
</script>


<script>
function specDepartment(){
	var $specify = document.getElementById("inputDepartment").value;
	if($specify == 'other'){
		document.getElementById("newDepartment").style.display='inline-block';
	} else {
		document.getElementById("newDepartment").style.display='none';
	}
	
}

</script>
</body>
</html>


