<?php
// proc/newClinic.php

require('../inc/init.php');



//new code written into this section as per new requirement

$m = $_POST['dobM'];
$d = $_POST['dobD'];
$y = $_POST['dobY'];
$contracted_date = "{$y}-{$m}-{$d} 00:00:00";

// $clinicTitle = array('title'=>$_POST['title']);

// $clinicTitleInsert = insertMany('clinics',$clinicTitle);


$insert = array(
	'title' => $_POST['title'],
	'headquaters_clinic' => $_POST['headquaters_clinic'],
	'address1' => $_POST['address1'],
	'address2' => $_POST['address2'],
	'city' => $_POST['city'],
	'state' => $_POST['state'],
	'zip' => $_POST['zip'],
	'email' => $_POST['email'],
	'telephone1' => $_POST['telephone1'],
	'telephone2' => $_POST['telephone2'],
	'faxnumber' => $_POST['faxnumber'],
	'contracted_date' => $_POST['contracted_date'],
	'authorized_by' => $_POST['authorized_by']

);

$hqID = insertMany('facilityredo',$insert);

header("location: {$htmlRoot}/viewFacilities.php");

?>
