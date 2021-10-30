<?php
$phpRoot = '/home/itasca11/public_html/portal'; //Production

require_once("{$phpRoot}/inc/init.php"); // dev

$sql = "select * from appointment_requests limit 1";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
print_r($row);

?>
