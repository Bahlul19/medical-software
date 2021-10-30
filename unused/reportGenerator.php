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
<style>

.chooseButton{
width:180px;
display:inline-block;
background-color:#CCCCCC;
border:1px solid #000000;

}

.selectFields{
	font-size:.8em;
	width:100%;
}

.selectSubFields{
	font-size:.8em;
	width:100%;
	
	
}
.selectSubFields td{
 border-bottom:1px solid #000000;
	border-top:1px solid #000000;
}
.selectSubFields table td{
	border:1px solid #0000FF;
	background-color:#DDDDFF;
}

.quad{
float:left;

border-right:1px solid #000000;
border-left:1px solid #000000;
margin-left:-1px;
}

.smallTextField{
	width:125px;
}

#selectedTable{
margin:auto;
width:170px;
background-color:#DDFFDD;
font-weight:bold;
border:1px solid #000000;
padding:5px;
}

#fieldsArray{
margin:auto;
background-color:#FFDDDD;
font-weight:bold;
border:1px solid #000000;
padding:5px;
}
</style>


<title> Report Generation Wizard</title>
<?php
require("{$legos}/head.php");
?>

<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>
<div id = 'fullCommand'>
<div id = 'selectedTable'></div>
<div id = 'fieldsArray'></div>
<div id = 'whereClause'></div>
</div>
<div class = 'siteWrap'>


	<div class = 'reportDisplay'>
		<div class = 'formTitle'>
		Report Generation Wizard
		</div>
<?php
$tables = getTables();

// select an 
echo "<span id = 'removeThese'>";
//CHOOSE TABLE
	echo "<div class = 'quad' id = 'chooseTable'>";
	echo "<b> Select A Primary Table</b><hr>";
	foreach($tables as $k => $v){
		echo "<button class = 'chooseButton' onclick = 'swapTable(this.value);' value = '$v'> $v </button><br>"; 
	}
	//echo "<div id = 'selectedTable'></div>";
echo "</div>"; // quad chooseTable
// CHOOSE FIELDS
echo "<div class = 'quad' id = 'fields'> </div>";  


// WHERE
echo "<div id = 'chooseWhere' class = 'quad'></div>";

echo "</span>"; // removeThese
//REPLACE
echo "<div id = 'chooseReplace' class = 'quad'></div>";

// ///////////////
clearfix();
hr();
//echo "<div id = 'fieldsArray'></div>";
	

?>

<script>
function swapTable($str){
	document.getElementById("selectedTable").innerHTML=$str;
	//alert($str);
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("fields").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/swapTable.php?q="+$str,true);
	xmlhttp.send();
	
	
}



function addField($str){
	var $title = document.getElementById($str+'ID').value;
	var $current = document.getElementById("fieldsArray").innerHTML.replace(/(^\s*,)|(,\s*$)/g, '');
	document.getElementById("fieldsArray").innerHTML=$current+","+$title+"="+$str;
	
}



function makeArray(){
var $table = document.getElementById("selectedTable").innerHTML;
//alert($table);
var $current = document.getElementById("fieldsArray").innerHTML.replace(/(^\s*,)|(,\s*$)/g, '');
	var $open = '[makeArray:';
	var $close = ']';
	var $result = $open+$current+$close;
	document.getElementById("fieldsArray").innerHTML=$result;





	// jax the next part in.
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("chooseWhere").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/whereFields.php?q="+$table,true);
	xmlhttp.send();




}


function addSQL($str){
	
	// okay gather the stuff
	var $makeNew = document.getElementById("tempNow").innerHTML;
	var $field = document.getElementById("tempField").value;
	var $op = document.getElementById("tempLike").value;
	var $clause = document.getElementById("tempClause").value;
	var $next = document.getElementById("tempDone").value;

	
	// make a seuqel string;
	if($clause == 'ANY'){
		$nothing = 1;// just put some crap here
	} else {
		if ($op == 'LIKE'){
			$clause = '%'+$clause+'%';
		}
		var $sequel = $field+" "+$op+" '"+$clause+"'";
		
		$sequel = $sequel.replace("NEXT","");
	$sequel = $sequel.replace("undefined","");
	// have sequel string.. now add it to sequel
	var $whereNow = document.getElementById("whereClause").innerHTML;
	$whereNow = $whereNow+$sequel;
	document.getElementById("whereClause").innerHTML=$whereNow;
	

	
	//var $cleaned = document.getElementById("whereNow").innerHTML;
	
	
	// now switch ids!!!
		document.getElementById("tempNow").id=$field+"Now";
		document.getElementById("tempField").id=$field+"Field";
		document.getElementById("tempLike").id=$field+"Like";
		document.getElementById("tempClause").id=$field+"Clause";
		document.getElementById("tempDone").id=$field+"Done";
		if($str == 'DONE'){
			alert($str);
			makeArray2();
		} else {
			document.getElementById("tempNew").innerHTML=$makeNew;
			document.getElementById("tempNew").id='tempNow';
		//document.getElementById("tempNewLine").id='tempNew';
		}
	
		
	}

	
	
	
}








function makeArray2(){
//	addSQL('NEXT');
	document.getElementById("removeThese").innerHTML='';
	var $current = document.getElementById("fieldsArray").innerHTML.replace(/(^\s*,)|(,\s*$)/g, '');
//	var $open = '[makeArray:';
//	var $close = ']';
//	var $result = $open+$current+$close;
//	document.getElementById("fieldsArray").innerHTML=$result;


	// jax the next part in.
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("chooseReplace").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/replaceFields.php?q="+$current,true);
	xmlhttp.send();




}







function replaceFields($str,$dv){
// echo "<td id = 'swapFields{$k}'>";

var $swap = 'swapFields'+$dv;
//alert($str+'--'+$swap);



if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById($swap).innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/swapFields.php?table="+$str+'&div='+$dv,true);
	xmlhttp.send();


}

function addAField($str){

	alert($str);
}

</script>

<?php

require("scripts.php");
?>

























</body>
</html>














<?php
/*


function facSwitch($str,$words) {
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("myBox").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/facilitySwitch.php?q="+$str+"&w="+$words,true);
	xmlhttp.send();
}




echo"</div>"; // commandText

echo "<div id = 'replacer'>";



echo "</div>";


clearfix();
?>

	</div> <!-- aptForm -->
</div> <!-- siteWrap -->
<script>
function swapTable($str){
	//alert($str);
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("fields").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/swapTable.php?q="+$str,true);
	xmlhttp.send();
}

function addField($str){
	var $title = document.getElementById($str+'ID').value;
	var $current = document.getElementById("fieldsArray").innerHTML.replace(/(^\s*,)|(,\s*$)/g, '');
	document.getElementById("fieldsArray").innerHTML=$current+","+$title+"="+$str;
	
}

function makeArray(){
	var $current = document.getElementById("fieldsArray").innerHTML.replace(/(^\s*,)|(,\s*$)/g, '');
	var $open = '[makeArray:';
	var $close = ']';
	var $result = $open+$current+$close;
	document.getElementById("fieldsArray").innerHTML=$result;


	// jax the next part in.
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("replacer").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/replaceFields.php?q="+$result,true);
	xmlhttp.send();




}
</script>





echo "<div id = 'fields'></div>";
echo "<div id = 'commandText'>";
	echo "<div id = 'fieldsArray'></div>";

*/





?>

