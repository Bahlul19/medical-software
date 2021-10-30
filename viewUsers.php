<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014


// add primary languages (list all 4 in one column) get rid of clinic.
// dont show fgac for those who dont have a fac.
// add role back in, make human readable.

$SECURE = TRUE;
require("inc/init.php");
?>
<!doctype HTML>
<html>
<head>
<title> Itasca</title>
 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.tabletoCSV.js" type="text/javascript" charset="utf-8"></script>
    <script>
        //new code 3-3-19
	$(document).ready(function($){
		 $("#export").click(function(){
		 	$("#export_table").tableToCSV();
		 });
	});


    </script>
	

<?php
require("{$legos}/head.php");
?>
<style>
	.urgent{
		background-color:#000000;
		background-image:url('img/urgent.gif');
		color:#FFFFFF;
		font-weight:bold;
	}
	.table-scroll {
		position:relative;
		max-width:100%;
		margin:auto;
		overflow: hidden;
	}
	.table-wrap {
		width:100%;
		overflow:auto;
	}
	.table-scroll table {
		width:100%;
		margin:auto;
		border-collapse:separate;
		border-spacing:2;
	}
	.table-scroll tr {
	    color: #000000;
	    text-align: center;
	    font-family: "Times New Roman", Times, serif;
	}
	.table-scroll th {
	    background-color: #99CCff;
	    color: #000000;
	    font-family: "Times New Roman", Times, serif;
	}
	.table-scroll th, .table-scroll td {
		padding:5px 2px;
		border:1px solid #000;
		white-space:nowrap;
		vertical-align:top;
	}
	.table-scroll td {
		text-align: left;
	}
	.table-scroll thead, .table-scroll tfoot {
		background:#f9f9f9;
	}
	.editButton {
	    font-size: .8em;
	    width: 30px;
	    background-color: #CCFFCC;
	    text-decoration: none;
	    display: inline-block;
	    padding: 2px;
	    border: 1px solid #000000;
	    color: #000000;
	}
</style>

<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>


<div class = 'siteWrap'>


	<div class = 'tableDisplay'>
		<div class = 'formTitle'>
		View Users
		<button id="export" data-export="export">Export</button>
		</div>
		
<?php

echo "<div id = 'filter'>";
echo "<table width = '100%'";
echo "<tr>";
//echo "<th> Patient Search </th>";
echo "<th style = 'font-size:1.2em;'> User Type </th>";
echo "<th style = 'font-size:1.2em;'> First Name </th>";
echo "<th style = 'font-size:1.2em;'> Last Name </th>";
if($uInfo['role'] < 3){ // only if they have a choice
//	echo "<th> clinic </th>";
	echo "<th style = 'font-size:1.2em;'> Facility </th>";
}


echo "</tr>";
//function formInput($name,$type,$value,$param){
echo "<tr>";


/////////////////
// users 
////////////////
//	echo "<td>";
//	echo "<input type='text' size = '20' name='patientName' class='autoPatient' id = 'patient' onBlur = 'newPFilter(this.id);'>";
//	echo "</td>";




echo "<td style = 'text-align:center;'>";
	echo "<select name = 'role' id = 'role' onchange = 'newUFilter(this.id);'>";
	echo "<option value = 'ANY'> ANY </option>";
	$sql = "SELECT id, title FROM roles";
	$go = mysql_query($sql);
	while($row = mysql_fetch_assoc($go)){
		echo "<option value = '{$row['id']}'> {$row['title']} </option>";
	}
echo "</td>";

echo "<td><input type = 'test' name = 'fName' id = 'fName' onBlur= 'newUFilter(this.id);'> </td>";
echo "<td> <input type = 'test' name = 'lName' id = 'lName' onBlur= 'newUFilter(this.id);'>  </td>";
//clinic dropdown 
// make this
/*
if($uInfo['role'] < 3){ 
$sql = "SELECT id, title FROM clinics ";
	echo "<td>";

	if($uInfo['role'] > 2){
		$sql .= "WHERE clinic_id = '{$uInfo['clinic']} ";
	}
	$go = mysql_query($sql)or die(mysql_error());
	echo "<select name = 'clinic' id = 'clinic' onchange = 'newUFilter(this.id);'>";
	echo "<option value = 'ANY'> ANY </option>";
	while ($row = mysql_fetch_assoc($go)){
		echo"<option value = '{$row['id']}'> {$row['title']} </option>";
	}		
	echo "</select>";
}
*/

// facility Dropdown
if($uInfo['role'] < 3){ // if there is a choice
	$sql = "SELECT id, title FROM facilityredo ORDER BY title ASC";
	echo "<td  style = 'text-align:center;' >";

	if($uInfo['role'] > 2){
		$sql .= "WHERE clinic_id = '{$uInfo['clinic']} ";
	}
	$go = mysql_query($sql);
	echo "<select name = 'facility' id = 'facility' onchange = 'newUFilter(this.id);'>";
	echo "<option value = 'ANY'> ANY </option>";
	while ($row = mysql_fetch_assoc($go)){
		echo"<option value = '{$row['id']}'> {$row['title']} </option>";
	}		
	echo "</select>";
	echo "</td>";
}


echo "</tr>";

echo "</table>";

echo "</div>";

//export feedback
echo "<div id = 'export'>";

echo "</div>";
//
//echo "Name Of File To Export <input type = 'text' id = 'fileName'>";
//echo "<button onclick = 'exportCSV();'> Export This Result To CSV (MS Excel) </button>";


echo "<div id = 'userTable'>";
	include("proc/viewUsers.php");
echo "</div>";


?>

	</div> <!-- aptForm -->
</div> <!-- siteWrap -->


<script>
function newUFilter($str){
	console.log($str);
	var $role = document.getElementById("role").value;
//	var $clin = document.getElementById("clinic").value;
	var $fac = document.getElementById("facility").value;
	var $fName = document.getElementById("fName").value;
	var $lName = document.getElementById("lName").value;
	//var $getString = "role="+$role+"&clinic="+$clin+"&facility="+$fac;
//	var $getString = "role="+$role+"&facility="+$fac;
	var $getString = "role="+$role+"&facility="+$fac+"&name_f="+$fName+"&name_l="+$lName;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		//	alert("READY "+xmlhttp.readyState+" status "+xmlhttp.status);
			document.getElementById("userTable").innerHTML=xmlhttp.responseText;
		} else {
		//	alert("NOT READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		}
	} 
	xmlhttp.open("GET","proc/viewUsers.php?"+$getString,true);
	xmlhttp.send();
}


function exportCSV(){
	var $str = document.getElementById("reportSQL").innerHTML;
	var $fileName = document.getElementById("fileName").value;
	if($fileName == ''){
		$fileName = 'TEMP';
	}
	//alert($str);
	var $getString = "sql="+$str+"&fileName="+$fileName;
	//var $getString = "t=TEST";
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			//alert("READY "+xmlhttp.readyState+" status "+xmlhttp.status);
			document.getElementById("export").innerHTML=xmlhttp.responseText;
		} else {
			//alert("NOT READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		}
	} 
	xmlhttp.open("GET","proc/exportUsers.php?"+$getString,true);
	//xmlhttp.open("GET","proc/export.php",true);
	xmlhttp.send();
	
	//document.getElementById("export").innerHTML=$str;
}
</script>


<?php
require("scripts.php");
?>


</body>
</html>


