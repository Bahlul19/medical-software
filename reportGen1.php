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
		Report Generation Wizard: STEP 1 - Select A Primary Table
		</div>
		<div class = 'instructions'>
		Step 1: Select a primary table from the list at left by clicking the table and then clicking the "NEXT" button.
		 When a table is selected, the column names, and data types will be displayed. Use this information 
		 to assure that you have chosen the correct table. No table is selected for the report until the "NEXT" button 
		 has been pressed.		
		</div>
		<hr>
<?php
$tables = getTables();
echo "<div class = 'tableList'>";
echo "<b> Select A Table </b><br>";
foreach($tables as $k=>$v){
	echo "<button class = 'tableButton' value = '{$v}' onclick = 'readyTable(this.value);'> {$v} ";
	echo "</button><br>";// &nbsp; &nbsp; &nbsp;";
}
echo "</div>";
echo "<div id = 'tableColumns'></div>";
echo "<div class = 'tableSelected'>";
echo "<b> Selected Table </b><br>";
formForm("{$htmlRoot}/reportGen2.php","post");
formInput("readyTable","text","","id = 'readyTable' readonly = 'true'");
br();
formInput("submit","submit","NEXT","onclick = 'return validate();' class = 'nextButton'");
formClose();
echo "</div>";
clearfix();
echo "</div></div>";
require("scripts.php");
?>
<script>
/////////////////////////////////////////
// Ready a table in the selected field //
/////////////////////////////////////////
function readyTable($str){
	document.getElementById('readyTable').value=$str; // move the field name to the input line.
	showFields($str); // run show field.
}

//////////////////////////////////////////////////////////
// Show fields In A Selected Table /proc/showFields.php //
//////////////////////////////////////////////////////////
function showFields($str){ 
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("tableColumns").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/showFields.php?q="+$str,true);
	xmlhttp.send();
}
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
</script>
</body>
</html>

