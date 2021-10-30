<?php
require_once("inc/init.php");

$s = "SELECT * FROM patients limit 1";
$g = mysql_query($s);
$r = mysql_fetch_assoc($g);
print_r($r);

?>
