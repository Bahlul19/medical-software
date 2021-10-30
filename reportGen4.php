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
	border-right: 1px solid #0000FF;
	padding:0px 5px;
}

.lineUp{
border-right:1px solid #000000;
background-color:#DDDFFF;
float:left;

}

</style>
</head>
<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");

$table = $_POST['table'];
$fields = $_POST['fields'];
$sequel = $_POST['sequel'];
//$sequel = str_replace('%20',' ',$sequel);
?>

<div class = 'siteWrap'>
<div class = 'reportDisplay'>
		<div class = 'formTitle'>
		Report Generation Wizard: STEP 4 - Select Replacement Values
		</div>
		<div class = 'instructions'>
		Step 4: Select the values from <b>"<?php echo $table; ?>"</b> that you wish to replace with data from other 
		tables. In many cases data is stored as a numeric reference to associated data in other tables. You may 
		choose to swap one or more fields from secondary associated tables in to your report. The fields that contain associated data have been added to the columns below, along with a list of potential associations you may wish to select. 
		</div>
		<hr>
<?php

echo "Table = $table <br>";
echo "Fields = $fields <br>";
echo "Filter = $sequel <br>";
hr();

$fArray = explode(',',$fields);
$f2 = array();
foreach ($fArray as $k=>$v){
	$ch = explode('=',$v);
	$x = $ch[1];
	$f2[$x]=$x;

}
//print_r($f2);
//hr();
$ar = getFullFields($table,'0,8');
//print_r($ar);
//hr();

formForm("{$htmlRoot}/reportGen5.php","post");

foreach($ar as $k=> $v){
	
	if(in_array($v[0],$f2)){ // if it is in the wanted fields
		
		
		if($v[1] != ''){ // and there is an associated table
			echo "<div class = 'lineUp'>";
			//	echo "<div class = 'lineItem'>";
				echo "<b> $v[0] </b> <hr>";
				$ch = explode(',',$v[1]); // then we get the table by exploding
				$assoc = $ch[0]; // and keeping the first vale
				$assocFields = getFullFields($assoc,'0'); // then we pull a list of fields
				echo "<table border = '1'>";
				foreach($assocFields as $kk=>$vv){
					echo "<tr>";
					$assocField = $vv[0];
					echo "<td>{$assocField}</td>";
					echo "<td>";
					formInput("{$v[0]}:{$assoc}:{$assocField}","checkbox","ON");
					echo "</td>";
					
	
					$words = str_replace('_',' ',$assocField);
					$words = ucwords($words);
					if($words == 'Name F'){
						$words = 'First Name';
					}
					if($words == 'Name L'){
						$words = 'Last Name';
					}
					
					
					echo "<td>";
					formInput("{$v[0]}:{$assoc}:{$assocField}--name","text",$words);
					echo "</td>";
					echo "</tr>";

				}
				echo "</table>";
			echo "</div>"; // lineUp
		} else {
			// NOT
		}
		
	} 
}

clearfix();
// heres the hidden data from the previous parts of the gen.
echo $sequel;
//$table = $_POST['table'];
//$fields = $_POST['fields'];
//$sequel = $_POST['sequel'];
formInput("table","text",$table);
formInput("fields","text",$fields);
echo "<textarea name = 'sequel'>$sequel</textarea>";
//formInput("sequel","text",$sequel);

formInput("submit","submit","NEXT","class = 'nextButton'");









?>

</div>
</div>

<script>
function replaceFields($str,$dv){
var $swap = 'swapFields'+$dv;
if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById($swap).innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/swapFields.php?table="+$str+'&div='+$dv,true);
	xmlhttp.send();
}

</script>
</body>
</html>

<?php


/*




echo "<div class = 'tableList'>";
echo "<b>Replace Values</b><hr>";
echo "<table class = 'selectSubFields'>";
echo "<tr> <th> Replace </th> <th> With Data From Table </th><th>Columns</th></tr>";
$kv = explode(',',$fields);

$tables = getTables();
$tables = implode(',',$tables);


formForm("{$htmlRoot}/reportGen4.php","post");
foreach($kv as $k => $v){

	$v = explode('=',$v);
	$v = $v[1];
	echo "<tr>";
	echo "<td> $v </td>";
	echo "<td>";
	formSelect("rep{$k}",$tables,"onchange = 'replaceFields(this.value,$k);'");
	echo "</td>";

	echo "<td id = 'swapFields{$k}'>";
	echo "No Replacement";
	echo "</td>";
	echo "</tr>";
}

//echo "</td>";


echo "</table>";
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


*/

?>
