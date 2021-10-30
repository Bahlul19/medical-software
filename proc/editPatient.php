<?php
$SECURE = TRUE;
require_once("../inc/init.php");
// edit patient
// nik Rubenstein 1-21-2014

$thisID = $_POST['id'];
//unset($_POST['ignore']);
//print_r($_POST);

updateTable('patients','id',$thisID,$_POST);
header("location: {$htmlRoot}/viewPatients.php");

?>
