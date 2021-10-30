<?php

// autofill interp
// Nik Rubenstein -- 12-1-2014
// ajax autofill for inetrpeters.
require("../inc/init.php");

$del = $_POST['delID'];
$delBy = $_POST['delBy'];
$delR = $_POST['delReason'];

$sql = "SELECT * FROM appointment_requests WHERE id = '{$del}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$row['del_by'] = $delBy;
$row['del_reason'] = $delR;

//function insertMany($table,$array){
insertMany('deleted_appointments',$row);
$sql = "DELETE FROM appointment_requests WHERE id = '{$del}'";
$go = mysql_query($sql);
$_SESSION['message'] = "msg:Appointment {$del} has been deleted"; 
header("location: {$htmlRoot}/viewAppointments.php");
?>
