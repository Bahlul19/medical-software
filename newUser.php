<?php
$newRole = $_GET['role'];
// Index.php
// Nik Rubenstein -- 12-05-2014
$SECURE = TRUE;
require_once("inc/init.php");
if($newRole == ''){
	$defaultRole = 'Please Select A User Type';
	$userType = 'User';
} else {
	$sql = "SELECT title FROM roles WHERE id = '{$newRole}'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	$defaultRole = $row['title'];
	$userType = $defaultRole;
}
?>
<!doctype HTML>
<html>
<head>

<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.datepick.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>



<script>
jQuery(function($){
 //  $("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#phone1").mask("(999) 999-9999");
   $("#phone2").mask("(999) 999-9999");
//   $("#tin").mask("99-9999999");
//   $("#ssn").mask("999-99-9999");
});





</script>

<script>
$(function() {
	//$('#popupDatepicker').datepick();
	$('#rosterDate').datepick({onSelect: showDate});
	$('#inlineDatepicker').datepick({onSelect: showDate});
});
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

function showDate(date) {
	alert('The date chosen is ' + date);
}
</script>
<title> Itasca</title>
<?php
require("{$legos}/head.php");
?>


</head>
<?php
echo "<body onload = 'switchRole(\"div{$newRole}\");'> ";
?>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>

