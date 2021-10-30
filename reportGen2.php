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
.twoThirds{
	width:60%;
	background-color:#DDDDDD;
	float:left;
	padding:10px 0px;
}
.twoThirds textarea{
	height:50px;
	width:95%;
	display:none;
	
}

#verbal{
margin:auto;
width:90%;
padding-left:20px;
background-color:#FFFFFF;
text-align:left;
}
</style>
</head>
<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>

<div class = 'siteWrap'>
<div class = 'reportDisplay'>
		<div class = 'formTitle'>
		Report Generation Wizard: STEP 2 - Select Fields To Include
		</div>
		<div class = 'instructions'>
		Step 2: Select the fields from your primary table that you wish to include in the report. You may assign a
		 "friendly name" to a given field using the text box in the "As Name" column. For example, if you wanted
		 to include the database field "name_l" in the report, and have it show up as "Last Name", you would enter
		 "Last Name" (no quotes) in the "As Name" column next to "name_l", then click the "ADD" button. Once added,
		  a field can be removed by clicking the "REMOVE" button.
		</div>
		<hr>

<?php
$table = $_POST['readyTable'];
$ar = array();
//$sql = "SELECT * FROM $table LIMIT 1";
$sql = "SHOW COLUMNS FROM $table";
$go = mysql_query($sql);
while($row = mysql_fetch_array($go)){
	array_push($ar,$row[0]);
}
echo "<div class = 'tableList'>";
echo "<b> Include These Fields From \"{$table}\" </b><hr>";
echo "<table class = 'selectFields'>";
echo "<tr>";
echo "<th>Use</th>";
echo "<th> Field </th>";
echo "<th> Friendly Name </th>";
echo "</tr>";
foreach($ar as $k => $v){
	
	$words = str_replace('_',' ',$v);
	$words = ucwords($words);
	if($words == 'Name F'){
		$words = 'First Name';
	}
	if($words == 'Name L'){
		$words = 'Last Name';
	}
	echo "<tr>";
	echo "<td>";
	echo "<span id = 'rep{$v}'>";
	echo "<button name = '{$v}' id = '{$v}' onclick = 'addField(this.id);'> ADD </button>";
	echo "</span>";
	echo "</td>";
	echo "<td> {$v} </td>";
	echo "<td>";
	echo "<input type = 'text' name = '{$v}-name' id = '{$v}ID' value = '{$words}'>";
	echo "</td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";
formForm("{$htmlRoot}/reportGen3.php","post");
//function formInput($name,$type,$value,$param){
formInput("table","hidden",$table);
echo "<div class = 'twoThirds'>";
echo "<textarea name = 'arrayText' id = 'fieldsArray'></textarea>";

hr();

echo "<div id = 'verbal'>";

echo"</div>"; //verbal
echo "</table>";

echo "</div>"; // twoThirds

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
<script>
///////////////////////////////
// Validate the field exists //
///////////////////////////////

function validate(){
	var $data = document.getElementById("readyTable").value;
	if($data == ''){
		alert("Please Select A Table");
		return false;
	}
}
/////////////////////////////////////////////////
// Add key value pairs to an array and display //
/////////////////////////////////////////////////
function addField($field){
	// friendly name => field name;
	$getName = $field+"ID";
	var $fieldName = document.getElementById($getName).value;
	var $newData =$fieldName+"="+$field;
	var $current = document.getElementById("fieldsArray").innerHTML.replace(/(^\s*,)|(,\s*$)/g, '');
	var $curVerbal = document.getElementById("verbal").innerHTML;
	var $newVerbal = 'Field "'+$field+'" will be used, and will be called "'+$fieldName+'"<br>';
	document.getElementById("fieldsArray").innerHTML=$current+","+$newData;
	$newButton = "<button name = '"+$field+"' id = '"+$field+"' onclick = 'removeField(this.id);'> REMOVE </button>";
	document.getElementById("rep"+$field).innerHTML=$newButton;
	var $compiledVerbal = $curVerbal+$newVerbal;
	document.getElementById("verbal").innerHTML=$compiledVerbal;
	//alert($newData);
}

function removeField($field){
	// friendly name => field name;
	$getName = $field+"ID";
	var $fieldName = document.getElementById($getName).value;
	var $newData =$fieldName+"="+$field;
	var $current = document.getElementById("fieldsArray").innerHTML.replace(/(^\s*,)|(,\s*$)/g, '');
	var $curVerbal = document.getElementById("verbal").innerHTML;
	var $newVerbal = 'Field "'+$field+'" will be used, and will be called "'+$fieldName+'"<br>';
	$curVerbal = $curVerbal.replace($newVerbal,'');
	$current = $current.replace($newData,'');
	$current = $current.replace(',,',',');
	document.getElementById("fieldsArray").innerHTML=$current;
	document.getElementById("verbal").innerHTML=$curVerbal;
	$newButton = "<button name = '"+$field+"' id = '"+$field+"' onclick = 'addField(this.id);'> ADD </button>";
	document.getElementById("rep"+$field).innerHTML=$newButton;
	//alert($newData);
}



</script>
</body>
</html>

