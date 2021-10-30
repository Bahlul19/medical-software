<?php
session_start();
// facilitySwitch.php
// Nik Rubenstein -- 11-26-2014
// ajax facility switcher

require("../inc/db.php");
require_once("../inc/settings.php");
require("../inc/functions.php");
$newFac = $_GET['q'];
$words = $_GET['w'];
if ($words == 'undefined'){
	$words = 'For Clinic';
}
$_SESSION['activeClinic'] = $newFac;
//$words = $_SESSION['activeClinic'];
$sql = "SELECT * FROM clinics WHERE clinic_id = '{$newFac}' ORDER BY title ASC";
$go = mysql_query($sql);
formLabel('facility',"{$words}");
echo "<oneDrop>";
echo "<select name = 'clinicID' id = 'fClinic'>";
while($row = mysql_fetch_assoc($go)){
	$thisFac = $row['title'];
	$thisID = $row['id'];
	echo "<option value = '{$thisID}'> {$thisFac} </option>";
}
echo "</select>";
echo "</oneDrop>";
