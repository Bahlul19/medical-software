<?php
// clinicSwitch.php
// Nik Rubenstein -- 12-01-2014
// ajax clinic switcher

require("../inc/init.php");
$fn = $_GET['fn'];
$ln = $_GET['ln'];
$dob = $_GET['dob'];
$lang = $_GET['lang'];
$ands = array();
if($fn != ''){
	$ands['name_f'] = $fn;
}
if($ln != ''){
	$ands['name_l'] = $ln;
}
if($dob != '' && $dob != 'mm/dd/yyyy'){
	
	$dob = str_replace('01/','1/',$dob);
	$dob = str_replace('02/','2/',$dob);
	$dob = str_replace('03/','3/',$dob);
	$dob = str_replace('04/','4/',$dob);
	$dob = str_replace('05/','5/',$dob);
	$dob = str_replace('06/','6/',$dob);
	$dob = str_replace('07/','7/',$dob);
	$dob = str_replace('08/','8/',$dob);
	$dob = str_replace('09/','9/',$dob);
	$ands['dob'] = $dob;
}

if($lang != '' && $lang != 'ANY' ){
	$ands['language'] = $lang;
}

$sql = "SELECT id FROM patients WHERE ";

$andStr = '';
foreach($ands as $kk => $vv){
	if ($andStr != ''){
		$andStr .= " AND ";
	}
	if($kk == 'language'){
		$andStr .= " {$kk} = '{$vv}' ";
	} else {
	   // $andStr .= " {$kk} LIKE '%{$vv}%' ";
	    $andStr .= " {$kk} = '{$vv}' ";
	}
} 
$sql .= $andStr;
//echo $sql;
$go = mysql_query($sql);
$results = array();
while($row = mysql_fetch_assoc($go)){
	$res = $row['id'];
	array_push($results,$res);
}
$final = implode(',',$results);
if($final == ''){
	$final = '0';
}
echo $final;
?>


