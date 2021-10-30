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
<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/jquery.plugin.js"></script>


<script>
jQuery(function($){
   $("#dob").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#phone").mask("(999) 999-9999");
//   $("#tin").mask("99-9999999");
//   $("#ssn").mask("999-99-9999");
});
</script>


<title> Itasca</title>
<style>
	.aptButton{
		font-size:1.0em;
		background-color:#CCCCFF;
		border:1px solid #000000;
	}
	#hidePat{
	display:none;
	}
	.newPat{
	color:#FFFFFF;
	border:1px solid #FFFFFF;
	cursor:pointer;
	padding-left:10px;
	padding-right:10px;
	}
	.newPat:hover{
		background-color:#222222;
	}

	#newPatient{
	display:none;
	}
	.redBlock{
	color:#FF0000;
	font-size:1.2em;
	text-align:center;
	width:100%;
	font-weight:bold;

	}

	.searchOr{
	 style = 'font-size:1.2em;
	 
	}
	.searchOr span{
	border:1px solid #000000;
	color:#000000;
	}

	.textnone
	{
		text-decoration: none;
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
</head>
<body>


<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");

$loadPat = $_GET['p'];

?>


<div class = 'siteWrap'>


	<div class = 'tableDisplay'>
		<div class = 'formTitle'>
		New Appointment -- Step 1 Select Patient:
		
		</div>
		<div class = 'searchOr'>
		Search For A Patient - Or -
		<span onclick = 'newPat();' class = 'newPat'> Create A New Patient </span>
		<!-- <span><a class="textnone" href = 'newPatient.php'> Create A New Patient</a> </span> -->
		 <!-- CSS FIX HERE -->
		</div>
	<div class = 'redBlock'>
	*At least any two data element fields below are required to be entered.
	</div>	
<?php
//hr();
//print_r($_POST);
//hr();
echo "<div id = 'filter'>";
echo "<div id='table-scroll' class='table-scroll'>";
echo "<div class = 'table-responsive table-wrap'>";
echo "<table class='table main-table' border = '1'>";
echo "<thead><tr>";
echo "<th> First Name </th>";
echo "<th> Last Name </th>";
echo "<th> Date Of Birth </th>";
echo "<th> Insurance ID </th>";
if($uInfo['role'] == 1 || $uInfo['role'] == 2){ // only if they have a choice
	echo "<th> Facility </th>"; // can choose both
	echo "<th> clinic </th>"; // ""
}
if($uInfo['role'] == 3){ // they can view facs
	echo "<th> Clinic </th>";
}

echo "<th> Search </th>";
echo "</tr></thead>
<tbody>
";
//function formInput($name,$type,$value,$param){
echo "<tr>";


/////////////////
// patients
////////////////
	echo "<form action = '' method = 'post'>";
	//fname
	echo "<td>";
	echo "<input type='text' size = '20' name='fName' id = 'fName'>";
	echo "</td>";
	//lname
	echo "<td>";
	echo "<input type='text' size = '20' name='lName' id = 'lName'>";
	echo "</td>";
	//dob
	echo "<td>";
	echo "<input type='text' size = '20' name='dob' id = 'dob'>";
	echo "</td>";
	//
	echo "<td>";
	echo "<input type='text' size = '20' name='ins' id = 'ins'>";
	echo "</td>";
	
	
//Facility dropdown 
// make this
if($uInfo['role'] == 1 || $uInfo['role'] == 2){ 
$sql = "SELECT id, title FROM facilityredo ORDER BY title ASC";
	echo "<td>";

	
	$go = mysql_query($sql)or die(mysql_error());
	echo "<select name = 'facility' id = 'facility'>";
	echo "<option value = 'ANY'> ANY </option>";
	while ($row = mysql_fetch_assoc($go)){
		echo"<option value = '{$row['id']}'> {$row['title']} </option>";
	}		
	echo "</select>";
} else {
	echo "<input type = 'hidden' id = 'facility' name = 'facility' value = '{$uInfo['facility']}'>";

}

//if($uInfo['role'] > 2){
	//	$sql .= "WHERE clinic_id = '{$uInfo['clinic']} ";
//	}

// Clinic Dropdown
if($uInfo['role'] == 1 || $uInfo['role'] == 2 || $uInfo['role'] == 3){ // if there is a choice
	$sql = "SELECT id, title FROM clinics ORDER BY title ASC";
	echo "<td>";

	if($uInfo['role'] == 3){
		$sql .= " WHERE clinic_id = '{$uInfo['facility']}' ";
		//echo $sql;
	}
	$go = mysql_query($sql);
	echo "<select name = 'clinic' id = 'clinic'>";
	echo "<option value = 'ANY'> ANY </option>";
	while ($row = mysql_fetch_assoc($go)){
		echo"<option value = '{$row['id']}'> {$row['title']} </option>";
	}		
	echo "</select>";
	echo "</td>";
} else {
	//echo "<input type = 'hidden' id = 'facility' name = 'facility' value = '{$uInfo['facility']}'>";
}

echo "<td><input type = 'submit' value = 'submit'> </td>";
echo "</tr>";
echo "</form>";
echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";


echo "</div>";



// Okay we will jax the data in from here....
echo "<div id = 'showTable'>";



?>


<?php
// patient search


// here we make a query...
$run = FALSE;

$fFname = $_POST['fName'];
$fLname = $_POST['lName'];
$fdob = $_POST['dob'];
$fins = $_POST['ins'];
$fFac = $_POST['facility'];
$fClin = $_POST['clinic']; 


if($loadPat == ''){
	$sql = "SELECT id, name_f, name_l, mrn, gender, dob, language, prefered_interpreter, provider_name, addr_1, addr_2, addr_city, addr_state, addr_zip, insurance_provider, insurance_id, phone, second_phone, clinic_id, facility_id, history, notes FROM patients ";
	$where = ' WHERE ';
	$count = 0;


	if($fFname != ''){
		$where .= " name_f LIKE '%{$fFname}%' ";
		$count++;
	}
	if($fLname != ''){
		if($where != ' WHERE '){
			$where .= ' AND ';
		}
		$where .= " name_l LIKE '%{$fLname}%' ";
		$count++;
	}



	if($fdob != ''){
		//remove leading zeros...
		$fixDOB = strtotime($fdob);
		$fdob = date("n/j/Y",$fixDOB);
		if($where != ' WHERE '){
			$where .= ' AND ';
		}
		$where .= " dob LIKE '%{$fdob}%' ";
		$count++;
	}

	if($fins != ''){
		if($where != ' WHERE '){
			$where .= ' AND ';
		}
		$where .= " insurance_id LIKE '%{$fins}%' ";
		$count++;
	}

	if($fFac != 'ANY' && $fFac != ''){
		if($where != ' WHERE '){
			$where .= ' AND ';
		}
		$where .= " facility_id = '{$fFac}' ";
	}

	if($fClin != 'ANY' && $fClin != ''){
		if($where != ' WHERE '){
			$where .= ' AND ';
		}
		$where .= " clinic_id = '{$fClin}' ";
	}

	//run or not
	if($where != ' WHERE ' && $count > 1){ // if where exists and ther are 2 params
		$sql .= $where;
		$run = TRUE;
	} 

} else {
	$sql = "SELECT id, name_f, name_l, mrn, gender, dob, language, prefered_interpreter, provider_name, addr_1, addr_2, addr_city, addr_state, addr_zip, insurance_provider, insurance_id, phone, second_phone, clinic_id, facility_id, history, notes FROM patients WHERE id = '{$loadPat}'";
	$run = TRUE;
}

//hr();
//print_r($sql);
//hr();
if($run){
	$go = mysql_query($sql)or die(mysql_error());

	//echo "$sql";
	hr();
	echo "<div id='table-scroll' class='table-scroll'>";
	echo "<div class = 'table-responsive table-wrap'>";
	echo "<table class='table main-table' border = '1'>";
	echo "<thead><tr>";
		echo "<th> ID </td>";
		echo "<th> First Name </th>";
		echo "<th> Last Name </th>";
		echo "<th> MRN </th>";
		echo "<th> Gender </th>";
		echo "<th> DOB </th>";
		echo "<th> Language </th>";
		echo "<th> Preferred Int </th>";
		echo "<th> Provider Name</th>";
		echo "<th> Address 1 </th>";
		echo "<th> Address 2 </th>";
		echo "<th> City </th>";
		echo "<th> State </th>";
		echo "<th> Zip </th>";
		echo "<th> Insurance </th>";
		echo "<th> Insurance ID </th>";
		echo "<th> Phone</th>";
		echo "<th> Second Phone</th>";	
		echo "<th> Clinic</th>";
		echo "<th> Facility</th>";
		echo "<th> History </th>";
		echo "<th> Notes </th>";
		echo "<th> Appointment </th>";
	echo "</tr></thead><tbody>";
	

	while ($row = mysql_fetch_assoc($go)){
		$patID = $row['id'];
		$patFname = $row['name_f'];
		$patLname = $row['name_l'];
		$pdob = $row['dob'];
		$aptId = $row['id'];
	echo "<tr>";
		foreach($row as $k=>$v){
			switch($k){
				default:
				echo "<td> {$v} </td>";
				break;
				case 'id':
				echo "<td>";
				echo "<a href = 'editPatient.php?p={$v}' > {$v} </a>"; 
				echo "</td>";
				break;
				case "language":
					$sq2 = "SELECT language FROM languages WHERE id = '{$v}'";
					$go2 = mysql_query($sq2) or die(mysql_error());
					$row = mysql_fetch_assoc($go2);
					$patLang = $row['language'];
					echo "<td> {$row['language']} </td>";
				break; 
			
				case "clinic_id":
					// $sq2 = "SELECT title, addr_1, addr_2, addr_city, addr_state, addr_zip, phone_1 FROM clinics WHERE id = '{$v}'";
				$sq2 = "SELECT title, addr_1, addr_2, addr_city, addr_state, addr_zip, phone_1,phone_2 FROM clinics WHERE id = '{$v}'";
					$go2 = mysql_query($sq2)or die ("clinic_id" . mysql_error());
					$r2 = mysql_fetch_assoc($go2);
					$facTitle = $r2['title'];
					$facAdr = $r2['addr_1'] . " ";
					$facAdr .= $r2['addr_2'] . " ";
					$facAdr .= $r2['addr_city'] . " ";
					$facAdr .= $r2['addr_state'] . " ";
					$facAdr .= $r2['addr_zip'] . " ";
					$facPhone = $r2['phone_1'];
					//for adding phone number
					$facPhone2 = $r2['phone_2'];
				
					echo "<td title = '{$facTitle} - Address:{$facAdr} - Phone: {$facPhone}'> $facTitle </td>";
					//echo "<td> CLINIC </td>";
				break;
			
				case "facility_id":
					$sq2 = "SELECT title FROM facilityredo WHERE id = '{$v}'";
					$go2 = mysql_query($sq2)or die (mysql_error());
					$r2 = mysql_fetch_assoc($go2);
					$clinTitle = $r2['title'];
	
				
					echo "<td> $clinTitle </td>";
					//echo "<td> FACILITY </td>";
				break;
			
			
			
				case "insurance_provider";
					$sq2 = "SELECT title FROM insurance_providers WHERE id = '{$v}'";
					$go2 = mysql_query($sq2)or die (mysql_error());
					$r2 = mysql_fetch_assoc($go2);
					$insTitle = $r2['title'];
					echo "<td> $insTitle </td>";
				break;
				case 'history':
				if($v != ''){
					echo "<td><a href = '{$htmlRoot}/viewHistory.php?tp={$patID}' target = 'blank'> View History </a></td>";
				} else {
					//echo "<td> &nbsp; </td>";
					echo "<td> NONE </td>";
				}
				break;
		
			}
		}
		// new appointment system
		echo "<td>";
		//1 Test Patient 1/1/1914 German
		echo "<form action = 'newAppointment.php' method = 'post'>";
		echo "<input type = 'hidden' name = 'p' value = '{$patID} {$patFname} {$patLname} {$pdob} {$patLang}'>";
		echo "<input type = 'submit' value = 'Create New' class = 'aptButton'>";
		echo "</form>";
		echo "</td>";
		echo "</tr>";

	}
	echo "</tbody>";
	echo "</table>";
	echo "</div>";
	echo "</div>";
	echo "</div>"; // showTable
}
?>


<div id = 'hidePat'>

</div>

<?php

echo "<div id = 'newPatient'>";

//include("{$phpRoot}/newPatFromSearch.php");

echo "</div>";

?>
	</div> <!-- aptForm -->
</div> <!-- siteWrap -->

<script>
function newPat(){
//alert('working');
	//var $dat=document.getElementById('hidePat').innerHTML;
	//document.getElementById('newPatient').innerHTML=$dat;
//	document.getElementById('newPatient').style.display='block';

window.location="/portal/newPatient.php?fs=1";
}

</script>


<?php
require("scripts.php");
?>


</body>
</html>
<?php
/*

	var $count = 0;
	var $fname = document.forms["newPatient"] ["name_f"].value; // X
	var $lname = document.forms["newPatient"] ["name_l"].value; // X
	var $gen = document.forms["newPatient"] ["gender"].value; // N //
	var $lang = document.forms["newPatient"] ["language"].value; //'Please Specify A Langauge' //
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
	/*
	
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
	
	if($lang =='Please Specify A Langauge' ){ //&& ($langN=='' || $langN==null)){
		$count = $count+1;
		document.getElementById('inputLanguage').style.backgroundColor='#FFAAAA';
	}
	
	
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
	
	//ret false if any required fields are blank.
	if($count > 0){
		alert("The fields highlighted in red are required.");
		return false;
	}
	
*/

?>

