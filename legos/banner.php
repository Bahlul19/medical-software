<?php
// banner.php
// Nik Rubenstein -- 11-26-2014
// Ye olde Banner with login / out.
echo "<div class = 'topBar'>";
echo $todayHuman;
echo "</div>";
echo "<div class = 'banner'>";
	echo "<div class = 'bLeft'>";
		echo "<img src = '{$img}/bannerlogo.png' height = '100%'>";
	echo "</div>";
	
	echo "<div class = 'bRight'>";
	if($_SESSION['logged']){
		require("{$legos}/logout.php");
	} else {
		//require("{$legos}/login.php");
	}
	echo "</div>";
echo "</div>";
clearfix();
?>
