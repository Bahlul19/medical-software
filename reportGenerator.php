<!doctype HTML>
<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
?>
<html>
<head>
<title> Report Generation Wizard</title>
<?php
require("{$legos}/head.php");
?>
<style>
</style>
</head>
<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>

<div class = 'siteWrap'>
<div class = 'reportDisplay'>
		<div class = 'formTitle'>
		Reports
		</div>
		<hr>
<?php
echo "<div class = 'bigMenu'>";
echo "<a href = 'reportGen1.php'> Create a new report </a>";
echo "</div>";
?>
</div>
</div>
</body>
</html>

