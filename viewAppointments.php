<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
$currentUser = $_SESSION['uInfo']['uname'];
?>
<!doctype HTML>
<html>
<head>

<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
 <script src="js/jquery.tabletoCSV.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.datepick.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>

 <script>

//new code 3-3-19
/*
	$(document).ready(function($){
		 $("#export").click(function(){
		 	$("#export_table").tableToCSV();
		 });
	});
*/
	;(function($){
 		$(document).ready(function(){
		 $("#export").click(function(){
		 	$("#export_table").tableToCSV();
		 });
	});
 	})(jQuery);

	</script>

<script>
/*jQuery(function($){
   $("#patientDOB").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
//   $("#phone").mask("(999) 999-9999");
//   $("#tin").mask("99-9999999");
//   $("#ssn").mask("999-99-9999");
});*/
</script>

<script>
$(function() {
	$("#dateFrom").datepick({
    onSelect: function(dateText) {
      $(this).change();
    }
	}).on("change", function() {
	  newFilter("#dateFrom");
	});

});

$(function() {
	$("#dateTo").datepick({
    onSelect: function(dateText) {
      $(this).change();
    }
	}).on("change", function() {
	  newFilter("#dateTo");
	});
});

$(function() {
	$("#reqdateFrom").datepick({
    onSelect: function(dateText) {
      $(this).change();
    }
	}).on("change", function() {
	  newFilter("#reqdateFrom");
	});
});

$(function() {
	$("#reqdateTo").datepick({
    onSelect: function(dateText) {
      $(this).change();
    }
	}).on("change", function() {
	  newFilter("#reqdateTo");
	});
});
$(function() {
	$("#patientDOB").datepick({
    onSelect: function(dateText) {
      $(this).change();
    }
	}).on("change", function() {
	  newPatSearch("#patientDOB");
	});
});
function showDate(date) {
	newFilter("null");
}
</script>

<title> Itasca</title>
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
	.table-scroll {
		position:relative;
		max-width:100%;
		margin:auto;
		overflow: hidden;
	}
	.table-wrap {
		width:100%;
		overflow:auto;
	}
	.table-scroll table {
		width:100%;
		margin:auto;
		border-collapse:separate;
		border-spacing:2;
	}
	.table-scroll tr {
	    color: #000000;
	    text-align: center;
	    font-family: "Times New Roman", Times, serif;
	}
	.table-scroll th {
	    background-color: #99CCff;
	    color: #000000;
	    font-family: "Times New Roman", Times, serif;
	}
	.table-scroll th, .table-scroll td {
		padding:5px 2px;
		border:1px solid #000;
		white-space:nowrap;
		vertical-align:top;
	}
	.table-scroll td {
		text-align: left;
	}
	.table-scroll thead, .table-scroll tfoot {
		background:#f9f9f9;
	}
</style>

<?php
require("{$legos}/head.php");
?>
<?php

if($_GET['tp']){
	
	$tp = $_GET['tp'];
	unset($_GET['tp']);
 	echo "<body onload = \"forcePat('{$tp}');\">";
 	
 	$pstr = "{$tp}";// {$pd['name_f']} {$pd['name_l']} {$pd['dob']} {$pd['language']}";
 	echo "<div id = 'patientString'>{$pstr}</div>";// style = 'background-color:#ff00ff;color:#FFFFFF;font-size:3em;display:inline-block;'>{$pstr}</div>";
} else {
	echo "<body onload = \"tabSwitch('tabNewPen');\">";
}
?>

<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>

<?php
echo "<div id = 'todaysDate' style = 'display:none;'>{$today}</div>";
?>
<div class = 'siteWrap'>

	<div class = 'tableDisplay'>
		<div class = 'formTitle'>
		View Appointments
		<button id="export" data-export="export">Export</button>
		<!-- <button id="export" onclick="exportCSV()">Export</button> -->
		<?php
			//echo " {$todayHuman}";
		?>
		</div>
<?php
//print_r($uInfo);hr();
// this is the filter
echo "<div id = 'filter'>";
echo "<div id='table-scroll' class='table-scroll'>";
echo "<div class = 'table-responsive table-wrap'>";
echo "<table class='table main-table'";
echo "<thead><tr>";
echo "<th> Status &nbsp; &nbsp; &nbsp; ";
	echo "<button onClick = 'doClear(this.id);' id = 'clStatus' class = 'clearButton'> Clear </button>";
echo " </th>";
echo "<th> ASAP </th>";

echo "<th> From Date </th>";
echo "<th> To Date </th>";

