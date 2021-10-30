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
		array_push($ar,$row[0]);
	}
echo "<b> Include These Fields </b><hr>";
echo "<table class = 'selectFields'";
echo "<tr>";
echo "<th>Use</th>";
echo "<th> Field </th>";
echo "<th> As Name </th>";
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
		echo "<td><input type = 'checkbox' name = '{$v}' id = '{$v}' onclick = addField(this.id)> </td>";
		echo "<td> {$v} </td>";
		echo "<td><input type = 'text' class = 'smallTextField' name = '{$v}-name' id = '{$v}ID' value = '{$words}'></td>";
		echo "</tr>";
}
echo "</table>";
hr();
echo "<span id = 'remIncludeButtons'>";
echo "<button value = 'clear'>Clear </button>";
echo "<button value = 'next' onClick = 'makeArray();'>Next </button>";
echo "</span>";

?>

