<?php
$SECURE = TRUE;
require_once("../inc/init.php");
// edit clinics
// nik Rubenstein 1-21-2014

$thisID = $_POST['id'];
unset($_POST['ignore']);
//print_r($_POST);

updateTable('clinics','id',$thisID,$_POST);
header("location: {$htmlRoot}/viewClinics.php");

?>
