<?php
// passChange.php
// Nik Rubenstein -- 3-5-2014

require("../inc/init.php");

$del = $_POST['delID'];
$sql = "DELETE FROM users WHERE id = '{$del}'";
$go = mysql_query($sql)or die (mysql_error());

		header("location: {$htmlRoot}/viewInterpreters.php");


?>
