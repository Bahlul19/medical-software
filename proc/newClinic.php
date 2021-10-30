<?php
// proc/newFacility.php
// new clinic processor
// Nik RUbenstein 12-10-2014

require('../inc/init.php');
$clinicID = $_POST['clinicID'];
$hqTitle = $_POST['facTitle'];
$adr1 = $_POST['adr1'];
$adr2 = $_POST['adr2'];
$adrCity = $_POST['adrCity'];
$adrState = $_POST['adrState'];
$adrZip = $_POST['adrZip'];
$email = $_POST['email'];
$ph1 = $_POST['phone1'];
$ph2 = $_POST['phone2'];
$fax = $_POST['fax'];
$note =$_POST['note'];


// Now we insert the hq
$sql = "INSERT INTO clinics(clinic_id,title,addr_1,addr_2,addr_city,addr_state,addr_zip,email,phone_1,phone_2,fax,note)";
$sql .= " VALUES ";
$sql .= "('{$clinicID}','{$hqTitle}','{$adr1}','{$adr2}','{$adrCity}','{$adrState}','{$adrZip}','{$email}','{$ph1}','{$ph2}','{$fax}','{$note}' )";

$go = mysql_query($sql)or die(mysql_error());
$hqID = mysql_insert_id();
// that done we header out
header("location: {$htmlRoot}/viewClinics.php");
?>
