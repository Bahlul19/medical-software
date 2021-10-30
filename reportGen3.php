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

.tableList table{
border: 1px solid #000000;
	border-collapse:collapse;
}

.tableList table td{
	border-bottom: 1px solid #000000;
	padding:5px 20px;
}
.tableList td table{
	border: 2px solid #0000FF;
	border-collapse:collapse;
}
.tableList td table td{
	border-right: 2px solid #0000FF;
	padding:0px 5px;
}

#tableName{
display:none;
}

#arrayText{
display:none;
}

.sqlGen{
width:100%;
}
.sqlGen table{
	background-color:#000000;
	color:#FFFFFF;
	text-align:center;
	width:100%;
}
.sqlText {
	width:100%;
	height:100px;
	background-color:#FF00FF;
	padding:10px;
	
}

#sequel{
	/*display:none;*/
}
#editable{
	background-color:#DDDDDD;
	min-height:40px;
	padding:20px;
	border-bottom:2px solid #000000;
}
#wrong{
	background-color:#FF00FF;
	min-height:40px;
	padding:20px;
	border-bottom:2px solid #000000;
}
</style>
</head>
<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
$table = $_POST['table'];
$fields = $_POST['arrayText'];
?>
<div class = 'siteWrap'>
<div class = 'reportDisplay'>
		<div class = 'formTitle'>
		Report Generation Wizard: STEP 3 - Select Filtering and Ordering Options
		</div>
		<div class = 'instructions'>
		Step 3: Select the values from <b>"<?php echo $table; ?>"</b> that you wish to use as filtering options. You may choose to filter your results by any of the fields available in <b>"<?php echo $table; ?>"</b>. Building a good filter can be complicated, and understanding the various operators can take time. 
		</div>
<?php

// get fields name and comment;
$ar = getFullFields($table,'0,8');
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
echo "<div class = 'sqlGen'>";
	echo "<center><table>";
		echo "<tr>";
			echo "<td> Field </td>";
			echo "<td> Operator </td>";
			echo "<td> Value </td>";
			echo "<td> Add </td>";
			echo "<td> ( </td>";
			echo "<td> ) </td>";
			echo "<td> AND </td>";
			echo "<td> OR </td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
			echo "<select name = 'field0' id = 'field0' onchange = 'showAssoc(this.value);'>";
			echo "<option value = 'none' > Select a field </option>";
			foreach($ar as $k => $v){
				$fieldName = $v[0];
				$assoc = $v[1];
				echo "<option value = '$fieldName'> $fieldName </option>";
			}
			echo "</select>";
			echo "</td>";
			echo "<td>";
				echo "<select name = 'operator0' id = 'operator0'>";	
					echo "<option value = 'EQ'> Equal To </option>";
					echo "<option value = 'LIKE'> Like </option>";
					echo "<option value = 'DT'> Not Equal To </option>";
					echo "<option value = 'NOT LIKE'> Not Like </option>";
					echo "<option value = 'GT'> Greater Than </option>";
					echo "<option value = 'LT'> Less Than </option>";	
				echo "</select>";
			echo "</td>";
			echo "<td id = 'valueReplace'>";
				echo "<input type = 'text' name = 'clause0' id = 'clause0'>";
			echo "</td>";
		
		
			echo "<td>";
				echo "<button id = 'ADD_0' onclick = 'addQuery(this.id);' value = 'ADD'> ADD </button>";
			echo "</td>";
			echo "<td>";
				echo "<button id = 'LP_0' onclick = 'addQuery(this.id);' value = '('> ( </button>";
			echo "</td>";
			echo "<td>";
				echo "<button id = 'RP_0' onclick = 'addQuery(this.id);' value = ')'> ) </button>";
			echo "</td>";
			echo "<td>";
				echo "<button id = 'AND_0' onclick = 'addQuery(this.id);' value = 'AND'> AND </button>";
			echo "</td>";
			echo "<td>";
				echo "<button id = 'OR_0' onclick = 'addQuery(this.id);' value = 'OR'> OR </button>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	echo "</center>";
