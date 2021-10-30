<?php
require_once("/var/www/portal/inc/init.php");
print_r($_GET);
$sql = $_GET['sql'];
$go = mysql_query($sql);
while($row = mysql_fetch_assoc($go)){
	print_r($row);
}

?>
