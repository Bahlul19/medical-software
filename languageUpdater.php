<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");

$sql = "SELECT id, patient, language FROM appointment_requests WHERE language = '0'";
$go = mysql_query($sql);
while($row = mysql_fetch_assoc($go)){
	echo "{$row['id']} -- {$row['patient']} -- {$row['language']} -- ";
	$thisId = $row['id'];
	$thisPat = $row['patient'];
	$S2 = "SELECT language FROM patients WHERE id = '{$thisPat}'";
	$g2 = mysql_query($S2);
	$r2 = mysql_fetch_assoc($g2);
	$newLang = $r2['language'];
	echo "{$newLang} <hr>";
	$upd = "UPDATE appointment_requests SET language = '{$newLang}' WHERE id = '{$thisId}'";
	$g3 = mysql_query($upd);
}


?>
