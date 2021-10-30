<?php
require("../inc/init.php");
$uid = $_GET['uid'];
$apt = $_GET['apt'];

//function updateTable($table,$col,$id,$array){
//$sql = "UPDATE {$table} SET {$key} = '{$value}' WHERE {$col} = '{$id}'";
$uda = array(
	'interpreter_claim' => $uid
);

// function dataGet($fieldsArray,$table,$where,$clause){
updateTable('appointment_requests','id',$apt,$uda);
echo "Replaced";

if (is_numeric($apt)){ // if there is an appointment
		$sql = "UPDATE appointment_requests SET status = '8' WHERE id = '$apt'";
		$go = mysql_query($sql); // it is now status cancel requested
	} else {
		
	}
?>

