<?php
$SECURE = TRUE;
require_once("../inc/init.php");
// edit clinics
// nik Rubenstein 1-21-2014

//print_r($_POST);
$c = $_POST['delID'];
$sql = "DELETE FROM clinics WHERE id = '{$c}'";
$go = mysql_query($sql)or die(mysql_error());
$_SESSION['message'] = "msg:Clinic Deleted";
header("location: {$htmlRoot}/viewClinics.php");
?>
