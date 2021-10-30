<?php
session_start();
// facilitySwitch.php
// Nik Rubenstein -- 11-26-2014
// ajax facility switcher

require("../inc/db.php");
require("../inc/functions.php");
$table = $_GET['q'];


	$ar = array();
	//$sql = "SELECT * FROM $table LIMIT 1";
	$sql = "SHOW COLUMNS FROM $table";
	$go = mysql_query($sql);
	//$row = mysql_fetch_array($go);
	while($row = mysql_fetch_array($go)){
		//print_r($row);hr();
		array_push($ar,$row[0] . "::" . $row[1]);
	}
//	print_r($ar);

//$ar = getFields($table);
echo "<b> Table: $table </b><br>";
echo "<table class = 'selectFields'>";
echo "<tr>";
echo "<th>Field</th>";
echo "<th> Type </th>";
echo "</tr>";
foreach($ar as $k => $v){
	echo "<tr>";
	$ch = explode('::',$v);
	$field = $ch[0];
	$fieldType = $ch[1];
	echo "<th> $field </td>";
	echo "<td> $fieldType </td>";
	echo "</tr>";
}
echo "</table>";

?>

