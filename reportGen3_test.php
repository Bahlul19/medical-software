<!doctype HTML>
<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
?>
<html>
<head>
<title> Report Generation Wizard</title>
<?php
require("{$legos}/head.php");
?>
<style>

.tableList table{
border: 1px solid #000000;
	border-collapse:collapse;
}

.tableList table td{
	border-bottom: 1px solid #000000;
	padding:5px 20px;
}
.tableList td table{
	border: 2px solid #0000FF;
	border-collapse:collapse;
}
.tableList td table td{
	border-right: 2px solid #0000FF;
	padding:0px 5px;
}


</style>
</head>
<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
$table = $_POST['table'];
$fields = $_POST['arrayText'];
?>

<div class = 'siteWrap'>
<div class = 'reportDisplay'>
		<div class = 'formTitle'>
		Report Generation Wizard: STEP 3 - Select Filtering and Ordering Options
		</div>
		<div class = 'instructions'>
		Step 3: Select the values from <b>"<?php echo $table; ?>"</b> that you wish to use as filtering options. You may choose to filter your results by any of the fields available in <b>"<?php echo $table; ?>"</b>. Mopre instructions to come...
		</div>
		<hr>
<?php

// get fields name and comment;
$ar = getFullFields($table,'0,8');
//print_r($ar);


echo "<div class = 'tableList'>";


//function makeTable($aOFa,$headers){
$headers = array(
	"Field Name" => 0,
	"Comments" => 2
	
);
//makeTable($ar,$headers);
echo "<table>";
echo "<tr>";
echo "<th> USE </td>";
echo "<th> Field Name </th>";
echo "<th> Operator </th>";
echo "<th> Value </th>";
echo "</tr>";
foreach($ar as $k => $v){
	
	$field = $v[0];
	$assoc = $v[1];
	echo "<tr>";
		echo "<td><button name = '{$field}Name' id = '{$field}' onclick = 'addClause(this.id);'>USE</button></td>";
		echo "<td> $field </td>";
		echo "<td><select name = '{$field}OP'>";
			echo "<option value = 'LIKE'> Like </option>";
			echo "<option value = '='> Equal To </option>";
			echo "<option value = '<>'> Not Equal To </option>";
			echo "<option value = '>'> Greater Than </option>";
			echo "<option value = '<'> Less Than </option>";
			
		echo "</select></td>";
		$assoc = explode(',',$assoc);
	//	echo "<td>";
	//	print_r($assoc);
	//	echo "</td>";
		if($assoc[0] == ''){
			echo "<td>EMPTY</td>";
		} else {
			echo "<td>";
			$checkTable = $assoc[0];
			unset($assoc[0]);
			$checkFields = implode(',',$assoc);
			$sql = "SELECT distinct id,$checkFields FROM $checkTable";
			$go = mysql_query($sql);
			echo "<select name = 'TEST'>";
			while ($row = mysql_fetch_assoc($go)){
					$id = $row['id'];
					unset($row['id']);
					$words = implode('--',$row);
				echo "<option value = '$id'>";
					echo $words;
				echo "</option>";
				
				
				
				
			}
			echo "</select>";
			echo "</td>";
		}
	echo "</tr>";
}

echo "</table>";

// Okay, now.. we have fields and comments, with this we have associations of external tables
// in the comments section



echo "</div>";

clearfix();

hr();
echo "<div class = 'buttonBoard'>";


formInput('submit','submit','NEXT','class = "nextButton"');
formClose();

// clear button just reloads this page with hidden post data of current table
formForm("{$htmlRoot}/reportGen1.php","post");
formInput('submit','submit','PREVIOUS','class = "previousButton"');
formClose();

// clear button just reloads this page with hidden post data of current table
formForm("{$htmlRoot}/reportGen2.php","post");
formInput("readyTable","hidden",$table);
formInput('submit','submit','CLEAR','class = "clearButton"');
formClose();

echo "</div>";
?>

</div>
</div>


</body>
</html>

