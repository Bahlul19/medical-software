<?php
//dete department and re-assign users
//$SECURE = TRUE;
require("../inc/init.php");




$del = $_GET['del'];
$rep = $_GET['rep'];

$sql = "SELECT language FROM languages WHERE id = '{$del}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$delete = $row['language'];

$sql = "SELECT language FROM languages WHERE id = '{$rep}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$replace = $row['language'];

echo "Replacing all patients containing language \"{$delete}\" with language \"{$replace}\". <br><br>"; 

$count = 0;


$sql = "SELECT id FROM patients WHERE language = '{$del}'";
$go = mysql_query($sql);
while($row = mysql_fetch_assoc($go)){
$count++;
	$repID = $row['id'];
	$sq2 = "UPDATE patients SET language = '{$rep}' WHERE id = '{$repID}'";
	//echo "{$sq2} <br>";
	$replace = mysql_query($sq2);
}

echo "{$count} patients have been altered. <br><br>";

echo "Deleteing language \"{$delete}\". <br>";
$sq3 = "DELETE FROM languages WHERE id = '{$del}'";
$go = mysql_query($sq3);
echo "Done! <br><br>";




//echo "This is a result {$l} <br>";
echo "<a href = '/portal/editLanguages.php' style = 'border:1px solid #000;padding:5px 3px 5px 3px;background-color:#ccc;'> Close </a>";

?>

