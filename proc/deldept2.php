<?php
//dete department and re-assign users
//$SECURE = TRUE;
require("../inc/init.php");




$del = $_GET['del'];
$rep = $_GET['rep'];


$sql = "SELECT title FROM departments WHERE id = '{$del}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$delete = $row['title'];
$count = 0;
if($rep != 'NONE'){

	$sql = "SELECT title FROM departments WHERE id = '{$rep}'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	$replace = $row['title'];

	echo "Replacing all appointments containing department \"{$delete}\" with department \"{$replace}\". <br><br>"; 


	


	$sql = "SELECT id FROM appointment_requests WHERE department = '{$del}'";
	$go = mysql_query($sql);
	while($row = mysql_fetch_assoc($go)){
	$count++;
		$repID = $row['id'];
		$sq2 = "UPDATE appointment_requests SET department = '{$rep}' WHERE id = '{$repID}'";
		//echo "{$sq2} <br>";
		$replace = mysql_query($sq2);
	}
}
echo "{$count} appointments have been altered. <br><br>";

echo "Deleteing department \"{$delete}\". <br>";
$sq3 = "DELETE FROM departments WHERE id = '{$del}'";
$go = mysql_query($sq3);
echo "Done! <br><br>";




//echo "This is a result {$l} <br>";
echo "<a href = '/portal/editDepartments.php' style = 'border:1px solid #000;padding:5px 3px 5px 3px;background-color:#ccc;'> Close </a>";

?>

