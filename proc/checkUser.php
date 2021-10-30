<?php
// proc/newClinic.php
// new clinic processor
// Nik RUbenstein 12-10-2014

require('../inc/init.php');
$testU = $_GET['u'];
$sql = "SELECT id, uname FROM users WHERE uname = '{$testU}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
if($row['uname'] != ''){
	echo "<div style = 'width:50%;float:left;'>&nbsp;</div>";
	echo "<span style = 'color:#FF0000;font-size:.8em;'>Sorry, the user name \"{$testU}\" is taken.</span>";

}/* else {
	echo "<div style = 'width:50%;float:left;'>&nbsp;</div>";
	echo "<span style = 'color:#00FF00;'>This user name is available</span>";

}
*/

?>
