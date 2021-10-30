<?php
// autofill patients
// Nik Rubenstein -- 12-1-2014
// ajax autofill for patients
require("../inc/init.php");
if($uInfo['role'] == 3){
	$facility = $uInfo['facility']; // work this better.. make so admins see all and clinics only see theirs. also admin can select.
}
if (isset($_GET['term'])){
	$term = $_GET['term'];
	$return_arr = array();

	$sql = "SELECT * FROM patients WHERE (name_l LIKE '%{$term}%' OR name_f LIKE '%{$term}%')";
	if($uInfo['role'] == 3 || $uInfo['role'] == 4){
		$sql .= " AND facility_id = '{$uInfo['facility']}' ";
	}
	// AND clinic_id = '{$clinic}' "; // this needs help from above

	$go = mysql_query($sql);
	while($row = mysql_fetch_assoc($go)){
		$lang = $row['language'];
		$lang = $languageList[$lang];
		$return_arr[] = "{$row['id']} {$row['name_f']} {$row['name_l']} {$row['dob']} $lang";
		//{$row['insurance_id']} {$row['phone']}";
	}
	$_SESSION['returned'] = $return_arr;

  //   Toss back results as json encoded array. 
    echo json_encode($return_arr);
}


?>
