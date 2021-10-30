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
.subMenu{

}
.subMenu a{
	background-color:#000000;
	color:#FFFFFF;
	text-decoration:none;
	padding: 5px 20px;
	margin-right:10px;
}

.subMenu a:hover{
	background-color:#333333;

}
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
echo "<div class = 'subMenu'>";
echo "<a href = '{$htmlRoot}/reportGen1.php'> Create a new report </a>";
echo "<a href = '{$htmlRoot}/reportEdit1.php'> Edit an existing report </a>";
echo "<a href = '{$htmlRoot}/reportRun1.php'> Run an existing report </a>";
echo "<a href = '{$htmlRoot}/help/reportHelp1.php'> Read the Reports help document </a>";
echo "</div>";
?>
</div>
</div>
</body>
</html>

