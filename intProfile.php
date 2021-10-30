<?php
// Interpreter Profile
// Nik Rubenstein 1-3-2015
$SECURE = TRUE;
require("inc/init.php");
?>
<!doctype HTML>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>

<script>
jQuery(function($){
 //  $("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#phone_1").mask("(999) 999-9999");
   $("#phone_2").mask("(999) 999-9999");
//   $("#tin").mask("99-9999999");
//   $("#ssn").mask("999-99-9999");
});
</script>




<style>
#saved{
width:100%;
height:50px;
line-height:50px;
font-size:1.5em;
}

.hideMe{
display:none;
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


<div class = 'siteWrap'>


	<div class = 'aptForm'>
		<div class = 'formTitle'>
		Profile:
		<?php
		echo $uInfo['name_f'] . " " . $uInfo['name_l'];
		?>
		</div>
		<div class = 'hideMe' id = 'uid'>
		<?php
		echo $uInfo['id'];
		?>
		</div>
		<div id = 'saved'></div>
<?php

//dataGet($fieldsArray,$table,$where,$clause)
$data = dataGet("*","interpreters","id",$uInfo['id']);
$data = $data[0];


formForm("{$htmlRoot}/proc/intProfile.php");
$u = getUinfo($uInfo['id']);

//ph 1
formLabel("phone_1","Phone 1");
formInput("phone_1","text",$u['phone_1'],"id = 'phone_1' onBlur = 'saveData();'");
clearfix();
// ph2
formLabel("phone_2","Phone 2");
formInput("phone_2","text",$u['phone_2'],"id = 'phone_2' onBlur = 'saveData();'");
clearfix();
// email
formLabel("email","Email Address");
formInput("email","text",$u['email'],"id = 'email' onBlur = 'saveData();'");
clearfix();
// address
formLabel("addr_1","Address 1");
formInput("addr_1","text",$u['addr_1'],"id = 'addr_1' onBlur = 'saveData();'");
clearfix();

formLabel("addr_2","Address 2");
formInput("addr_2","text",$u['addr_2'],"id = 'addr_2' onBlur = 'saveData();'");
clearfix();

formLabel("addr_city","City");
formInput("addr_city","text",$u['addr_city'],"id = 'addr_city' onBlur = 'saveData();'");
clearfix();

formLabel("addr_state","State");
formInput("addr_state","text",$u['addr_state'],"id = 'addr_state' onBlur = 'saveData();'");
clearfix();

formLabel("addr_zip","Zip");
formInput("addr_zip","text",$u['addr_zip'],"id = 'addr_zip' onBlur = 'saveData();'");
clearfix();

hr();
//lang 1
formLabel("language_1","Language 1");
$l = dataGet("*",'languages','id',$data['language_1']);
$l = $l[0];
$l = $l['language'];
echo "<onedrop>";
formDropdown('language_1','languages','id','language',$data['language_1'],$l,'',"id = 'language_1' onchange = 'saveData();'");
echo "</onedrop>";
clearfix();
//lang 2
formLabel("language_2","Language 2");
$l = dataGet("*",'languages','id',$data['language_2']);
$l = $l[0];
$l = $l['language'];
echo "<onedrop>";
formDropdown('language_2','languages','id','language',$data['language_2'],$l,'',"id = 'language_2' onchange = 'saveData();'");
echo "</onedrop>";
clearfix();
//lang 3
formLabel("language_3","Language 3");
$l = dataGet("*",'languages','id',$data['language_3']);
$l = $l[0];
$l = $l['language'];
echo "<onedrop>";
formDropdown('language_3','languages','id','language',$data['language_3'],$l,'',"id = 'language_3' onchange = 'saveData();'");
echo "</onedrop>";
clearfix();
//lang 4
formLabel("language_4","Language 4");
$l = dataGet("*",'languages','id',$data['language_4']);
$l = $l[0];
$l = $l['language'];
echo "<onedrop>";
formDropdown('language_4','languages','id','language',$data['language_4'],$l,'',"id = 'language_4' onchange = 'saveData();'");
echo "</onedrop>";

clearfix();

$editRole = ($_SESSION['uInfo']['role'] == 1 || $_SESSION['uInfo']['role'] == 5 ) ? true : false ;
if($editRole == true){
	formLabel("edu","Education");
	formInput("edu","text",$u['edu'],"id = 'edu' onBlur = 'saveData();'");
	clearfix();
}else{
	formLabel("edu","Education");
	formInput("edu","text",$u['edu'],"id = 'edu' readonly = 'true'");
	clearfix();
}

formLabel("roster_number","Roster Number");
formInput("roster_number","text",$data['roster_number'],"id = 'roster_number' readonly='true'");// onBlur = 'saveData();'");
clearfix();
formLabel("roster_expiration","Roster Expiration");
formInput("roster_expiration","text",$data['roster_expiration'],"id = 'roster_expiration' readonly = 'true'");// onBlur = 'saveData();'");

clearfix();

formLabel("date_hire","Date Hire");
formInput("date_hire","text",$u['date_hire'],"id = 'date_hire' onBlur = 'saveData();'");
clearfix();


formLabel("","");
formInput("","button","Submit");
clearfix();
?>


	</div> <!-- aptForm -->
</div> <!-- siteWrap -->


<script>
function saveData(){
	var $uid = document.getElementById("uid").innerHTML;
	var $ph1 = document.getElementById("phone_1").value;
	var $ph2 = document.getElementById("phone_2").value;
	var $email = document.getElementById("email").value;
	var $addr1 = document.getElementById("addr_1").value;
	var $addr2 = document.getElementById("addr_2").value;
	var $city = document.getElementById("addr_city").value;
	var $state = document.getElementById("addr_state").value;
	var $zip = document.getElementById("addr_zip").value;
	
	var $lan1 = document.getElementById("language_1").value;
	var $lan2 = document.getElementById("language_2").value;
	var $lan3 = document.getElementById("language_3").value;
	var $lan4 = document.getElementById("language_4").value;
	
	var $rosNo = document.getElementById("roster_number").value;
	var $rosEx = document.getElementById("roster_expiration").value;
	var $dateHire = document.getElementById("date_hire").value;
	var $edu = document.getElementById("edu").value;
	
	var $getString = "uid="+$uid+"&phone_1="+$ph1+"&phone_2="+$ph2+"&email="+$email;
	$getString = $getString+"&addr_1="+$addr1+"&addr_2="+$addr2+"&addr_city="+$city+"&addr_state="+$state+"&addr_zip="+$zip;
	$getString = $getString+"&language_1="+$lan1+"&language_2="+$lan2+"&language_3="+$lan3+"&language_4="+$lan4;
	$getString = $getString+"&roster_number="+$rosNo+"&roster_expiration="+$rosEx+"&date_hire="+$dateHire+"&edu="+$edu;
	
	//JAXY
		if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		//	alert("READY "+xmlhttp.readyState+" status "+xmlhttp.status);
			document.getElementById("saved").innerHTML=xmlhttp.responseText;
			setTimeout(function(){
				document.getElementById("saved").innerHTML="";
			},1000) 
		} else {
		//	alert("NOT READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		}
	} 
	xmlhttp.open("GET","proc/intProfile.php?"+$getString,true);
	xmlhttp.send();
	
	

}
</script>


<?php
require("scripts.php");
?>


</body>
</html>


