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
		Report Generation Wizard: STEP 5 - Select Replacement Values
		</div>
		<div class = 'instructions'>
			Save Some stuff.
		</div>
		<hr>

<?php
$table = $_POST['table'];
$fields = $_POST['fields'];
$sequel = $_POST['sequel'];
//$sequel = str_replace('%20',' ',$sequel);



formForm("{$htmlRoot}/reportSave.php","post");

echo "Table: ";
formInput("table","text",$table);


echo "Fields: ";
echo "<textarea name = 'fields'>{$fields}</textarea>";


echo "Filter: ";
echo "<textarea name = 'sequel'>{$sequel}</textarea>";

$replacements = array();
foreach($_POST as $k => $v){
	if($v == 'ON'){
		//echo "{$k} = {$v} -- ";
		$kk = "{$k}--name";
		$vv = $_POST[$kk];
		//echo "{$kk} = {$vv} <br>";
		$replacements[$k] = $vv;
	}
}
$replace = array();

foreach($replacements as $k => $v){
	$ch = explode(":",$k);
	$field2replace = $ch[0];
	$fromTable = $ch[1];
	$replaceWith = $ch[2];
	$friendlyName = $v;
	
	if($replace[$field2replace]){
		$now = $replace[$field2replace];
		$new = "($replaceWith,{$friendlyName})";
		$next = $now . $new;
		$replace[$field2replace] = $next;
//	echo "Ya";
	} else {
		$now = "{$fromTable}-";
		$new = "($replaceWith,{$friendlyName})";
		$next = $now . $new;
		$replace[$field2replace] = $next;
//	echo "no";
	}
	
	
}

$replaceString='';
foreach($replace as $k => $v){
$replaceString.="[{$k}={$v}]";

}
echo "Replace: ";
echo "<textarea name = 'replacements'>";
echo $replaceString;
echo "</textarea>";
hr();
echo "Give a name to this report: ";
formInput("reportName","text");
echo "<br>";
echo "Allow the following types of user to run this report: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | ";
$sql = "SELECT * FROM roles";
$go = mysql_query($sql);
while ($row = mysql_fetch_row($go)){
	$k = $row[0];
	$v = $row[1];
	echo "{$v} -";
	formInput($k,"checkbox",$k);
	echo " | ";
}

clearfix();
hr();
echo "<div class = 'buttonBoard'>";


formInput('submit','submit','NEXT','class = "nextButton"');
formClose();
clearfix();

echo "</div>";

?>
	</div>
</div>

</body>
</html>

