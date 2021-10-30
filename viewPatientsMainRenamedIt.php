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
<!-- <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> --> 

<!-- Added jquery for quick load -->
<script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.tabletoCSV.js" type="text/javascript" charset="utf-8"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/jquery.plugin.js"></script>



<!-- <script type="text/javascript" src="js/jquery.dataTables.min.js"/></script> -->

    <script>
        $(function(){
            $("#export").click(function(){
                $("#export_table").tableToCSV();
            });
        });
    </script>

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
	font-size:.6em;
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
		View Patients 
		<button id="export" data-export="export">Export</button>
		</div>
	<div class = 'redBlock'>
	*At least any two data element fields below are required to be entered for a search.
	</div>	
<?php

//debug
//hr();
//print_r($_POST);
//hr();


echo "<div id = 'filter'>";
echo "<table width = '100%'>";
echo "<tr>";
echo "<th style = 'font-size:1.0em;'> First Name </th>";
echo "<th> Last Name </th>";
echo "<th> Date Of Birth </th>";
// language
echo "<th> Language </th>";
echo "<th> Insurance ID </th>";
if($uInfo['role'] == 1 || $uInfo['role'] == 2){ // only if they have a choice
	echo "<th> Facility </th>"; // can choose both
	echo "<th> Clinic </th>"; // ""
} // Add user-clini-facility-filter-here
if($uInfo['role'] == 3){ // they can view facs
	echo "<th> Clinic </th>";
}

echo "<th> Search </th>";
echo "</tr>";
//function formInput($name,$type,$value,$param){
echo "<tr>";


/////////////////
// patients
////////////////
	echo "<form action = '' method = 'post'>";
	//fname
	echo "<td style = 'text-align:center;'>";
	echo "<input type='text' size = '15' name='fName' id = 'fName' style = 'font-size:1.0em;'>";
	echo "</td>";
	//lname
	echo "<td>";
	echo "<input type='text' size = '15' name='lName' id = 'lName'>";
	echo "</td>";
	//dob
	echo "<td>";
	echo "<input type='text' size = '10' name='dob' id = 'dob'>";
	echo "</td>";
	// add language
	echo "<td>";
	echo "<select name = 'patLanguage'>";
	echo "<option value = 'ANY'> ANY </option>";
	foreach($languageList as $lid => $lTitle){
		echo "<option value = '{$lid}'> {$lTitle} </option>";
	}
	echo "</select>";
	echo "</td>";
	
	
	//
	echo "<td>";
	echo "<input type='text' size = '20' name='ins' id = 'ins'>";
	echo "</td>";
	
	
