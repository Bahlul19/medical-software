<?php

// autofill interp
// Nik Rubenstein -- 12-1-2014
// ajax autofill for inetrpeters.
require("../inc/init.php");
if (isset($_GET['term'])){
	$term = $_GET['term'];
	$return_arr = array();
	$sql = "SELECT id, name_f, name_l FROM users WHERE (name_l LIKE '%{$term}%' OR name_f LIKE '%{$term}%') AND role = '5'";
	$go = mysql_query($sql);
	while($row = mysql_fetch_assoc($go)){
		$ID = $row['id'];
		$F = $row['name_f'];
		$L = $row['name_l'];
		$return_arr[] =  $F . " " . $L . " ({$ID})";
	
	}
  //   Toss back results as json encoded array. 
    echo json_encode($return_arr);
}
?>
