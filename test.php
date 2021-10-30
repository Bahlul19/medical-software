<?php
$SECURE = TRUE;
$rep = $_GET["r"];
require("inc/init.php");

$to = 'n.rubenstein@cosmicumbrella.com';
$sub = "TEST MESSAGE";
$body = "This is a test";
$heads = "From: n.rubenstein@cosmicumbrella.com";
$x = mail($to,$sub,$body,$heads);

echo $x;
hr();

?>


