<?php
require("inc/init.php");
echo "working!";
hr();


//function doubleBook($user,$field,$start,$dur,$thresh){
$test = doubleBook(2,'patient',1422381600,60,15);
echo "Test = ";
print_r($test);
?>
