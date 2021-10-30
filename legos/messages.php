<?php
// messages.php
// Nik Rubenstein 11-26-2014
// Report session messages back to the user
if($_SESSION['message']){
	$message = $_SESSION['message'];
	$parts = explode(':',$message);
	$mType = $parts[0];
	$mWords = $parts[1];
	echo "<div class = 'message_{$mType}'>";
	echo $mWords;
	echo "</div>";
	unset($_SESSION['message']);
}

?>
