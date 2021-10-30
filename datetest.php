<?php
$midnightToday = date("m/d/Y");
echo $midnightToday;
echo "<hr>";
$midnightToday = strtotime($midnightToday);
echo $midnightToday;
$midnightTomorrow = $midnightToday + 86400;



echo "<hr><hr>";
echo "Date Time Now: ";
$d = date("M/d/Y H:i:s");
echo $d; 
?>
