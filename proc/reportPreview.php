<?php
session_start();
// facilitySwitch.php
// Nik Rubenstein -- 11-26-2014
// ajax facility switcher

require("../inc/db.php");
require("../inc/functions.php");

//print_r($_GET);
$table = $_GET['t'];
$filter = $_GET['f'];
$cols = $_GET['ft'];
/*
echo "<textarea>";
print_r($filter);
echo "</textarea>";
*/



$filter = str_replace("GT",">",$filter);
$filter = str_replace("LT","<",$filter);
$filter = str_replace("DT","<>",$filter);
$filter = str_replace("EQ","=",$filter);
$filter = str_replace("*","%",$filter);

$cols = explode(',',$cols);
$sel = array();
$fieldNames = array();
foreach($cols as $k => $v){
	$parts = explode('=',$v);
	$val = $parts[1];
	$fieldName = $parts[0];
	array_push($sel,$val);
	array_push($fieldNames,$fieldName);
}

$sel = implode(',',$sel);

$sql = " SELECT $sel FROM $table ";
if ($filter != '') {
	$sql .= "WHERE $filter ";
}



$test = str_replace(" ","",$sql);
//echo "TEST = $test";hr();
$check = explode('WHERE',$test);
if($check[1]==''){
	$sql = str_replace("WHERE","",$sql);
}
//echo $sql;hr();
$go = mysql_query($sql)or die("Your query is incomplete or has an error");
echo "<table border = '1'>";
	echo "<tr>";
	foreach($fieldNames as $k => $v){
		echo "<th> $v </th>";
	}
	echo "</tr>";

while($row = mysql_fetch_assoc($go)){
	echo "<tr>";
	foreach($row as $k => $v){
		echo "<td> $v </td>";
	}
	echo "<tr>";
}

echo "</table>";

?>

