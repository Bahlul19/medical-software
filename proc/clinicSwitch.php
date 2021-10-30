<?php
// clinicSwitch.php
// Nik Rubenstein -- 12-01-2014
// ajax clinic switcher

require("../inc/init.php");
$newClin = $_GET['q'];
$sql = "SELECT * FROM clinics WHERE id = '{$newClin}' ORDER BY title ASC";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$thisClin = $row['title'];
$_SESSION['activeClinic'] = $row['id'];

//return value for xmlhttp.response
echo "$thisClin";
?>

