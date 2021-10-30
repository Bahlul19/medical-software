<?php

//comment this page by today 23-12-18 for the new requirement in the page

$SECURE = TRUE;
require_once("../inc/init.php");
// edit clinics

$facilityEditID = $_POST['id'];


$title = $_POST['title'];

$headquaters_clinic = $_POST['headquaters_clinic'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$email = $_POST['email'];
$telephone1 = $_POST['telephone1'];
$telephone2 = $_POST['telephone2'];
$faxnumber = $_POST['faxnumber'];
$contracted_date = $_POST['contracted_date'];
$authorized_by = $_POST['authorized_by'];

$updateQuery = "UPDATE facilityredo SET title = '{$title}', headquaters_clinic ='{$headquaters_clinic}',address1 ='{$address1}',address2 ='{$address2}',city ='{$city}',state ='{$state}',zip ='{$zip}',email ='{$email}',telephone1 ='{$telephone1}',telephone2 ='{$telephone2}',faxnumber ='{$faxnumber}', contracted_date='{$contracted_date}', authorized_by = '{$authorized_by}' WHERE id = '{$facilityEditID}'";

$hqID = mysql_query($updateQuery);

header("location: {$htmlRoot}/viewFacilities.php");

?>
