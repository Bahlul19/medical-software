<?php
$SECURE = TRUE;
require("inc/init.php");
$perms = array();
foreach($_POST as $k=> $v){
	
	if(is_numeric($k)){
		array_push($perms,$v);
	}

}

print_r($_POST);
hr();
$report = $_POST['reportName'];
$table = $_POST['table'];
$sequel = $_POST['sequel'];
$fields = $_POST['fields'];
//$sequel = str_replace("'","",$sequel);
//$sequel = str_replace("{","",$sequel);
//$sequel = str_replace("}","",$sequel);
$replace = $_POST['replacements'];

$perms = implode(',',$perms);

$sql = "INSERT INTO reports (title,perms,tbl,fields,filter,rep) VALUES ";
$sql .= " (\"$report\",\"$perms\",\"$table\",\"$fields\",\"$sequel\",\"$replace\")";
//$sql .= " ('1','2','3','4','5')";
echo $sql;
hr();
$go = mysql_query($sql)or die (mysql_error());




?>
