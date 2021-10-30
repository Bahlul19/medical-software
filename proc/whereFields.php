<?php
session_start();


// wherewFields.php
// Nik Rubenstein -- 12-15-2014
// ajax where clause generator for reports

require("../inc/db.php");
require("../inc/functions.php");
$table = $_GET['q'];
//print_r($table);
echo "<b>Filter By</b><hr>";
$ar = array();
$sql = "SHOW COLUMNS FROM $table";
	$go = mysql_query($sql);
	//$row = mysql_fetch_array($go);
	while($row = mysql_fetch_array($go)){
		array_push($ar,$row[0]);
	}
	echo "<div id = 'tempNow'>";
		echo "<select id = 'tempField'>";
			foreach($ar as $k=>$v){
				echo "<option name = '{$v}' value = '{$v}'>{$v}</option>";
			}
		echo "</select>";
		echo " IS ";
		echo "<select id = 'tempLike'>";
			echo "<option value = 'LIKE'>LIKE</option>";
			echo "<option value = '='>EQUAL TO</option>";
			echo "<option value = '!='>NOT EQUAL TO</option>";
		echo "</select>";
		echo "<input id = 'tempClause' type = 'text' value = 'ANY'>";
	
		echo "<select id = 'tempDone' onchange = 'addSQL(this.value);'>";
			echo "<option value = 'select'>Select One</option>";
			echo "<option value = 'AND'>AND</option>";
			echo "<option value = 'OR'>OR</option>";
			echo "<option value = 'DONE'>DONE</option>";
		echo "</select>";
		echo "<div id = 'tempNew'></div>";
	echo "</div>";
	
	
	echo "<button value = 'DONE' onclick='makeArray(this.value);'> NEXT </button>";
?>


