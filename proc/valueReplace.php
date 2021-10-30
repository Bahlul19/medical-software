<?php
session_start();
// facilitySwitch.php
// Nik Rubenstein -- 11-26-2014
// ajax facility switcher

require("../inc/db.php");
require("../inc/functions.php");
$table = $_GET['table'];
$field = $_GET['f'];
$data = getFullFields($table,'0,8');
foreach($data as $k => $v){
	if($v[0] == $field){
		if($v[1] != ''){ 
			$parts = explode(",",$v[1]);
			$relTable = $parts[0];
			unset($parts[0]);
			$relFields = implode(',',$parts);
			$relFields = "id,{$relFields}";
			$sql = "SELECT {$relFields} FROM {$relTable}";
			$go = mysql_query($sql) or die (mysql_error());
			echo "<select name = 'clause0' id = 'clause0'>";
			echo "<option value = '{REPLACE}'> Replace when running </option>";
			while($row = mysql_fetch_row($go)){
				
				$thisId = $row[0];
				$text = "{$thisId} ( ";
				//unset($row[0]);
				$count = count($row);
				for($i = 1;$i<$count;$i++){
					$text .= "{$row[$i]} ";
				}
				$text .= " ) ";
				echo "<option value = '{$thisId}'> $text </option>";
			}
			echo "</select>";
			//echo "</select>";
		} else { 
		// else theres not related data so echo a text field
		echo "<input type = 'text' name = 'clause0' id = 'clause0'>";
		}
	}
	
}


/*

// there's related data, so retrieve it
			
			$parts = explode(",",$v[1]);
			$relTable = $parts[0];
			unset($parts[0]);
			$relFields = implode(',',$parts);
			$relFields = "id,{$relFields}";
			//echo "Table = $relTable Fields = $relFields";
			$sql = "SELECT {$relFields} FROM {$relTable}";
			echo $sql;
			//$go = mysql_query($sql) or die (mysql_error());
			
			//echo "<select name = 'clause0' id = 'clause0'>";
			//while($row = mysql_fetch_array($go)){
		
			//echo "<input type = 'text' name = 'clause0' id = 'clause0'>";
				/*echo "<option value = '{$row[0]}'> </option>";
				unset($row[0]);
				foreach($row as $key => $val){
					echo $val . " ";
					
				
				}
				
				*/
?>

