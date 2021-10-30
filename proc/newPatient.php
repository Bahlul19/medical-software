<?php
// proc/newClinic.php
// new clinic processor
// Nik RUbenstein 12-10-2014

require('../inc/init.php');
$postData = $_POST;


 
$ret = $_GET['ret'];
if($_POST['clinicID'] != ''){
	$postData['clinic_id'] = $_POST['clinicID'];
} else {
	$postData['clinic_id'] = $_POST['clinic_id'];
}
$postData['facility_id'] = $_POST['facility_id'];

$m = $postData['dobM'];
$d = $postData['dobD'];
$y = $postData['dobY'];
$dob = "{$m}/{$d}/{$y}";

$fname = $postData['name_f'];
$lname = $postData['name_l'];
$phone = $postData['phone'];
$facID = $_POST['facility_id'];

// We search for a match in the existing table
$testQL = "SELECT id FROM patients WHERE name_f LIKE '{$fname}%' AND name_l LIKE '{$lname}' ";
$testQL .= " AND dob = '{$dob}' AND phone = '{$phone}' ";
$testQL .= " AND facility_id = '{$facID}'";
$testIT = mysql_query($testQL)or die(mysql_error());
$testROW = mysql_fetch_assoc($testIT);
$testHIT = $testROW['id'];

//echo $testQL;
//hr();

if($testHIT){
	//die("This Patient Already Exists"); // do something better here
	//$loadPat = $_GET['p'];
	$_SESSION['message'] = "err:This Patient Already Exists";
	//header("location: ../viewPatients.php?p={$testHIT}");
	header("location: ../searchPatients.php?p={$testHIT}");
	//echo "err:This Patient Already Exists.............";
	exit;
} else {
		$_SESSION['message'] = "msg:New Patient Created Successfully";
		//echo "msg:New Patient Created Successfully.............";
	//echo "testhit = {$testHIT}";



	unset($postData['dobM'],$postData['dobD'],$postData['dobY'],$postData['submit'],$postData['clinicID']);
	$postData['dob'] = $dob;


	// new language processor
	if($postData['language'] == 'other' && $postData['newLanguage'] != ''){

	//	$nowLang = newLanguage($newLang);
	//	unset($postData['newLanguage']);
	//	$postData['language'] = $nowLang
		
	//	echo "<hr> NEW LANGUAGE !!! <hr>";  
		$newLang = $postData['newLanguage'];
	//	echo "<hr> $newLang <hr>";
		$nowLang = newLanguage($newLang);
		unset($postData['newLanguage']);
		$postData['language'] = $nowLang;
		
	}



	//print_r($postData);

	// create new patient by inserting dob
	$sql = "INSERT INTO patients (dob) VALUES ('{$dob}')";

	//echo "<hr>";
	//echo $sql;

	$go = mysql_query($sql);
	$newPatient = mysql_insert_id();



	// now update the table with patient data.
	updateTable('patients','id',$newPatient,$postData);



	// that done we header out
	if($ret == 'search'){
		//echo "searchPatients.............";
		header("location: {$htmlRoot}/searchPatients.php?p={$newPatient}");
	} else {
		//echo "viewPatients.............";
		header("location: {$htmlRoot}/viewPatients.php");
	}

}



?>
