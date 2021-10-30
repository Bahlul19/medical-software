<?php
require("../inc/init.php");
// proc newUser.php
// make a new user of the selected type.
// nik rubenstein 12-12-2014


// get an array to work with;
$data = $_POST;
//print_r($data);

// get non-user table info
$gender = $data['gender'];
$l1 = $data['language1'];
$l2 = $data['language2'];
$l3 = $data['language3'];
$l4 = $data['language4'];
$rn = $data['roster'];
$re = $data['rosterDate'];


// unset it
unset($data['gender']);
unset($data['language1']);
unset($data['language2']);
unset($data['language3']);
unset($data['language4']);
unset($data['roster']);
unset($data['rosterDate']);
unset($data['submit']);

// clean facility field
$fc = $_POST['facility'];
$data['facility'] = $fc;
unset($data['facility_id']);

// clean passwords field and create hash
$pass = $data['pass1'];
$pass = md5($pass);
unset($data['pass1']);
unset($data['pass2']);
$data['password']=$pass;

// data is now clean;
// we do the user table insert;
//function insertMany($table,$array){
$newUserID = insertMany('users',$data);

// now if they are an interpreter we do an array of data for that table

if($data['role'] == 5){
///	echo "<hr> INTERPRETER <hr>";
	$info = array(
		'gender'=>$gender,
		'language_1'=>$l1,
		'language_2'=>$l2,
		'language_3'=>$l3,
		'language_4'=>$l4,
		'roster_number'=>$rn,
		'roster_expiration'=>$re,
		'id'=>$newUserID
	);
	$interp = insertMany('interpreters',$info);
}

header("location: {$htmlRoot}/viewUsers.php?hi=id&hiVal={$newUserID}");



?>
