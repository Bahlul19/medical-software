<?php
$SECURE = TRUE;
require_once("../inc/init.php");
// edit users
// nik Rubenstein 3-7-2015

$thisID = $_POST['id'];

unset($_POST['ignore']);

if($_POST['role'] == '5'){ //if they are an interpreter
	$intPost = array();
	$intPost['roster_number'] = $_POST['roster_number'];
	$intPost['roster_expiration'] = $_POST['roster_expiration'];
	$intPost['gender'] = $_POST['gender'];
	$intPost['language_1'] = $_POST['language_1'];
	$intPost['language_2'] = $_POST['language_2'];
	$intPost['language_3'] = $_POST['language_3'];
	$intPost['language_4'] = $_POST['language_4'];
	
}
//print_r($_POST);
//hr();


unset($_POST['roster_expiration']);
unset($_POST['roster_number']);
unset($_POST['password']);
unset($_POST['gender']);
unset($_POST['language_1']);
unset($_POST['language_2']);
unset($_POST['language_3']);
unset($_POST['language_4']);
//print_r($_POST);
//hr();

//print_r($intPost);

//unset($_POST['ignore']);
//print_r($_POST);

updateTable('users','id',$thisID,$_POST);

if($_POST['role'] == '5'){
	updateTable('interpreters','id',$thisID,$intPost);
}
header("location: {$htmlRoot}/viewInterpreters.php");

?>
