<?php
// clinicSwitch.php
// Nik Rubenstein -- 12-01-2014
// ajax clinic switcher

require("../inc/init.php");
$newClin = $_GET['q'];
$sql = "SELECT * FROM facilityredo WHERE clinic_id = '{$newClin}' ORDER BY title ASC";
$go = mysql_query($sql);

$_SESSION['activeClinic'] = $newClin;
while ($row = mysql_fetch_assoc($go)){
	$facID = $row['id'];
	$facTitle = $row['title'];
	echo "<option value = '{$facId}'> {$facTitle} </option>";
}
?>

