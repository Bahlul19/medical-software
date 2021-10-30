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
.delete{
	background-color:#FF0000;
	color:#FFFFFF;
	font-weight:bold;

}

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
		<!-- Add / Edit Languages -->
		Language Editor
		</div>
		<span style = "font-size:.8em;">
		<b>Changing the name of a language:</b><br>
		To change the NAME of a langauge, simply type the new name in the field where the current name is, and click "Submit Changes" at the bottom of the page. You may update multiple languages at once using this method.<br>
		<b>Adding a new langauge:</b><br>
		To add a NEW language, enter the name of the language in the "ADD NEW" field, and click "Submit Changes" at the bottom of the page.<br>
		<b>Deleteing a language</b><br>
		To DELETE a language, click the red "x" next to the language you wish to delete. You will be brought to a wizard which will guide you through the rest of the process. Deleteing a language CAN NOT be undone.
		</span>
		<hr>
<?php
// 'onsubmit="return validateForm();" name = "newClinic" id = "newClinic"'
formForm('proc/editLanguages.php','post');
//echo "<table>";
$sql = "SELECT * FROM languages ORDER BY language ASC";
$go = mysql_query($sql);
while($ro = mysql_fetch_assoc($go)){
	$id = $ro['id'];
	$title = $ro['language'];
	$subsql = "SELECT COUNT(id) FROM patients WHERE language = '$id'";
	$go2 = mysql_query($subsql)or die(mysql_error());
	//var_dump($go2);
	$lCount = mysql_fetch_array($go2);
	$lCount = $lCount[0];
	
	
	echo "<label>";
	echo "{$id} &nbsp;&nbsp;&nbsp;";
	echo "<div id = 'deldept_{$id}' class = 'deletex' onclick = 'dellang(this.id)'>X</div>";
	echo "</label>";
	
	
//	formLabel("title_{$id}","<span style = 'color:#ff0000;'>{$lCount}</span> patients -- {$id} <button onClick = 'remove(\"{$id}\");'");
	formInput("title_{$id}",'text',"{$title}");
	clearfix();
}
formLabel("NEW","ADD NEW");
formInput("NEW",'text',"");
clearfix();
echo "<input type = 'submit' value = 'Submit Changes'>";
clearfix();
?>




	</div> <!-- aptForm -->
</div> <!-- siteWrap -->



<script>
function dellang($str){
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
	xmlhttp.open("GET","/portal/proc/dellang.php?q="+$str,true);
	xmlhttp.send();

}

function modalClose(){
	document.getElementById('modalplace').style.display = 'none';
	document.getElementById("siteWrap").style.display = "block";
}

function updateDeleteLang(){
	var $newLang = document.getElementById("newLang").value;
	var $oldLang = document.getElementById("delId").value;
	
	
	//alert("deleting"+$oldLang+" -- replacing with "+$newLang);
	

	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			//alert("deleting"+$oldDept+" -- replacing with "+$newDept);
			document.getElementById("modalWindow").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/dellang2.php?del="+$oldLang+"&rep="+$newLang,true);
	xmlhttp.send();
	
}
</script>




<?php
require("scripts.php");
?>


</body>
</html>


