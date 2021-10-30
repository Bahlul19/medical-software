<?php

// autofill interp
// Nik Rubenstein -- 12-1-2014
// ajax autofill for inetrpeters.
require("../inc/init.php");
//print_r($_GET);
// function doubleBook($user,$field,$start,$dur,$thresh){
$user = $_GET['user'];
$user = explode(" ",$user);
$user = $user[0];
$field = $_GET['field'];
$st = $_GET['start'];
$ch = explode('_',$st);
//print_r($ch);
//hr();
$sd = $ch[0];
$sh = $ch[1];
$sm = $ch[2];
$sa = $ch[3];
$startString = "{$sd} {$sh}:{$sm} {$sa}";
$start = strtotime($startString);
//$start = date('U',$startUnix);
$dur = $_GET['dur'];
$thresh = $_GET['thresh'];
//print_r($_GET);
//hr();
//echo "user = {$user} -- field = {$field} -- start = {$start} -- duration = {$dur} -- Threshhold = $thresh -- startString = $startString";
$test = doubleBook($user,$field,$start,$dur,$thresh);
if($test == 'OKAY'){
	echo "OKAY";
} else {
	foreach($test as $kk => $vv){
		$hrd = date("m/d/Y",$vv);// H:i A",$vv);
		$hrt = date("H:i A",$vv);
		echo " Appointment number {$kk} on {$hrd} at {$hrt} ";
	}
	//$hrd = date("M/d/Y at H:i",$test[1]);
	//echo $test[0] . '-' . $hrd;
}
//print_r($test);
?>
