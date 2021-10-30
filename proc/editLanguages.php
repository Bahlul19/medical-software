<?php

$SECURE = TRUE;
require("../inc/init.php");



$NEW = $_POST['NEW'];
$posted = $_POST;
unset($posted['NEW']);
if($NEW){
	$NEW = str_replace("'","-",$NEW);
	$NEW = str_replace('"',"-",$NEW);
	$NEW = str_replace(';',"-",$NEW);
	echo "Adding new language \"{$NEW}\" to the database <hr>";
	$sql = "INSERT INTO languages (language) VALUES ('{$NEW}')";
	$go = mysql_query($sql);
}
foreach($posted as $k => $v){
	$parts = explode('_',$k);
	$key = $parts[1];
	$title = $v;
	$sql = "SELECT language FROM languages WHERE id = '{$key}'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	$lang = $row['language'];
	//echo "$key -- $title ---- $lang <br>";
	if($title != $lang){
		echo "Changing $lang to $title <br>";
		$sub = "UPDATE languages SET language = '{$title}' WHERE id = '{$key}'";
		$go2 = mysql_query($sub);
	
	}
}

echo "<hr> <a href = '/portal/editLanguages.php'> DONE! GO BACK </a>";


?>