echo "</div>"; // sqlGen
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
echo "<button onclick = 'clearSQL();'>CLEAR</button> | ";
echo "<button id = 'PREVIEW' onclick = 'previewReport();' value = 'PREVIEW'> PREVIEW </button> | ";
echo "<button id = 'DONE_0' onclick = 'addQuery(this.id);' value = 'DONE'> DONE</button>";
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
//echo "<div class = 'buttonBoard' id = 'buttonBoard'></div>";
echo "<div id = 'editable'></div>";
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
echo "<div id = 'result'> </div>";
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
clearfix();
hr();
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
echo "<div id = 'buttonChunks'>";
	formForm("{$htmlRoot}/reportGen4.php","post");
	formInput("table","text","","id = 'sendTable'");
	formInput("fields","text","","id = 'sendFields'");
	formInput("sequel","text","","id = 'sendSequel'");
	formInput('submit','submit','NEXT','class = "nextButton"');
	formClose();
echo "</div>";
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
clearfix();


// THE HIDDEN STUFF
echo "<div id = 'tableName'>{$table}</div>";
echo "<div id = 'arrayText'>{$fields}</div>";
echo "<div id = 'sequel'></div>";
?>

<script>
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
function showAssoc($str){
	var $table = document.getElementById("tableName").innerHTML;
	//alert($table+" "+$str);
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("valueReplace").innerHTML=xmlhttp.responseText;
		} 
	}
	//xmlhttp.open("GET","/portal/proc/reportPreview.php?filter="+filter+"&table="+$table+"&fields="+fieldText,true);
	xmlhttp.open("GET","/portal/proc/valueReplace.php?table="+$table+"&f="+$str,true);
	xmlhttp.send();
}
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
function removeClause($str){
	var element = document.getElementById($str);
	element.parentNode.removeChild(element);
	makeSQL();
}
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
var $i = 0;
function addQuery($str){
	$i = $i+1;
	var $andor = document.getElementById($str).id;
	$farray = $andor.split("_");
	$action = $farray[0];
	$idnum = $farray[1];
	var $field = document.getElementById("field"+$idnum).value;
	var $op = document.getElementById('operator'+$idnum).value;
	var $clause = document.getElementById('clause'+$idnum).value;
	var $current = document.getElementById("sequel").innerHTML;
	var $currentButton = document.getElementById("editable").innerHTML;
	if($action == 'DONE'){
		goOn();
	} else if ($action == 'ADD') {
		if($op == 'LIKE'){
			$clause = '*'+$clause+'*';
		}
		var $newClause = $field+" "+$op+" '"+$clause+"' ";
		 //$newButton = '<button id = "'+$newClause+'" onclick = "removeClause(this.id)" >'+$newClause+'</button>';
	} else if ($action == 'LP') {
		var $newClause = '(';
	} else if ($action == 'RP') {
		var $newClause = ')';
	} else if ($action == 'AND') {
		var $newClause = ' AND ';
	} else if ($action == 'OR') {
		var $newClause = ' OR ';
	}
	var $newButton = '<button id = "'+$i+$newClause+'" value = "'+$newClause+'" onclick = "removeClause(this.id)" >'+$newClause+'</button>';
	var $newData = $current+$newClause+" ";
	var $newEditable = $currentButton+$newButton;
	//document.getElementById("sequel").innerHTML=$newData;
	if($action != 'DONE'){
		document.getElementById("editable").innerHTML=$newEditable;
	}
	makeSQL();
}
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
function makeSQL(){
		var $values = ' ';
	//var $currentButton = document.getElementById("editable").innerHTML;
	//document.getElementById("sequel").innerHTML=$currentButton;
	var $buttons = document.getElementById("editable").children;
	for(i=0; i < $buttons.length; i++) {
     	var $newVal = $buttons[i].getAttribute("value");
     	$values = $values+" "+$newVal;
 	}
 	document.getElementById("sequel").innerHTML=$values
 	previewReport();
}
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
function clearSQL(){
	document.getElementById("editable").innerHTML='';
	document.getElementById("sequel").innerHTML='';
}
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
function previewReport(){
	var $table = document.getElementById("tableName").innerHTML;
	var $ft = document.getElementById("arrayText").innerHTML;
	var $f = document.getElementById("sequel").innerHTML;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("result").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/reportPreview.php?ft="+$ft+"&f="+$f+"&t="+$table,true);
	xmlhttp.send();
}
////////////////////////////////////
////////////////////////////////////
////////////////////////////////////
function goOn(){
	var $table = document.getElementById("tableName").innerHTML;
	var $ft = document.getElementById("arrayText").innerHTML;
	var $f = document.getElementById("sequel").innerHTML;
	document.getElementById("sendTable").value=$table
	document.getElementById("sendFields").value=$ft
	document.getElementById("sendSequel").value=$f
	//	document.getElementById('buttonChunks').style='display:inline-block;';
}
</script>
</body>
</html>
