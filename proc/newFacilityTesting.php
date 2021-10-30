<?php
// proc/newClinic.php
// new clinic processor
// Nik RUbenstein 12-10-2014

require('../inc/init.php');
$clinicTitle = array('title'=>$_POST['clinicTitle']);

$clinID = insertMany('facilities',$clinicTitle);

$m = $_POST['dobM'];
$d = $_POST['dobD'];
$y = $_POST['dobY'];
$contracted_date = "{$y}-{$m}-{$d} 00:00:00";

$insert = array(
	'clinic_id' => $clinID,
	'title' => $_POST['hqTitle'],
	'addr_1' => $_POST['adr1'],
	'addr_2' => $_POST['adr2'],
	'addr_city' => $_POST['adrCity'],
	'addr_state' => $_POST['adrState'],
	'addr_zip' => $_POST['adrZip'],
	'email' => $_POST['email'],
	'phone_1' => $_POST['phone1'],
	'phone_2' => $_POST['phone2'],
	'fax' => $_POST['fax'],
	'contracted_date' => $contracted_date,
	'authorized_by' => $_POST['authorized_by']


);


$hqID = insertMany('clinics',$insert);




// function updateTable($table,$col,$id,$array){
$update = array('headquarters'=>$hqID);
updateTable('facilities','id',$clinID,$update);
// now we go back and update clinics to have this hq
//$sql = "UPDATE clinics set headquarters = '{$hqID}' WHERE id = '{$clinID}'";
//$go = mysql_query($sql);


// that done we header out

// header("location: {$htmlRoot}/viewClinics.php");
header("location: {$htmlRoot}/viewFacilities.php");

?>
