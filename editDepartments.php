<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
?>
<!doctype HTML>
<html>
<head>
<style>
.deletex{
	background-color:#FF0000;
	color:#FFFFFF;
	font-weight:bold;
	font-size:.8em;
	width:10px;
	height:15px;
	line-height:15px;
	padding:0px 3px;
	DISPLAY:INLINE-BLOCK;
}

#modalplace{
	width:100%;
	height:400 px;
	background-color:#666;
	color:#FFF;
	display:none;
	z-index:999;
	text-align:center;
}

.modalWindow{
	margin-left:auto;
	margin-right:auto;
	margin-top:50px;
	width:50%;
	height:300px;
	background-color:#FFF;
	color:#000;
	border:2px solid #FF0000;
}
</style>




<title> Itasca</title>
<?php
require("{$legos}/head.php");
?>

<body>

<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>


<div id = 'modalplace'> 
	<div class = 'modalWindow' id = 'modalWindow'>
		
	</div>

</div>


<div class = 'siteWrap' id = 'siteWrap'>


	<div class = 'aptForm'>
		<div class = 'formTitle'>
		Add / Edit Departments
		</div>
<?php
// 'onsubmit="return validateForm();" name = "newClinic" id = "newClinic"'
formForm('proc/editDepartments.php','post');
//echo "<table>";
$sql = "SELECT * FROM departments ORDER BY title ASC";
$go = mysql_query($sql);
while($ro = mysql_fetch_assoc($go)){
	$id = $ro['id'];
	$title = $ro['title'];
	//formLabel("title_{$id}",$id);
	echo "<label>";
	echo "{$id} &nbsp;&nbsp;&nbsp;";
	echo "<div id = 'deldept_{$id}' class = 'deletex' onclick = 'deldept(this.id)'>X</div>";
	echo "</label>";
	formInput("title_{$id}",'text',"{$title}");
	
	
	
	clearfix();
	
	
}
formLabel("NEW","ADD NEW");
formInput("NEW",'text',"");
echo "<input type = 'submit' value = 'Submit Changes'>";
clearfix();
?>




	</div> <!-- aptForm -->
</div> <!-- siteWrap -->

<script>
function deldept($str){
	document.getElementById('modalplace').style.display = 'block';
	document.getElementById("siteWrap").style.display = "none";
	//document.getElementById('modalWindow').innerHTML = $str;
	
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("modalWindow").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/deldept.php?q="+$str,true);
	xmlhttp.send();

}

function modalClose(){
	document.getElementById('modalplace').style.display = 'none';
	document.getElementById("siteWrap").style.display = "block";
}

function updateDeleteDept(){
	var $newDept = document.getElementById("newDept").value;
	var $oldDept = document.getElementById("delId").value;
	
	

	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			alert("deleting"+$oldDept+" -- replacing with "+$newDept);
			document.getElementById("modalWindow").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/deldept2.php?del="+$oldDept+"&rep="+$newDept,true);
	xmlhttp.send();
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

*/


?>