<div class = 'siteWrap'>


	<div class = 'aptForm'>
		<div class = 'formTitle'>
		
		<?php
		echo "New {$userType}";
		?>
		
		</div>
	
	
	<?php
	
	
	
	
	
	
	
	///////////////////////////////////
	///////////////////////////////////
	///////////////////////////////////
	
	
	
	
	
	formForm("{$htmlRoot}/proc/newUser.php",'post','onsubmit="return validateForm();"');
	
	
	// clinic if adfmin
	if($uInfo['role'] == 1 || $uInfo['role'] == 2){ // if they are admin or Itasca staff
		// make a dropdown of clinics
		
		formLabel('role','Type Of User');
		echo "<oneDrop>";
		// formDropdown($name,$table,$fieldV,$fieldW,$default = 'Please Specify', $other = 'other', $params)
		formDropdown('role','roles','id','title',$newRole,$defaultRole,'','onchange="switchRole(\'div\'+this.value);" id="role"');
	echo "</oneDrop>";
		clearfix();
		hr();
		
		
		
		///////////////////////////////////////
		////////////////////////////////////////
		////////////////////////////////////////
		/////////////////////////////////////////
		
		

	// ROLE 3
	
	echo "<div id = 'div3' style = 'display:none;'>";
	formLabel('facility','For Facility');
		echo "<oneDrop>";
// function formDropdown($name,$table,$fieldV,$fieldW,$defaultValue = 'spec',$default = 'Please Specify', $other = 'other',$params){
		formDropdown('facility','facilityredo','id','title','spec','Choose A Facility','','');
		echo "</oneDrop>";
		clearfix();
	echo "</div>";
	
/*	// Role 4
	echo "<div id = 'div4' style = 'display:none;'>";
	formLabel('facility','For Facility');
		echo "<oneDrop>";
// function formDropdown($name,$table,$fieldV,$fieldW,$defaultValue = 'spec',$default = 'Please Specify', $other = 'other',$params){
		formDropdown('facility','facilityredo','id','title','spec','Choose A Facility','','');
		echo "</oneDrop>";
		clearfix();
	echo "</div>";
	*/
	
	
	// ROLE 5
	echo "<div id = 'div5' style = 'display:none;'>";
	formLabel('gender','Gender');
	echo "<oneDrop>";
	$MF = array(
		'M' => 'Male',
		'F' => 'Female'
	);
	formSelect('gender',$MF);
	
	echo "</oneDrop>";
	clearfix();
	
	formLabel('language1', 'Language 1');
	echo "<oneDrop>";
	formDropdown('language1','languages','id','language','spec','Please Specify A Langauge','My Language Is Not Listed','onclick="specLangauge();" id = "inputLangauge"');
	echo "</oneDrop>";
	clearfix();
	
	formLabel('language2', 'Language 2');
	echo "<oneDrop>";
	formDropdown('language2','languages','id','language','spec','None','My Language Is Not Listed','onclick="specLangauge();" id = "inputLangauge"');
	echo "</oneDrop>";
	clearfix();
	
	formLabel('language3', 'Language 3');
	echo "<oneDrop>";
	formDropdown('language3','languages','id','language','spec','None','My Language Is Not Listed','onclick="specLangauge();" id = "inputLangauge"');
	echo "</oneDrop>";
	clearfix();
	
	formLabel('language4', 'Language 4');
	echo "<oneDrop>";
	formDropdown('language4','languages','id','language','spec','None','My Language Is Not Listed','onclick="specLangauge();" id = "inputLangauge"');
	echo "</oneDrop>";
	clearfix();
	
	formLabel('roster','Roster Number',true);
	// formInput('roster','text','',"id = 'roster'");
	formInput('roster','text','','id = "roster" onBlur="makeUname();"');
	clearfix();
		//date
	formLabel('rosterDate','Roster Expiration Date',true);
	//formInput('rosterDate','text','','id = "rosterDate"');
	echo "<input name = 'rosterDate' type = 'text' id = 'popupDatepicker'>";
	clearfix();
	
	//newly add
	
    formLabel('date_hire','Date of Hire');
	formInput('date_hire','text','','id = "date_hire"');
	clearfix();
	formLabel('edu','Education');
	formInput('edu','text','','id = "edu"');
	clearfix();
	
	
	//time
	echo "</div>";
	
	
	
	//echo "<div id = 'divspec'>";
	//	echo "TEST";
	//echo "</div>";
	
	
	
	/////////////////////////////////////
	//////////////////////////////////////
	//////////////////////////////////////
	
		
		
		
		
		
	//	echo "<span id = 'specials'></span>";
	//	echo "<div id = 'myBox'></div>";
		clearfix();
		hr();
		//Name
		formLabel('nameF','First Name',true);
		formInput('name_f','text','','id = "fname" onBlur="makeUname();"');
		clearfix();
		formLabel('nameL','Last Name',true);
		formInput('name_l','text','','id = "lname" onBlur="makeUname();"');
		clearfix();

		// email
		formLabel('email','Email Address',true);
		formInput('email','text','','id = "email"');
		clearfix();

		// phone numbers
		formLabel('phone1','Telephone 1',true);
		formInput('phone_1','text','','id = "phone1"');
		clearfix();
		
		formLabel('phone2','Telephone 2');
		formInput('phone_2','text','','id = "phone2"');
		clearfix();
		
		//address
		formLabel('addr_1','Address 1');
		formInput('addr_1','text','','id = "addr_1"');
		clearfix();
		formLabel('addr_2','Address 2');
		formInput('addr_2','text','','id = "addr_2"');
		clearfix();
		formLabel('addr_city','City');
		formInput('addr_city','text','','id = "addr_city"');
		clearfix();
		formLabel('addr_state','State');
		formInput('addr_state','text','','id = "addr_state"');
		clearfix();
		formLabel('addr_zip','Zip');
		formInput('addr_zip','text','','id = "addr_zip"');
		clearfix();
		//uname
		formLabel('username','Username',true);
		formInput('uname','text','','id = "username" autocomplete="off" onblur="testUsername(this.value);"');
		clearfix();
		
		echo "<div id = 'usernameTest'></div>";
		clearfix();
		
/*
        if($uInfo['role'] == 4 || $uInfo['role'] == 5)
        {
		formLabel('date_hire','Date of Hire');
		formInput('date_hire','text','','id = "date_hire"');
		clearfix();
		formLabel('edu','Education');
		formInput('edu','text','','id = "edu"');
		clearfix();
        }
*/
		formLabel('pass1','Password',true);
		formInput('pass1','password','','autocomplete="off" id = "pass1" onblur = "passMatch();"');
		//formInput('pass1','password','','id = "pass1" onblur = "passMatch();"');
		clearfix();
		formLabel('pass2','Repeat Password',true);
		// formInput('pass2','password','','id = "pass2" onblur = "passMatch();"');
		formInput('pass2','password','','id = "pass2"');
		clearfix();
		//submit
		formLabel('blank','');
		formInput('submit','submit','Submit');
		//time
	
		clearfix();
	} // admin security 
