<?php
session_start();
// facilitySwitch.php
// Nik Rubenstein -- 11-26-2014
// ajax facility switcher

require("../inc/db.php");
require("../inc/functions.php");
$string = $_GET['q'];
//print_r($string);

$parts = explode(':',$string);
$fields = str_replace(']','',$parts[1]);
echo "<b>Replace Values</b><hr>";
echo "<table class = 'selectSubFields'>";
echo "<tr> <th> Replace </th> <th> With Data From Table </th><th>Columns</th></tr>";
$kv = explode(',',$fields);

$tables = getTables();
$tables = implode(',',$tables);

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

echo "<button name = 'next' value = 'next'> Next </button>";
//formSelect('toot',$tables);
/*


$ar = array();
//$sql = "SELECT * FROM $table LIMIT 1";
$sql = "SHOW COLUMNS FROM $table";
$go = mysql_query($sql);
//$row = mysql_fetch_array($go);
while($row = mysql_fetch_array($go)){
array_push($ar,$row[0]);

//}



echo "<table border = '1'>";
echo "<tr>";
echo "<th>Use</th>";
echo "<th> Field </th>";
echo "<th> As Name </th>";
echo "</tr>";
foreach($ar as $k => $v){
		$words = str_replace('_',' ',$v);
		$words = ucwords($words);
		echo "<tr>";
		echo "<td><input type = 'checkbox' name = '{$v}' id = '{$v}' onclick = addField(this.id)> </td>";
		echo "<td> {$v} </td>";
		echo "<td><input type = 'text' name = '{$v}-name' id = '{$v}ID' value = '{$words}'></td>";
		echo "</tr>";
}
echo "<tr><td></td><td></td>";
echo "<td><button value = 'next' onClick = 'makeArray();'>Next </button></td></tr>";
echo "</table>";

*/

?>

