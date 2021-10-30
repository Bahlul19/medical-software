<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014

// add interpreter data
$SECURE = TRUE;
require("inc/init.php");
$thisUser = $_GET['u'];
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
   $("#rosdate").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#phone1").mask("(999) 999-9999");
   $("#phone2").mask("(999) 999-9999");
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



<style>
.delete{
	background-color:#FF0000;
	color:#FFFFFF;
	font-weight:bold;

}

#saved{
width:100%;
height:50px;
line-height:50px;
font-size:1.5em;
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
		Editing User Number 
		<?php
		echo $thisUser;
		?>
		</div>
		
<?php
// ///////////////// This Works ///////////////////////////
// /////////////////Uncomment to activate /////////////////
	formLabel('reset','Reset Password');
	echo "<button style = 'width:50%;float:right;background-color:#00FFFF;' onclick = 'resetPassword(\"{$thisUser}\");'> Reset Password </button>";
	clearfix();
	echo "<div id = 'saved'></div>";
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////

clearfix();
hr();
// 'onsubmit="return validateForm();" name = "newClinic" id = "newClinic"'
formForm('proc/editUser.php','post');
$sql = "SELECT * FROM users WHERE id = '{$thisUser}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
foreach($row as $k => $v){
	switch($k){
		default:
			formLabel($k,$k);
			formInput($k,'text',$v);
			clearfix();
		break;
		case 'password':
			formInput($k,'hidden',$v,'id="sec"');
		break;
		case 'pass_reset':
			//
		break;
		case 'role':



		formLabel($k,"User Type");
//function formDropdown($name,$table,$fieldV,$fieldW,$defaultValue = 'spec',$default = 'Please Specify', $other = 'other',$params){
		//	formDropdown('role','roles','id','title',$uInfo['role'],'');


//old code
/*
		formLabel($k,"User Type");
		
		echo "<onedrop>";

		 formDropdown('role','roles','id','title',$uInfo['role']);

		echo "</onedrop>";
		clearfix();

*/

		//new line for the edit functionality into the user option

		// $sql = "SELECT role FROM users WHERE id = '{$thisUser}'";

			$sql = "SELECT title FROM roles WHERE id = '{$v}'";
			$g2 = mysql_query($sql);
			$r2 = mysql_fetch_assoc($g2);
			$frole = $r2['title'];
			formInput($k,'hidden',$v,'readonly = "true" style = "background-color:#CCC;"');
			formInput('ignore','test',$frole,'readonly = "true" style = "background-color:#CCC;"');
		break;

		// formInput($k,'hidden',$v);
		// break;
		// case 'clinic':
		// break;
		case 'clinic':
		formInput($k,'hidden',$v);
		clearfix();
		break;


		case 'facility':
			//formLabel($k,'Facility');
			//function dataGet($fieldsArray,$table,$where,$clause){

			formLabel($k,"Facility");
			if($v == '0'){
				$thisFac = '0';
			} else {
				$f = dataGet('*','facilityredo','id',$v);
				$f = $f[0];
				$thisFac = $f['title'];
			}
			formInput('','text',$thisFac,'readonly = "true"');
			clearfix();
			
		break;
		case 'phone_1':
			formLabel($k,'Phone 1');
			formInput($k,'text',$v,'id = "phone1"');
			clearfix();
		break;
		case 'phone_2':
			formLabel($k,'Phone 2');
			formInput($k,'text',$v,'id = "phone2"');
			clearfix();
		break;
		case 'id':
			formLabel($k,'ID');
			formInput($k,'text',$v,'readonly = "true"');
			clearfix();
		break;
		case 'name_f':
			formLabel($k,'First Name');
			formInput($k,'text',$v);
			clearfix();
		break;
		case 'name_l':
			formLabel($k,'Last Name');
			formInput($k,'text',$v);
			clearfix();
		break;
		case 'uname':
			formLabel($k,'User Name');
			formInput($k,'text',$v,'readonly = "true"');
			clearfix();
		break;
		case 'date_hire':
		    if($uInfo['role'] == 4 || $uInfo['role'] == 5)
		    {
			formLabel($k,'Date of Hire');
			formInput($k,'text',$v);
			clearfix();
		    }
		break;
		case 'edu':
		     if($uInfo['role'] == 4 || $uInfo['role'] == 5)
		    {
			formLabel($k,'Education');
			formInput($k,'text',$v);
			clearfix();
		    }
		break;

		case 'email':
			formLabel($k,'Email Address');
			formInput($k,'text',$v);
			clearfix();
		break;
		case 'addr_1':
			formLabel($k,'Address 1');
			formInput($k,'text',$v);
			clearfix();
		break;
		case 'addr_2':
			formLabel($k,'Address 2');
			formInput($k,'text',$v);
			clearfix();
		break;
		case 'addr_city':
			formLabel($k,'City');
			formInput($k,'text',$v);
			clearfix();
		break;
		case 'addr_state':
			formLabel($k,'State');
			formInput($k,'text',$v);
			clearfix();
		break;
		case 'addr_zip':
			formLabel($k,'Zip');
			formInput($k,'text',$v);
			clearfix();
		break;
		
	}
	
}
clearfix();

