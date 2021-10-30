<?php
//dete department and re-assign users
//$SECURE = TRUE;
require("../inc/init.php");


$deletedClinicID = $_GET['del'];
$getClinicID = $_GET['cl'];

$clinicID = $_GET['c'];

$clinicHistory = $_GET['history'];
$sqlSelectData = "SELECT id FROM clinics WHERE history = '$clinicHistory'";
$result = mysql_query($sqlSelectData);
$row = mysql_fetch_assoc($result);

$result2 =  $_GET['rep'];


$clinisUpdate = "UPDATE clinics SET history = '$deletedClinicID' WHERE id = '$result2' ";
$sqlHistoryIntoClinic = mysql_query($clinisUpdate);


$del = $_GET['del'];
$rep = $_GET['rep'];


$sql = "SELECT title FROM clinics WHERE id = '{$del}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$delete = $row['title'];
$count = 0;
if($rep != 'NONE'){

	$sql = "SELECT title FROM clinics WHERE id = '{$rep}'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	$replace = $row['title'];

	echo "Replacing all appointments containing clinic \"{$delete}\" with department \"{$replace}\". <br><br>"; 


	$sql = "SELECT id FROM appointment_requests WHERE clinic = '{$del}'";
	$go = mysql_query($sql);
	while($row = mysql_fetch_assoc($go)){
	$count++;
		$repID = $row['id'];
		$sq2 = "UPDATE appointment_requests SET clinic = '{$rep}' WHERE id = '{$repID}'";
		//echo "{$sq2} <br>";
		$replace = mysql_query($sq2);
	}
}
echo "{$count} appointments have been altered. <br><br>";

echo "Deleteing clinic \"{$delete}\". <br>";
$sq3 = "DELETE FROM clinics WHERE id = '{$del}'";
$go = mysql_query($sq3);
echo "Done! <br><br>";

echo "<a href = '/portal/viewClinics.php' style = 'border:1px solid #000;padding:5px 3px 5px 3px;background-color:#ccc;'> Close </a>";

?>

