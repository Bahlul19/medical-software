<?php
// passChange.php
// Nik Rubenstein -- 3-5-2014

require("../inc/init.php");

//print_r($_POST);

$del = $_POST['delID'];
$sql = "DELETE FROM patients WHERE id = '{$del}'";
$go = mysql_query($sql)or die (mysql_error());

		header("location: {$htmlRoot}/viewPatients.php");


?>
