<?php
session_start();
// facilitySwitch.php
// Nik Rubenstein -- 11-26-2014
// ajax facility switcher

require("../inc/db.php");
require("../inc/functions.php");
$table = $_GET['table'];
$div = $_GET['div'];

//echo "$div -- howdy! -- $table";

$ar = array();
//$sql = "SELECT * FROM $table LIMIT 1";
$sql = "SHOW COLUMNS FROM $table";
$go = mysql_query($sql);
while ($row = mysql_fetch_array($go)){
	$field = $row[0];
	//echo "<td> {$field} </td>";
	array_push($ar,$field);
}
//echo "<select name = '$div'>";
echo "<table class = 'selectTheseFields'>";
echo "<tr>";
echo "<th> Field </th>";


foreach($ar as $k=>$v){
	echo "<td> {$v} </td>";

}

echo "</tr>";
echo "<tr>";
echo "<th> Include </th>";
foreach($ar as $k=>$v){
	$tf = "{$table}_{$v}";
	echo "<td> <input type = 'checkbox' name = 'BOX{$tf}'></td>";
}
echo "</tr>";
echo "<tr>";
echo "<th> Name </th>";
foreach($ar as $k=>$v){
	$tf = "{$table}_{$v}";
	echo "<td> <input type = 'text' size = '10' name = 'TEXT{$tf}'></td>";
}

echo "</tr>";
echo "</table>";
?>