//echo "<th> Language </th>";


	echo "<th> Facility </th>";

//if($uInfo['role'] < 4){ // only if they have a choice
	echo "<th> Clinic </th>";
//}

echo "</tr></thead>
<tbody>
";
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
	echo "<th> Cancel Requested </th>";
	echo "<th> Cancelled </th>";
	echo "<th> Updated </th>";
	echo "<th> Replacement </th>";
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
	echo "<td>";
	formInput("statusUPD","checkbox","NEW","id = 'statusUPD' onchange = newFilter(this.id)");
	echo "</td>";
	echo "<td>";
	formInput("statusREP","checkbox","NEW","id = 'statusREP' onchange = newFilter(this.id)");
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
	$sql = "SELECT id, title FROM facilityredo ORDER BY title";
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
if($uInfo['role'] == 1 || $uInfo['role'] == 2 || $uInfo['role'] == 3 || $uInfo['role'] == 4){ // if there is a choice
	$sql = "SELECT id, title FROM clinics ";//ORDER BY title";
	if($uInfo['role'] == 3 || $uInfo['role'] == 4){ // managers only get their own clinic
		$sql .= " WHERE clinic_id = '{$uInfo['facility']}' ";
	}
	$sql .= " ORDER BY title ";
	echo "<td>";
	$go = mysql_query($sql);//or die(mysql_error());
	//echo $sql;
	
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
echo "<th> Patient Search Parameters</th>";
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
		echo "<th> Language</th>";

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	echo "</tr>";    /////////////////////////////// NEW PATIENT SEARCH SYSTEM ///////////////////////////////////////////////////////////////////
	echo "<tr>"; // //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

		
		echo "<td><input type='text' size = '15' name='patientFname' id = 'patientFname' onBlur = 'newPatSearch(this.id);'></td>"; ///////////////
		echo "<td><input type='text' size = '15' name='patientLname' id = 'patientLname' onBlur = 'newPatSearch(this.id);'></td>"; ///////////////
		//echo "<td><input type='text' size = '10' name='patientDOB' id = 'patientDOB' onBlur = 'newFilter(this.id);'></td>";  //////////////////
		
		echo "<td>";
			formInput("patientDOB","text","mm/dd/yyyy","id = 'patientDOB' size = '8'");
		echo "</td>";	
		
		
		echo "<td>";                                         											//////////////////////////////////////////
		echo "<select id = 'searchLang' name = 'searchLang' onChange = 'newFilter(this.id);'>"; //onchange = 'newPatSearch(this.id);'>"; ///////////////////////////////////////////////
			echo "<option value = 'ANY'> ANY </option>";											//////////////////////////////////////////////
			foreach($languageList as $opVal => $opText){			//////////////////////////////////////////////////////////////////////
			//	echo "<option value = 'test'> TEST </option>";
				echo "<option value = '{$opVal}'> {$opText} </option>"; 	//////////////////////////////////////////////////////////////////////
			}																//////////////////////////////////////////////////////////////////////
		echo "</select>"; 							//////////////////////////////////////////////////////////////////////////////////////////////
		echo "</td>"; 								//////////////////////////////////////////////////////////////////////////////////////////////
		echo "<input type='hidden' name='patientID' id = 'patientID' onBlur = 'newFilter(this.id);'>";  //////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
	
	echo "</tr>"; 
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
		formInput("reqdateFrom","text","ANY","id = 'reqdateFrom' size = '8'"); ///////////////////////////////////////////
	echo "</td></tr><tr><td>"; ////////////////////////////////////////////////////////////////////////////////////////////
		echo "<button onClick = 'doClear(this.id);' id = 'clreqFromDate' class = 'clearButton'> Clear </button>"; /////////
	echo "</td></tr></table>"; ////////////////////////////////////////////////////////////////////////////////////////////
echo "</td>"; /////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reqDateTo                                        REQUESTED DATES                                                 ////////
echo "<td>"; //////////////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<table>"; ///////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<tr><td>"; //////////////////////////////////////////////////////////////////////////////////////////////////////
		formInput("reqdateTo","text","ANY","id = 'reqdateTo' size = '8'"); ///////////////////////////////////////////////
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

echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";


echo "</div>";
clearfix();
hr();

// ////////////////////////////////
// TABS!!!
// ////////////////////////////////
echo "<div class = 'tabs'>";
echo "<a id = 'tabNewPen' onclick = 'tabSwitch(this.id)'> New, Pending and Cancellation Requests </a>";
echo "<a id = 'tabConf' onclick = 'tabSwitch(this.id)'> Confirmed </a>";
echo "<a id = 'tabDenCan' onclick = 'tabSwitch(this.id)'> Denied and Cancelled </a>";

///////////////////////////////////////////////////
///////////////////////////////////////////////////
// export

//export feedback
//if($uInfo['role'] == 1 || $uInfo['role'] == 2){
//	echo " &nbsp; Name Of File <input type = 'text' size = '10' id = 'fileName'>";
//	echo "<button onclick = 'exportCSV();' id = 'expRemove'> Export This Result To CSV (MS Excel) </button>";
//	echo "<div id = 'export'></div>"; // place for expoert button.
//}
/////////////////////////////////////////////////
/////////////////////////////////////////////////


// clear all
echo "&nbsp; &nbsp; &nbsp;<button onClick = 'doClear(\"all\");' class = 'clearButton'> Clear All</button>";

echo "</div>";


clearfix();
//hr();
//echo "<div id = 'temp'>TEST</div>";
//hr();

// here we swap stuff using jax.
echo "<div id='tbl-outer table-scroll' class='table-scroll'>";
echo "<div class = 'table-responsive table-wrap' id='tbl-inner'>";
echo "<div id = 'appointmentTable'>";
//include("proc/appointmentFilter2.php"); // also the Ajax thing? probably.
//echo "<table border = '1' id = 'export_table'>";
//echo "<tr><td>LOADING ...</td></tr>";
//echo "</table>";
echo "<center>LOADING...<br><img src = '{$htmlRoot}/img/loading.gif'><center>";
echo "</div>";
echo "</div>";
echo "</div>";
?>

	</div> <!-- aptForm -->
</div> <!-- siteWrap -->



<?php
require("scripts.php");
?>

<script>
//give table height for bottom scrollbar
	function giveTableHeight() {
		vph = $(window).height();
		vph = vph - 340;
		vph2 = vph - 20;
		$('#tbl-outer').css({'height': vph + 'px'});
		$('#tbl-inner').css({'height': vph2 + 'px'});
	}


giveTableHeight();

function newFilter($str){
	//the status checkboxes
	var $statNew = document.getElementById("statusNEW").checked;
	var $statPen = document.getElementById("statusPEN").checked;
	var $statCon = document.getElementById("statusCON").checked;
	var $statDen = document.getElementById("statusDEN").checked;
	var $statCrq = document.getElementById("statusCRQ").checked;
	var $statCan = document.getElementById("statusCAN").checked;

	//update
	var $statUpd = document.getElementById("statusUPD").checked;
	var $statRep = document.getElementById("statusREP").checked;


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
	/*var $pFn = document.getElementById("patientFname").value;
	var $pLn = document.getElementById("patientLname").value;
	var $pDob = document.getElementById("patientDOB").value;*/
	var $pId = document.getElementById("patientID").value;
	 
	// Language.. messing around here
	var $aptLanguage = document.getElementById("searchLang").value;

	
	
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
	// var $getString = "status-1="+$statNew+"&status-2="+$statPen+"&status-3="+$statCon+"&status-4="+$statDen+"&status-5="+$statCan+"&status-6="+$statCrq;
	var $getString = "status-1="+$statNew+"&status-2="+$statPen+"&status-3="+$statCon+"&status-4="+$statDen+"&status-5="+$statCan+"&status-6="+$statCrq+"&status-7="+$statUpd+"&status-8="+$statRep;
	$getString = $getString+"&apt_date-FROM="+$dateFrom+"&apt_date-TO="+$dateTo+"&facility="+$facility+"&clinic="+$clinic;
	$getString = $getString+"&patient="+$pId;
	$getString = $getString+"&req_date-FROM="+$rDateFrom+"&req_date-TO="+$rDateTo; // req date
	$getString = $getString+"&interpreter_req="+$interpreter+"&interpreter_confirmed="+$intConf+"&id="+$aptId+"&asap="+$asap+"&language="+$aptLanguage;
	//+"&name_f="+$pFn+"&name_l="+$pLn+"&dob="+$pDob;
	
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
	xmlhttp.open("GET","proc/appointmentFilter2.php?"+$getString,true);
	xmlhttp.send();
}





function doClear($str){
	if ($str == 'clStatus'){
		document.getElementById("statusNEW").checked = false;
		document.getElementById("statusPEN").checked = false;
		document.getElementById("statusCON").checked = false;
		document.getElementById("statusDEN").checked = false;
		document.getElementById("statusCAN").checked = false;
		document.getElementById("statusCRQ").checked = false;
		document.getElementById("statusUPD").checked = false;
		document.getElementById("statusREP").checked = false;
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
		document.getElementById("statusUPD").checked = false;
		document.getElementById("statusREP").checked = false;
		document.getElementById("dateFrom").value = 'ANY';
		document.getElementById("dateTo").value = 'ANY';
		document.getElementById("reqdateTo").value = 'ANY';
		document.getElementById("reqdateFrom").value = 'ANY';
		document.getElementById("patientFname").value = '';
		document.getElementById("patientLname").value = '';
		document.getElementById("patientDOB").value = '';
		document.getElementById("patientID").value = '';
		document.getElementById('interpreterConfirmed').value = '';
		document.getElementById('interpreter').value = '';
		document.getElementById("searchLang").value = 'ANY';
		document.getElementById('aptId').value = '';
		document.getElementById("facility").value = 'ANY';
		document.getElementById("clinic").value = 'ANY';
		
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
	//var $pSlang = document.getElementById("searchLang").value;   
	// JAXY
	var $getString = "fn="+$pFn+"&ln="+$pLn+"&dob="+$pDob;
	//+"&lang="+$pSlang;
	//alert($pFn);
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
		    //alert("READY "+xmlhttp.readyState+" status "+xmlhttp.status);
			document.getElementById("patientID").value=xmlhttp.responseText;
			//document.getElementById("temp").innerHTML=xmlhttp.responseText;
			//document.getElementById("appointmentTable").innerHTML=xmlhttp.responseText;
			newFilter('pSearch');
			if(document.getElementById("patientID").value == 0) {
			    if($pFn.length != 0 || $pLn.length != 0 || ($pDob.length == 0 || $pDob != 'mm/dd/yyyy')) {
		            document.getElementById("patientID").value = -1;
                    newFilter('pSearch');
			    }
			    if($pFn.length == 0 && $pLn.length == 0 && ($pDob.length == 0 || $pDob == 'mm/dd/yyyy')) {
		            document.getElementById("patientID").value = 0;
                    newFilter('pSearch');
			    }
		    }
		    
		        
                
         	
		} else {
			//alert("NOT READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		}
	} 
	xmlhttp.open("GET","proc/findPatientsForAppointments.php?"+$getString,true);
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
		document.getElementById("statusUPD").checked = true;
		document.getElementById("statusREP").checked = true;
		var $tdd = document.getElementById("todaysDate").innerHTML;
		document.getElementById("dateFrom").value = $tdd;
	}
	
	if($str == 'tabConf'){
		document.getElementById("statusNEW").checked = false;
		document.getElementById("statusPEN").checked = false;
		document.getElementById("statusCON").checked = true;
		document.getElementById("statusDEN").checked = false;
		document.getElementById("statusCRQ").checked = false;
		document.getElementById("statusCAN").checked = false;
		document.getElementById("statusUPD").checked = false;
		document.getElementById("statusREP").checked = false;
	}
	
	if($str == 'tabDenCan'){
		document.getElementById("statusNEW").checked = false;
		document.getElementById("statusPEN").checked = false;
		document.getElementById("statusCON").checked = false;
		document.getElementById("statusDEN").checked = true;
		document.getElementById("statusCRQ").checked = false;
		document.getElementById("statusCAN").checked = true;
		document.getElementById("statusREP").checked = false;
		//document.getElementById("statusUPD").checked = true;
	}
	if($str == 'tabRep'){
		document.getElementById("statusNEW").checked = false;
		document.getElementById("statusPEN").checked = false;
		document.getElementById("statusCON").checked = false;
		document.getElementById("statusDEN").checked = false;
		document.getElementById("statusCRQ").checked = false;
		document.getElementById("statusCAN").checked = false;
		document.getElementById("statusUPD").checked = false;
		document.getElementById("statusREP").checked = true;
	}

	newFilter('tabs');
}

// $today,"id = 'dateFrom'

function forcePat($str){
	// force search of patient
	// first force all styatus tabs true
		document.getElementById("statusNEW").checked = true;
		document.getElementById("statusPEN").checked = true;
		document.getElementById("statusCON").checked = true;
		document.getElementById("statusDEN").checked = true;
		document.getElementById("statusCRQ").checked = true;
		document.getElementById("statusCAN").checked = true;
		document.getElementById("statusUPD").checked = true;
		document.getElementById("statusREP").checked = true;
		
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
