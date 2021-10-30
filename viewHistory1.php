<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
?>
<!doctype HTML>
<html>
<head>
<style>
.tabs{
	text-align:left;
	width:100%;
	height:30px;
}

.tabs a{
	padding: 3px 10px 3px 10px;
	border-top:1px solid #000000;
	border-left:1px solid #000000;
	border-right:1px solid #000000;
	background-color:#DDFFDD;
}

.tabs a:hover{
	background-color:#BBFFBB;
}

#export{
display:inline-block;
}

.redButton{
	background-color:#FF5555;
	color:#FFFFFF;
	padding:3px 5px 3px 5px;
	font-size:.8em;
	border:1px solid #000000;
}

#patientString{
display:none;
}
</style>

<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.datepick.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>

<script>
jQuery(function($){
   $("#patientDOB").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
//   $("#phone").mask("(999) 999-9999");
//   $("#tin").mask("99-9999999");
//   $("#ssn").mask("999-99-9999");
});
</script>

<script>
$(function() {
	//$('#popupDatepicker').datepick();
	$('#dateFrom').datepick({onSelect: showDate});
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

$(function() {
	//$('#popupDatepicker').datepick();
	$('#dateTo').datepick({onSelect: showDate});
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

$(function() {
	//$('#popupDatepicker').datepick();
	$('#reqdateFrom').datepick({onSelect: showDate});
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

$(function() {
	//$('#popupDatepicker').datepick();
	$('#reqdateTo').datepick({onSelect: showDate});
	$('#inlineDatepicker').datepick({onSelect: showDate});
});
function showDate(date) {
	//alert('The date chosen is ' + date);
	newFilter("null");
}
</script>




<title> Itasca</title>
<?php
require("{$legos}/head.php");
?>
<?php

	
	$tp = $_GET['tp'];
	
echo "<body onload = \"forcePat('{$tp}');\">";
?>


<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>


<div class = 'siteWrap'>


	<div class = 'tableDisplay'>
		<div class = 'formTitle'>
		View Appointment History 
		<?php
			echo " {$tp} ";
		?>
		</div>
<?php
//print_r($uInfo);hr();
// this is the filter
echo "<div id = 'filter'>";
echo "<table width = '100%'";
echo "<tr>";
echo "<th> Status &nbsp; &nbsp; &nbsp; ";
	echo "<button onClick = 'doClear(this.id);' id = 'clStatus' class = 'clearButton'> Clear </button>";
echo " </th>";
echo "<th> ASAP </th>";

echo "<th> From Date </th>";
echo "<th> To Date </th>";

//echo "<th> Language </th>";


	echo "<th> Facility </th>";

if($uInfo['role'] < 4){ // only if they have a choice
	echo "<th> Clinic </th>";
}

echo "</tr>";
echo "<tr>";
/// BREAK HERE



echo "<tr>";

// status
echo "<td>";
	echo "<table>";
	echo "<tr>";
	echo "<th> New </th>";
	echo "<th> Pending </th>";
	echo "<th> Confirmed </th>";
	echo "<th> Denied </th>";
	echo "<th> Cancel Reuqested </th>";
	echo "<th> Cancelled </th>";
	echo "<th> &nbsp; </th>";
	echo "</tr>";
// tablebreak	
	echo "<tr>";
	echo "<td>";
	formInput("statusNEW","checkbox","NEW","id = 'statusNEW' onchange = newFilter(this.id)");
	echo "</td>";
	echo "<td>";
	formInput("statusPEN","checkbox","NEW","id = 'statusPEN' onchange = newFilter(this.id)");
	echo "</td>";
	echo "<td>";
	formInput("statusCON","checkbox","NEW","id = 'statusCON' onchange = newFilter(this.id)");
	echo "</td>";
	echo "<td>";
	formInput("statusDEN","checkbox","NEW","id = 'statusDEN' onchange = newFilter(this.id)");
	echo "</td>";
	echo "<td>";
	formInput("statusCRQ","checkbox","NEW","id = 'statusCRQ' onchange = newFilter(this.id)");
	echo "</td>";
	echo "<td>";
	formInput("statusCAN","checkbox","NEW","id = 'statusCAN' onchange = newFilter(this.id)");
	echo "</td>";
		
	echo "</tr>";
	echo "</table>";
	
	// ASAP
	echo "<td>";
		formInput("asap","checkbox","YES","id = 'asap' onchange = newFilter(this.id)");
	echo "</td>";
// date range
echo "<td>";
	echo "<table>";
	echo "<tr><td>";
		formInput("dateFrom","text",$today,"id = 'dateFrom' size = '8' ");
	echo "</td></tr><tr><td>";
		echo "<button onClick = 'doClear(this.id);' id = 'clFromDate' class = 'clearButton'> Clear </button>";
	echo "</td></tr></table>";
echo "</td>";
echo "<td>";
	echo "<table>";
	echo "<tr><td>";
		formInput("dateTo","text","ANY","id = 'dateTo' size = '8' ");
	echo "</td></tr><tr><td>";	
		echo "<button onClick = 'doClear(this.id);' id = 'clToDate' class = 'clearButton'> Clear </button>";
	echo "</td></tr></table>";
echo "</td>";




// facility dropdown

if($uInfo['role'] == 1 || $uInfo['role'] == 2 ){ // if there is a choice
	$sql = "SELECT id, title FROM facilities ";
	echo "<td>";
	$go = mysql_query($sql);
	echo "<select name = 'facility' id = 'facility' onchange = 'newFilter(this.id);'>";
	echo "<option value = 'ANY'> ANY </option>";
	while ($row = mysql_fetch_assoc($go)){
		echo"<option value = '{$row['id']}'> {$row['title']} </option>";
	}		
	echo "</select>";
	echo "</td>";
} else {
	echo "<input type = 'hidden' id = 'facility' name = 'facility' value = '{$uInfo['facility']}'>";
	echo "<td> {$uInfo['facility']} </td>"; // FIX this with name;
}

// clinic Dropdown
if($uInfo['role'] == 1 || $uInfo['role'] == 2 || $uInfo['role'] == 3){ // if there is a choice
	$sql = "SELECT id, title FROM clinics ";
	if($uInfo['role'] == 3){ // managers only get their own clinic
		$sql .= " WHERE clinic_id = '{$uInfo['facility']}' ";
	}
	echo "<td>";
	$go = mysql_query($sql);
	echo "<select name = 'clinic' id = 'clinic' onchange = 'newFilter(this.id);'>";
	echo "<option value = 'ANY'> ANY </option>";
	while ($row = mysql_fetch_assoc($go)){
		echo"<option value = '{$row['id']}'> {$row['title']} </option>";
	}		
	echo "</select>";
	echo "</td>";
} 



echo "</tr>";
// /////////////////////////////////////////
// /////////////////////////////////////////
// /////////////////////////////////////////
echo "<tr>";
echo "<th> Patient Search Paramenters</th>";
echo "<th> Apt ID </th>";
echo "<th> Req Date From </th>";
echo "<th> Req Date To </th>";
echo "<th> Interpreter</th>";
echo "<th> Interpreter Confirmed </th>";
echo "</tr>";
// /////////////////////////////////////////
// /////////////////////////////////////////
// /////////////////////////////////////////
// patients
echo "<tr>";
echo "<td style = 'text-align:center;'>";
echo "<table>";
	echo "<tr>";
		echo "<th> First Name </th>";
		echo "<th> Last Name </th>";
		echo "<th> DOB </th>";
		//echo "<th> Pat ID </th>";
	echo "</tr>";    /////////////////////////////// NEW PATIENT SEARCH SYSTEM /////////////////////////////////////////////////////////////////
	echo "<tr>"; // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo "<td><input type='text' size = '20' name='patientFname' id = 'patientFname' onBlur = 'newPatSearch(this.id);'></td>"; ///////////////
		echo "<td><input type='text' size = '20' name='patientLname' id = 'patientLname' onBlur = 'newPatSearch(this.id);'></td>"; ///////////////
		echo "<td><input type='text' size = '15' name='patientDOB' id = 'patientDOB' onBlur = 'newPatSearch(this.id);'></td>";  //////////////////
		echo "<input type='hidden' name='patientID' id = 'patientID' onBlur = 'newFilter(this.id);' value = '{$tp}'>";  ////////////////////
	echo "</tr>"; // ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo "</table>";



//echo "<input type='text' size = '40' name='patientName' class='autoPatient' id = 'patient' onBlur = 'newFilter(this.id);'>";
echo "</td>";






// ID
echo "<td>";
echo "<input type='text' name='aptId' id = 'aptId' value='' size = '3' onBlur = 'newFilter(this.id);'>";
echo "</td>";


//reqDateFrom
echo "<td>"; //////////////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<table>"; ///////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<tr><td>"; //////////////////////////////////////////////////////////////////////////////////////////////////////
		formInput("reqdateFrom","text","ANY","id = 'reqdateFrom' size = '8' "); ///////////////////////////////////////////
	echo "</td></tr><tr><td>"; ////////////////////////////////////////////////////////////////////////////////////////////
		echo "<button onClick = 'doClear(this.id);' id = 'clreqFromDate' class = 'clearButton'> Clear </button>"; /////////
	echo "</td></tr></table>"; ////////////////////////////////////////////////////////////////////////////////////////////
echo "</td>"; /////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reqDateTo                                        REQUESTED DATES                                                 ////////
echo "<td>"; //////////////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<table>"; ///////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<tr><td>"; //////////////////////////////////////////////////////////////////////////////////////////////////////
		formInput("reqdateTo","text","ANY","id = 'reqdateTo' size = '8' "); ///////////////////////////////////////////////
	echo "</td></tr><tr><td>"; ////////////////////////////////////////////////////////////////////////////////////////////
		echo "<button onClick = 'doClear(this.id);' id = 'clreqToDate' class = 'clearButton'> Clear </button>"; ///////////
	echo "</td></tr></table>"; ////////////////////////////////////////////////////////////////////////////////////////////
echo "</td>"; /////////////////////////////////////////////////////////////////////////////////////////////////////////////


// interpreter
echo "<td>";
echo "<input type='text' name='interpreterReq' id = 'interpreter' value='' size = '20' class='autoInterp' onBlur = 'newFilter(this.id);'>";
echo "</td>";

echo "<td>";
echo "<input type='text' name='interpreterConf' id = 'interpreterConfirmed' value='' size = '20' class='autoInterp' onBlur = 'newFilter(this.id);'>";
echo "</td>";



echo "</tr>";

echo "</table>";

echo "</div>";
clearfix();
hr();


// ////////////////////////////////
// TABS!!!
// ////////////////////////////////
echo "<div class = 'tabs'>";
echo "<a id = 'tabNewPen' onclick = 'tabSwitch(this.id)'> New, Pending and Cancelation Requests </a>";
echo "<a id = 'tabConf' onclick = 'tabSwitch(this.id)'> Confirmed </a>";
echo "<a id = 'tabDenCan' onclick = 'tabSwitch(this.id)'> Denied and Canelled </a>";


// export

//export feedback
if($uInfo['role'] == 1 || $uInfo['role'] == 2){
	

	echo " &nbsp; Name Of File <input type = 'text' size = '10' id = 'fileName'>";
	echo "<button onclick = 'exportCSV();' id = 'expRemove'> Export This Result To CSV (MS Excel) </button>";
	echo "<div id = 'export'></div>"; // place for expoert button.
	

}
// clear all
echo "&nbsp; &nbsp; &nbsp;<button onClick = 'doClear(\"all\");' class = 'clearButton'> Clear All</button>";

echo "</div>";


clearfix();
//hr();
//echo "<div id = 'temp'>TEST</div>";
//hr();

// here we swap stuff using jax.

echo "<div id = 'appointmentTable'>";
include("proc/appointmentFilter3.php"); // also the Ajax thing? probably.
echo "</div>";
?>

	</div> <!-- aptForm -->
</div> <!-- siteWrap -->


<?php
require("scripts.php");
?>

<script>
function newFilter($str){

	
	//the status checkboxes
	var $statNew = document.getElementById("statusNEW").checked;
	var $statPen = document.getElementById("statusPEN").checked;
	var $statCon = document.getElementById("statusCON").checked;
	var $statDen = document.getElementById("statusDEN").checked;
	var $statCrq = document.getElementById("statusCRQ").checked;
	//alert($statCrq);
	var $statCan = document.getElementById("statusCAN").checked;
	// ASAP
	var $asap = document.getElementById("asap").checked;
	if($asap == true){
		$asap = 'YES';
	} else {
		$asap = 'ANY';
	}
	var $facility = document.getElementById("facility").value;
	var $clinic = document.getElementById("clinic").value;
	// the date range
	var $dateFrom = document.getElementById("dateFrom").value;
	var $dateTo = document.getElementById("dateTo").value;
	// the req date range
	var $rDateFrom = document.getElementById("reqdateFrom").value
	var $rDateTo = document.getElementById("reqdateTo").value
	// patient
	//var $patientString = document.getElementById("patient").value;
	//if($patientString != ''){
	//	$patient = $patientString.split(" ");
	//	var $patient = $patientString[0];
	//} else {
	//	var $patient = 'ANY';
	//}
	// New patient search 
//	var $pFn = document.getElementById("patientFname").value;
//	var $pLn = document.getElementById("patientLname").value;
//	var $pDob = document.getElementById("patientDOB").value;
	var $pId = document.getElementById("patientID").value;

	
	
	var $intString = document.getElementById("interpreter").value;
	if($intString != ''){
		$interpSplit = $intString.split("(");
		var $interp = $interpSplit[1];
		var $interpreter = $interp.replace(')','');
		//var $interpreter = 'TEST';
	} else {
		var $interpreter = 'ANY';
	}
	//int conf
	var $interpConf= document.getElementById("interpreterConfirmed").value;
	if($interpConf != ''){
		$interpCSplit = $interpConf.split("(");
		var $interpC = $interpCSplit[1];
		var $intConf = $interpC.replace(')','');
	} else {
		var $intConf = 'ANY';
	}
	// id
	var $aptId = document.getElementById("aptId").value;
	var $getString = "status-1="+$statNew+"&status-2="+$statPen+"&status-3="+$statCon+"&status-4="+$statDen+"&status-5="+$statCan+"&status-6="+$statCrq;
	$getString = $getString+"&apt_date-FROM="+$dateFrom+"&apt_date-TO="+$dateTo+"&facility="+$facility+"&clinic="+$clinic;
	$getString = $getString+"&patient="+$pId;
	$getString = $getString+"&req_date-FROM="+$rDateFrom+"&req_date-TO="+$rDateTo; // req date
	$getString = $getString+"&interpreter_req="+$interpreter+"&interpreter_confirmed="+$intConf+"&id="+$aptId+"&asap="+$asap;
///// JAXY


	//var $current = 'TEST12';
	// jax the next part in.
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		//	alert("READY "+xmlhttp.readyState+" status "+xmlhttp.status);
			document.getElementById("appointmentTable").innerHTML=xmlhttp.responseText;
		} else {
		//	alert("NOT READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		}
	} 
	xmlhttp.open("GET","proc/appointmentFilter3.php?"+$getString,true);
	xmlhttp.send();
	
	//alert("BLAH");
}





function doClear($str){
	if ($str == 'clStatus'){
		document.getElementById("statusNEW").checked = false;
		document.getElementById("statusPEN").checked = false;
		document.getElementById("statusCON").checked = false;
		document.getElementById("statusDEN").checked = false;
		document.getElementById("statusCAN").checked = false;
		document.getElementById("statusCRQ").checked = false;
	}
	
	if($str == 'clFromDate'){
		document.getElementById("dateFrom").value = 'ANY';
	}
	
	if($str == 'clToDate'){
		document.getElementById("dateTo").value = 'ANY';
	}
	
	if($str == 'clreqToDate'){
		document.getElementById("reqdateTo").value = 'ANY';
	}
	
	if($str == 'clreqFromDate'){
		document.getElementById("reqdateFrom").value = 'ANY';
	}
	if($str == 'all'){
		document.getElementById("statusNEW").checked = false;
		document.getElementById("statusPEN").checked = false;
		document.getElementById("statusCON").checked = false;
		document.getElementById("statusDEN").checked = false;
		document.getElementById("statusCAN").checked = false;
		document.getElementById("statusCRQ").checked = false;
		document.getElementById("dateFrom").value = 'ANY';
		document.getElementById("dateTo").value = 'ANY';
		document.getElementById("reqdateTo").value = 'ANY';
		document.getElementById("reqdateFrom").value = 'ANY';
		document.getElementById("patientFname").value = '';
		document.getElementById("patientLname").value = '';
		document.getElementById("patientDOB").value = '';
	//	document.getElementById("patientID").value = '';
	}

	newFilter('cleared');
}

/*echo "<a id = 'tabNewPen' onclick = 'tabSwitch(this.id)'> New and Pending </a>";
echo "<a id = 'tabConf' onclick = 'tabSwitch(this.id)'> Confirmed </a>";
echo "<a id = 'tabDenCan' onclick = 'tabSwitch(this.id)'> Denied and Canelled </a>";*/





function newPatSearch($str){
	//alert("working"+$str);
	var $pFn = document.getElementById("patientFname").value;
	var $pLn = document.getElementById("patientLname").value;
	var $pDob = document.getElementById("patientDOB").value;
	var $curID = document.getElementById("patientID").value;
	// JAXY
	var $getString = "fn="+$pFn+"&ln="+$pLn+"&dob="+$pDob;
	//alert($getString);
	//alert("WHAT");
	
	
	
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
			document.getElementById("patientID").value=xmlhttp.responseText;
			//document.getElementById("temp").innerHTML=xmlhttp.responseText;
			newFilter('pSearch');
		} else {
			//alert("NOT READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		}
	} 
	xmlhttp.open("GET","proc/findPatients.php?"+$getString,true);
	xmlhttp.send();
	
	
	
	
	
	
	
	
	
}









function tabSwitch($str){
	if($str == 'tabNewPen'){
		document.getElementById("statusNEW").checked = true;
		document.getElementById("statusPEN").checked = true;
		
		document.getElementById("statusCON").checked = false;
		document.getElementById("statusDEN").checked = false;
		document.getElementById("statusCRQ").checked = true;
		document.getElementById("statusCAN").checked = false;
	}
	
	if($str == 'tabConf'){
		document.getElementById("statusNEW").checked = false;
		document.getElementById("statusPEN").checked = false;
		document.getElementById("statusCON").checked = true;
		document.getElementById("statusDEN").checked = false;
		document.getElementById("statusCRQ").checked = false;
		document.getElementById("statusCAN").checked = false;
	}
	
	if($str == 'tabDenCan'){
		document.getElementById("statusNEW").checked = false;
		document.getElementById("statusPEN").checked = false;
		document.getElementById("statusCON").checked = false;
		document.getElementById("statusDEN").checked = true;
		document.getElementById("statusCRQ").checked = false;
		document.getElementById("statusCAN").checked = true;
	}
	newFilter('tabs');
}

function forcePat($str){
	// force search of patient
	// first force all styatus tabs true
		document.getElementById("statusNEW").checked = true;
		document.getElementById("statusPEN").checked = true;
		document.getElementById("statusCON").checked = true;
		document.getElementById("statusDEN").checked = true;
		document.getElementById("statusCRQ").checked = true;
		document.getElementById("statusCAN").checked = true;
		
		// next insert the correct patient string
		var $getPatient = document.getElementById('patientString').innerHTML;
		//alert($getPatient);
		document.getElementById("patientID").value=$getPatient;
		//var $got = document.getElementById("patient").value;
		//alert($getPatient);
		newFilter('force');
}

// export

function exportCSV(){
	var $str = document.getElementById("reportSQL").innerHTML;
	var $fileName = document.getElementById("fileName").value;
	if($fileName == ''){
		$fileName = 'TEMP';
	}
	var $getString = "sql="+$str+"&fileName="+$fileName;
	//var $getString = "t=TEST";
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("export").innerHTML=xmlhttp.responseText;
		} 
	} 
	xmlhttp.open("GET","proc/exportAppointments.php?"+$getString,true);
	xmlhttp.send();
}



</script>

</body>
</html>

<?php

/*


	
	
	
}

*/


?>