if($row['role'] == '5'){
	hr();
	$subql = "SELECT gender, roster_number, roster_expiration, language_1, language_2, language_3, language_4 FROM interpreters WHERE id = '{$thisUser}'";
	$go2 = mysql_query($subql);
	$iData = mysql_fetch_assoc($go2);
	foreach($iData as $qq => $rr){
		if($qq == 'gender'){
			formLabel($qq,$qq);
			formInput($qq,'text',$rr);
		} elseif($qq == 'roster_expiration'){
			formLabel($qq,$qq);
			formInput($qq,'text',$rr, 'id = "rosdate"');
		} elseif ($qq == 'roster_number') {
			formLabel($qq,$qq);
			formInput($qq,'text',$rr);
		} else {
			formLabel($qq,$qq);
			$l = dataGet("*",'languages','id',$rr);
			$l = $l[0];
			$l = $l['language'];
			echo "<onedrop>";
				formDropdown($qq,'languages','id','language',$rr,$l,'',"id = '{$qq}'");
			echo "</onedrop>";
		}
		clearfix();
	}
	clearfix();
}
hr();
//formLabel('','');
echo "<input type = 'submit' value = 'Submit Changes'>";
clearfix();
formClose();

br();
br();
formForm('proc/deleteUser.php','post','onsubmit = "return confirmDelete();"');
formInput('delID','hidden',$thisUser);
echo "<input type = 'submit' value = 'Delete This User' class = 'delete' >";
formClose();
clearfix();


?>




	</div> <!-- aptForm -->
</div> <!-- siteWrap -->
<script>
function confirmDelete(){
var $conf = confirm("You are about to DELETE this patient. This process is NOT REVERSIBLE. Press OK to PERMANENTLY DELETE this patient, or Cancel to cancel.");
	if($conf == true){
	//	alert("DELETED");
		return true;
	}else{
		return false;
	}
}

function resetPassword($str){
	
	var $sec = document.getElementById('sec').value;
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
			},2000) 
		} else {
		//	alert("NOT READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		}
	} 
	xmlhttp.open("GET","proc/resetPassword.php?u="+$str+"&s="+$sec,true);
	xmlhttp.send();

}
</script>

<?php
require("scripts.php");

$loggedUser = $_SESSION['uInfo']['uname'];
$sql = "SELECT edit_mode,pageId  FROM loggedin_userdata WHERE user='$loggedUser'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

?>

<button id="myBtn" style="display: none;"></button>
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Another user is Altering this Page..</p>
  </div>

</div>
<script type="text/javascript">

	var modal = document.getElementById('myModal');
	var btn = document.getElementById("myBtn");
	var span = document.getElementsByClassName("close")[0];
	btn.onclick = function() {
	    modal.style.display = "block";
	}
	span.onclick = function() {
	    modal.style.display = "none";
	}
	window.onclick = function(event) {
	    if (event.target == modal) {
	        modal.style.display = "none";
	    }
	}

	$( document ).ready(function() {
		var isCurrentPage = <? echo $thisUser; ?>;
		var theUser = <? echo "'".$_SESSION['uInfo']['uname']."'"; ?>;
		setInterval( function() 
		{
			$.ajax({
	            type: "POST",
	            data: {isPage:isCurrentPage},           
	            url: "serverCheckWriteStatus.php",
	            success: function(data){ 
						var obj = JSON.parse(data);
	            		console.log(obj.pageId);

	            		if(obj.pageId == null){
	            			$('.close').click();
	            		}else{
		            		if(obj.pageId == isCurrentPage ){
		            				if(obj.edit_mode == 3 && obj.user != theUser){
		            					$('#myBtn').click();
		            				}else{
		            					$('.close').click();
		            				}
		            		}	             
	                    }

	                   }
	        });
		}, 3000);

		var userRole = <? echo "'".$_SESSION['uInfo']['role']."'"; ?>;

		$('form :input').on('change', function() {
		   
		    $.ajax({
            type: "POST",
            data: {token:theUser,role:userRole,taskStatus:'1',pageId:'<?php echo $thisUser; ?>'},
            url: "serverPostUserStatus.php",
            success: function(data){              
            	 //console.log(data);
                }
            });
		});	

		$("form ").submit(function( event ) {		 
		  $.ajax({
            type: "POST",
            data: {token:theUser,taskStatus:'0'},
            url: "serverPostUserStatus.php",
            success: function(data){              
            	 //console.log(data);
                }
           });
		});
	});

</script>

</body>
</html>