?>


	</div> <!-- aptForm -->
</div> <!-- siteWrap -->


<?php
require("scripts.php");
?>



<script>
function makeUname(){
	var $fname = document.getElementById("fname").value.toLowerCase();
	var $lname = document.getElementById("lname").value.toLowerCase();
	if($lname != '' && $fname != ''){
	//	alert($fname+$lname);
		var $uname = document.getElementById("username");
		$uname.value = $fname+$lname;
	}
	
	var $testIT = $fname+$lname;
	testUsername($testIT);
	

}

function removeName(){
	var $remove = document.getElementById('usernameTest').innerHTML;
	if($remove != ''){
		document.getElementById('username').value='';
		
		document.getElementById('username').style.backgroundColor='#FFAAAA';
		return false;
	} 
}

function testUsername($str){
	
	// now, JAX test the uname against the existing users.
	
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("usernameTest").innerHTML=xmlhttp.responseText;
			removeName();
		} 
	}
	xmlhttp.open("GET","/portal/proc/checkUser.php?u="+$str,true);
	xmlhttp.send();
	
}



function passMatch(){
	var $cnt = 0;
	var $pass1 = document.getElementById("pass1").value;
	var $pass2 = document.getElementById("pass2").value;

	if($pass1 == ''){
		document.getElementById("pass1").style.backgroundColor='#FFCCCC';
		$cnt = $count+1;
	}
	
	if($pass2 == ''){
		document.getElementById("pass2").style.backgroundColor='#FFCCCC';
		$cnt = $count+1;
	}
	
	if($pass1 != $pass2){
		document.getElementById("pass1").style.backgroundColor='#FFCCCC';
		document.getElementById("pass2").style.backgroundColor='#FFCCCC';
		$cnt = $count+1;
		//alert("Password Mismatch");
	} 
	
	if($cnt > 0){
		alert("Password Mismatch");
	}
	
	// if($cnt >= 1){
	// 	alert("Password Mismatch");
	// }
	
}

//vanish the repeat password from password after not match

function switchRole($str){
	if($str == 'div4'){
		$str = 'div3';
	}
	
	
	
	//alert($str);
//	$tst = document.getElementById('removeMe').innerHTML;
	//alert("testing"+$tst);
	//$content = document.getElementById($str).innerHTML;
	//$drop = document.getElementById('specials');
	//$drop.innerHTML=$content;
	document.getElementById("div3").style.display="none";
	//document.getElementById("div4").style.display="none";
	document.getElementById("div5").style.display="none";
	document.getElementById($str).style.display="inline";
}



function validateForm(){
	$count = 0;
	passMatch();
	var $role = document.getElementById("role").value;
	var $username = document.getElementById('username').value;
	var $namef = document.getElementById('fname').value;
	var $namel = document.getElementById('lname').value;
	var $phone = document.getElementById('phone1').value;
	var $email= document.getElementById('email').value;
	var $roster = document.getElementById('roster').value;
	var $rosExp = document.getElementById('popupDatepicker').value;
	if($role == 5){
		if($roster == ''){
			document.getElementById("roster").style.backgroundColor='#FFCCCC';
			$count = $count+1;
		}
		if($rosExp == ''){
			document.getElementById("popupDatepicker").style.backgroundColor='#FFCCCC';
			$count = $count+1;
		}
	}

	
	if($username == ''){
		document.getElementById("username").style.backgroundColor='#FFCCCC';
		$count = $count+1;
	}
	
	if($namef == ''){
		document.getElementById("fname").style.backgroundColor='#FFCCCC';
		$count = $count+1;
	}
	
	if($namef == ''){
		document.getElementById("lname").style.backgroundColor='#FFCCCC';
		$count = $count+1;
	}
	
	if($phone == ''){
		document.getElementById("phone1").style.backgroundColor='#FFCCCC';
		$count = $count+1;
	}
	
	if($email == ''){
		document.getElementById("email").style.backgroundColor='#FFCCCC';
		$count = $count+1;
	}
	
	
	
	if($count > 0){
		alert("The fields highlighted in red are required.");
		return false;
	}
	
	testUsername($username); // returns false if uname is taken.
//	return false; // stop the send
	
}




</script>


</body>
</html>
