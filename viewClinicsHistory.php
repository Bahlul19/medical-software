<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
$clinic = $_GET['tp'];
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
 //<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
 ?>
 <script src="js/jquery.tabletoCSV.js" type="text/javascript" charset="utf-8"></script>
 <script>
    $(function(){
        $("#export").click(function(){
		//alert("Clicked");
			$("#export_table").tableToCSV();
            });
        });
	</script>


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
		View Clinic Details
		<button id="export" data-export="export">Export</button>
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
	echo "<th> Cancel Requested </th>";
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
	$sql = "SELECT id, title FROM facilities ORDER BY title";
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
		echo "<td><input type='text' size = '15' name='patientFname' id = 'patientFname' onBlur = 'newPatSearch(this.id);'></td>"; ///////////////
		echo "<td><input type='text' size = '15' name='patientLname' id = 'patientLname' onBlur = 'newPatSearch(this.id);'></td>"; ///////////////
		echo "<td><input type='text' size = '10' name='patientDOB' id = 'patientDOB' onBlur = 'newPatSearch(this.id);'></td>";  //////////////////
		
		
		
		
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
echo "<a id = 'tabNewPen' onclick = 'tabSwitch(this.id)'> New, Pending and Cancellation Requests </a>";
echo "<a id = 'tabConf' onclick = 'tabSwitch(this.id)'> Confirmed </a>";
echo "<a id = 'tabDenCan' onclick = 'tabSwitch(this.id)'> Denied and Cancelled </a>";

echo "&nbsp; &nbsp; &nbsp;<button onClick = 'doClear(\"all\");' class = 'clearButton'> Clear All</button>";

echo "</div>";


clearfix();

?>

	<?php

	//$sql = "SELECT * FROM clinics WHERE id ='{$clinic}'";
	$sql = "SELECT clinic_id,title,addr_1,addr_2,addr_city,addr_state,addr_zip,email,phone_1,phone_2,fax,note FROM clinics WHERE id ='{$clinic}'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$arrData = array('clinic_id' => $row['clinic_id'],'title' => $row['title'],'addr_1' => $row['addr_1'],'addr_2' => $row['addr_2'],'addr_city' => $row['addr_city'],'addr_state' => $row['addr_state'],'addr_zip' => $row['addr_zip'],'email' => $row['email'],'phone_1' => $row['phone_1'],'phone_2' => $row['phone_2'],'fax' => $row['fax'],'note' => $row['note']);
echo "<table> 
 </table>";



?>



<table class='ClinicRecordsData' border = '1' id = 'export_table'>

	<thead>
	<tr>
	<th>Clinic ID</th>
	<th>Facility</th>
	<th>Clinic Title</th>
	<th>Address 1</th>
	<th>Address 2</th>
	<th>City</th>
	<th>State</th>
	<th>Zip</th>
	<th>Email</th>
	<th>Phone 1</th>
	<th>Phone 2</th>
	<th>Fax</th>
	<th>Notes</th>
</tr>
<tbody>

<?php 
echo "<tr>";
	foreach($arrData as $value)
	{
		echo "<td>$value</td>";
	}

	echo "</tr>";
 ?>

	</div> <!-- aptForm -->
</div> <!-- siteWrap -->


<?php
require("scripts.php");
?>



