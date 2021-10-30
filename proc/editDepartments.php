<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("../inc/init.php");


$new = $_POST['NEW']; // get it
unset($_POST['NEW']); // unset it
$test = str_replace(" ","",$new);
if($test != ""){ // if there is anything but space
	$ins = "INSERT INTO departments (title) VALUES ('{$new}')";
//	echo $ins;
	$do = mysql_query($ins) or die(mysql_error());
}

foreach($_POST as $k => $v){
	$key = str_replace('title_','',$k);
	//echo "$key = $v <br>";
	$upd = "UPDATE departments SET title = '{$v}' WHERE id = '{$key}'";
	$do = mysql_query($upd);
}

$_SESSION['message'] = "msg:The Departments List Has Been Updated";
header("location: {$htmlRoot}/editDepartments.php");
//echo "done";
?>