//Facility dropdown 
// make this
if($uInfo['role'] == 1 || $uInfo['role'] == 2){ 
$sql = "SELECT id, title FROM facilities ";
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
	$sql = "SELECT id, title FROM clinics ";
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
echo "</table>";

echo "</div>";



// Okay we will jax the data in from here....
echo "<div id = 'showTable'>";



?>


<?php
// patient search


// here we make a query...
$run = TRUE;

$fFname = $_POST['fName'];
$fLname = $_POST['lName'];
$fdob = $_POST['dob'];
$fins = $_POST['ins'];
$fFac = $_POST['facility'];
$patLanguage = $_POST['patLanguage'];




if($uInfo['role'] == 3 || $uInfo['role'] == 4){ // view only your own
	$fFac = $uInfo['facility'];
}
$fClin = $_POST['clinic']; 


if($loadPat == ''){
	$sql = "SELECT * FROM patients ";
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
	
	
	// langauge
	if($patLanguage != '' && $patLanguage != 'ANY'){
		if($where != ' WHERE '){
			$where .= ' AND ';
		}
		$where .= " language = '{$patLanguage}' ";
		$count++;
	}
	

	if($fins != ''){
		if($where != ' WHERE '){
			$where .= ' AND ';
		}
		$where .= " insurance_id LIKE '%{$fins}%' ";
		$count+=2;
	}

	if(($fFac != 'ANY' && $fFac != '') || $uInfo['role'] == 3){
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
	if($where != ' WHERE ' )
	{ // if where exists and ther are 2 params
		$sql .= $where;
		
		//$run = TRUE;
	}
	$sql .= " ORDER BY name_l, id ASC ";
	//$sql .= " ORDER BY name_l ASC";
}else {
	$sql = "SELECT * FROM patients WHERE id = '{$loadPat}'";
	$run = TRUE;
}

?>

<span class="msg-title"><h1>Loading...</h1></span>

<?php


//debug
//hr();
//print_r($sql);
//hr();


if($run){
	$go = mysql_query($sql)or die(mysql_error());

	//echo "$sql";
	hr();
	

//for adding the speed into the page in viewpatient page below two line added

	echo "<table class='PatientRecordsData' border = '1' id = 'export_table'>";
	echo "<thead><tr>";

	//echo "<table border = '1' id = 'export_table'>";
	echo "<tr>";
		if($uInfo['role']==4){
			echo "<th> View </th>";
		} else {
			echo "<th> Edit </th>";
		}
		echo "<th> ID </td>";
		echo "<th> First Name </th>";
		//echo "<th><input type='submit' name='ASC' value='Last Name'></th>";
		// echo "<button onclick='myFunction()''>Last Name</button>";
		echo "<th> Last Name </th>";
		echo "<th> MRN </th>";
		echo "<th> Gender </th>";
		echo "<th> DOB </th>";
		echo "<th> Language </th>";
		echo "<th> Preferred Int </th>";
		echo "<th> Provider Name </th>";
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
		echo "<th>  </th>";
	    echo "<th> Note </th>";
		//echo "<th> Appointment </th>";
	echo "</tr></thead>
<tbody>
";
	//echo "</tr>";

	while ($row = mysql_fetch_assoc($go)){
		$patID = $row['id'];
		$patFname = $row['name_f'];
		$patLname = $row['name_l'];
		$pdob = $row['dob'];
		$aptId = $row['id'];
	echo "<tr>";
		echo "<td>";
		//1 Test Patient 1/1/1914 German
		if($uInfo['role']==4){
			echo "<a class = 'editButton' href = 'viewPatient.php?p={$patID}'>";
			echo "View";
			echo "</a>";
		} else {
			echo "<a class = 'editButton' href = 'editPatient.php?p={$patID}'>";
			echo "Edit";
			echo "</a>";
		}
		
		
		echo "</td>";
		foreach($row as $k=>$v){
			switch($k){
				default:
				echo "<td> {$v} </td>";
				break;
			
				case "language":
					$sq2 = "SELECT language FROM languages WHERE id = '{$v}'";
					$go2 = mysql_query($sq2) or die(mysql_error());
					$row = mysql_fetch_assoc($go2);
					$patLang = $row['language'];
					echo "<td> {$row['language']} </td>";
				break; 
			
				case "clinic_id":
					$sq2 = "SELECT title, addr_1, addr_2, addr_city, addr_state, addr_zip, phone_1 FROM clinics WHERE id = '{$v}'";
					$go2 = mysql_query($sq2)or die ("clinic_id" . mysql_error());
					$r2 = mysql_fetch_assoc($go2);
					$facTitle = $r2['title'];
					$facAdr = $r2['addr_1'] . " ";
					$facAdr .= $r2['addr_2'] . " ";
					$facAdr .= $r2['addr_city'] . " ";
					$facAdr .= $r2['addr_state'] . " ";
					$facAdr .= $r2['addr_zip'] . " ";
					$facPhone = $r2['phone_1'];
				
					echo "<td title = '{$facTitle} - Address:{$facAdr} - Phone: {$facPhone}'> $facTitle </td>";
					//echo "<td> CLINIC </td>";
				break;
			
				case "facility_id":
					$sq2 = "SELECT title FROM facilities WHERE id = '{$v}'";
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
					echo "<td><a href = '{$htmlRoot}/viewHistory.php?tp={$patID}'> View History </a></td>";
				} else {
					//echo "<td> &nbsp; </td>";
					echo "<td> NONE </td>";
				}
			    break;

			    case "notes";
					echo "<td> {$v} </td>";
				break;

		
			}
		}
		// new appointment system
		
		echo "</tr>";

	}
	echo "</table>";
	echo "</div>"; // showTable
 }
?>


<div id = 'hidePat'>

</div>

<?php

echo "<div id = 'newPatient'>";

include("{$phpRoot}/newPatFromSearch.php");

echo "</div>";

?>
	</div> <!-- aptForm -->
</div> <!-- siteWrap -->

<script>
function newPat(){
//alert('working');
	//var $dat=document.getElementById('hidePat').innerHTML;
	//document.getElementById('newPatient').innerHTML=$dat;
	document.getElementById('newPatient').style.display='block';
}

</script>

<!-- new add data table -->




<?php
require("scripts.php");
?>


</body>
</html>
