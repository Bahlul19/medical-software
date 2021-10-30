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
#appointmentTable2{
display:none;
border: 2px solid black;
padding: 30px;
font-weight: bold;
}

</style>

<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.datepick.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/custom.js" type="text/javascript"></script>

<script>
jQuery(function($){
   $("#patientDOB").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
//   $("#phone").mask("(999) 999-9999");
//   $("#tin").mask("99-9999999");
//   $("#ssn").mask("999-99-9999");
});
</script>
<script>
function convertTOPdf(){
	 $('form').attr('action', 'printWOFPDF.php');
        $('form').attr('onsubmit', '');
        $('form').submit();
   }
</script>

<script>
/*$(function() {
	//$('#popupDatepicker').datepick();
	$('#dateFrom').datepick({onSelect: showDate});
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

$(function() {
	//$('#popupDatepicker').datepick();
	$('#dateTo').datepick({onSelect: showDate});
	$('#inlineDatepicker').datepick({onSelect: showDate});
});*/

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

	echo "<body onload = \"newFilter();\">";
?>

<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>


<div class = 'siteWrap'>


	<div class = 'tableDisplay'>
		<div class = 'formTitle'>
		My Appointments
		<?php
			//echo " {$todayHuman}";
		?>
		</div>
<?php
//print_r($uInfo);hr();
// this is the filter
echo "<div id = 'filter'>";
echo "<table width = '100%'";

echo "<tr>";
echo "<th> From Date </th>";
echo "<th> To Date </th>";
echo "<th> Patient First Name</th>";
echo "<th> Patient Last Name</th>";
echo "<th> Patient DOB</th>";
echo "</tr>";


// these re the inputs

echo "<tr>";
echo "<td>";
//formInput("dateFrom","text",$today,"id = 'dateFrom' size = '8' ");
formInput("dateFrom","text",$today,"id = 'dateFrom' size = '8' ");
echo "</td>";
echo "<td>";
formInput("dateTo","text","ANY","id = 'dateTo' size = '8' ");
echo "</td>";

	echo "<td><input type='text' size = '20' name='patientFname' id = 'patientFname' onBlur = 'newPatSearch(this.id);'></td>"; ///////////////
	echo "<td><input type='text' size = '20' name='patientLname' id = 'patientLname' onBlur = 'newPatSearch(this.id);'></td>"; ///////////////
	echo "<td><input type='text' size = '15' name='patientDOB' id = 'patientDOB' onBlur = 'newPatSearch(this.id);'></td>";  //////////////////
	echo "<input type='hidden' name='patientID' id = 'patientID' onBlur = 'newFilter(this.id);'>";  ////////////////////



echo "</tr>";


// okay interpreterConfirmed is needed, and should be set to this user's ID.
echo "<input type = 'hidden'  id = 'interpreterConfirmed' value = '{$uInfo['id']}'>";


// pat search
echo "<tr>"; // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
	echo "</tr>"; // ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	

echo "</table>";
// here we swap stuff using jax.

echo "<div id = 'appointmentTable'>";
//include("proc/appointmentFilterInt.php"); // also the Ajax thing? probably.
echo "Loading...";
echo "</div>";

echo "<div id = 'appointmentTable2'>";
echo "No matching records found";
echo "</div>";
?>

	</div> <!-- aptForm -->
</div> <!-- siteWrap -->


<?php
require("scripts.php");
?>

<script>
function newFilter($str){
	var $dateFrom = document.getElementById("dateFrom").value;
	var $dateTo = document.getElementById("dateTo").value;
	var $pId = document.getElementById("patientID").value;
	var $intConf= document.getElementById("interpreterConfirmed").value;
	// id
	//var $aptId = document.getElementById("aptId").value;
	var $getString = "apt_date-FROM="+$dateFrom+"&apt_date-TO="+$dateTo+"&interpreter_confirmed="+$intConf+"&patient="+$pId;
	//var $getString = "THIS IS A TEST";
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
		if($pId == 0 && $pId.length !=0 ) {
		    document.getElementById("appointmentTable").style.display = "none";
		    document.getElementById("appointmentTable2").style.display = "block";
		} else{
		    document.getElementById("appointmentTable2").style.display = "none";
		    document.getElementById("appointmentTable").style.display = "block";
		    document.getElementById("appointmentTable").innerHTML=xmlhttp.responseText;
		}
		} else {
		//	alert("NOT READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		}
	} 
	xmlhttp.open("GET","proc/appointmentFilterInt.php?"+$getString,true);
	xmlhttp.send();
	
//	alert($getString);
	
	
}

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
		    document.getElementById("patientID").value=xmlhttp.responseText;
			newFilter('pSearch');
		    if($pFn.length == 0 && $pLn.length == 0 && ($pDob.length == 0 || $pDob == 'mm/dd/yyyy')) {
                document.getElementById("patientID").value = "Empty";
                newFilter('pSearch');
         	}
		//	alert("READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		    //document.getElementById("patientID").value=xmlhttp.responseText;
			//document.getElementById("temp").innerHTML=xmlhttp.responseText;
			newFilter('pSearch');
		} else {
			//alert("NOT READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		}
	} 
	xmlhttp.open("GET","proc/findPatients.php?"+$getString,true);
	xmlhttp.send();
}




/*
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
		document.getElementById("patientID").value = '';
	}

	newFilter('cleared');
}
*/



</script>

</body>
</html>

<?php

/*


	
	
	


echo "<tr>";

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
		echo "<input type='hidden' name='patientID' id = 'patientID' onBlur = 'newFilter(this.id);'>";  ////////////////////
	echo "</tr>"; // ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo "</table>";






//echo "<th> Language </th>";

echo "<tr>";
/// BREAK HERE



echo "<tr>";

// status
echo "<td>";

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
		echo "<input type='hidden' name='patientID' id = 'patientID' onBlur = 'newFilter(this.id);'>";  ////////////////////
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
echo "<input type='text' name='interpreterConf' id = 'interpreterConfirmed' value='{$uInfo['id']}' size = '20' class='autoInterp' onBlur = 'newFilter(this.id);'>";
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




*/


?>
