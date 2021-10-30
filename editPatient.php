<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
$patient = $_GET['p'];
?>
<!doctype HTML>
<html>
<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>

<script>
jQuery(function($){
 //  $("#dob").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#phone").mask("(999) 999-9999");
//   $("#tin").mask("99-9999999");
//   $("#ssn").mask("999-99-9999");
});
</script>
<style>
.delete{
	background-color:#FF0000;
	color:#FFFFFF;
	font-weight:bold;

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
		Editing Patient Number 
		<?php
		echo $patient;
		?>
		</div>
<?php

// 'onsubmit="return validateForm();" name = "newClinic" id = "newClinic"'
formForm('proc/editPatient.php','post');
$sql = "SELECT * FROM patients WHERE id = '{$patient}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);

foreach($row as $k => $v){
	$ND=false;
	switch($k){
		default:
		$kw = str_replace('_',' ',$k);
		$kw = str_replace('addr', 'address',$kw);
		$kw = ucwords($kw);
		break;
		case 'name_f':
			$kw = 'First Name';
		break;
		
		case 'name_l':
			$kw = 'Last Name';
		break;
		case "language":
		//$myl = $k;
		$mylw = $languageList[$v];
		$ND=true;
		$kw = "Language";
		//$languageList[$k]=$v;
		$iptString = "<onedrop>";
		$iptString .= "<select name = 'language'>";
		$iptString .= "<option value= '{$v}'>{$mylw}</option>";
		foreach($languageList as $lk => $lv){
			$iptString .= "<option value = '{$lk}'>{$lv}</option>";
		}
		$iptString .= "</select>";
		$iptString .= "</onedrop>";
		break;
		case "gender":
			$kw = 'Gender';
			$ND = true;
			$iptString= "<oneDrop>";
			$iptString .= "<select name = '{$k}'>";
			$iptString .=  "<option value = '{$v}'>{$v}</option>";
			$iptString .=  "<option value = 'M'>Male</option>";
			$iptString .=  "<option value = 'F'>Female</option>";
			$iptString .= "</select>";
			$iptString .= "</oneDrop>";
		break;
		case 'id':
			$kw = 'ID';
		break;
		case 'mrn':
			$kw = 'MRN';
		break;
		case 'dob':
			$kw = 'DOB';
		break;
		case 'prefered_interpreter':
			$kw = 'Preferred Interpreter';
		break;
		case 'insurance_id':
			$kw = 'Insurance ID';
		break;
		case 'insurance_provider':
			$kw = 'Insurance Provider';
			$ND = true;
			$myiw = $insuranceList[$v];
			$iptString = "<onedrop>";
			$iptString .= "<select name = 'insurance_provider'>";
			$iptString .= "<option value= '{$v}'>{$myiw}</option>";
			foreach($insuranceList as $ik => $iv){
				$iptString .= "<option value = '{$ik}'>{$iv}</option>";
			}
			$iptString .= "</select>";
			$iptString .= "</onedrop>";
		break;
		case 'clinic_id':
			$kw = 'Clinic ID';
		break;
		case 'facility_id':
			$kw = 'Facility ID';
		break;
		case 'history':
			$kw = 'History';
			$ND = true;
			$iptString = "<input type = 'text' name = 'history' readonly = 'true' value = '{$v}'>";
			
		break;

	
	}
	if(!$ND){

		
		if($k == 'inactivepatient'){
			$flag = 1;
			continue;
		}else{
			formLabel($k,$kw);
			formInput($k,'text',$v,"id = {$k}");
		}
	} else {


		formLabel($k,$kw);
		echo $iptString;
	}
	clearfix();
}
formLabel("inactive","Mark Inactive");
echo '<input type="checkbox" name="inactivepatient" value="0" >';
clearfix();
echo "<input type = 'submit' value = 'Submit Changes'>";
formClose();
formForm('proc/deletePatient.php','post','onsubmit = "return confirmDelete();"');
formInput('delID','hidden',$patient);
echo "<input type = 'submit' value = 'Delete This Patient' class = 'delete' >";
formClose();
clearfix();
/*
	formLabel($k,$k);
	// function formInput($name,$type,$value,$param){
	formInput($k,'text',$v,'id = "{$k}"');
	clearfix();

}
*/


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
		var isCurrentPage = <? echo $patient; ?>;
		var theUser = <? echo "'".$_SESSION['uInfo']['uname']."'"; ?>;
		setInterval( function() 
		{
			$.ajax({
	            type: "POST",
	            data: {isPage:isCurrentPage},           
	            url: "serverCheckWriteStatus.php",
	            success: function(data){ 
						var obj = JSON.parse(data);
	            		//console.log(obj.pageId);

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
            data: {token:theUser,role:userRole,taskStatus:'1',pageId:'<?php echo $patient; ?>'},
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

<?php
/*
switch($k){
		case 'id':
			formLabel('none','Clinic ID');
			formInput($k,'text',$v,'readonly = "true" style = "background-color:#CCC;"');
		break;
		case 'clinic_id':
			formLabel($k,'Facility');
			$sql = "SELECT title FROM facilities WHERE id = '{$v}'";
			$g2 = mysql_query($sql);
			$r2 = mysql_fetch_assoc($g2);
			$fTitle = $r2['title'];
			formInput($k,'hidden',$v,'readonly = "true" style = "background-color:#CCC;"');
			formInput('ignore','test',$fTitle,'readonly = "true" style = "background-color:#CCC;"');
		break;
		case 'title':
			formLabel($k,'Clinic Title');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'addr_1':
			formLabel($k,'Address 1');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'addr_2':
			formLabel($k,'Address 2');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'addr_city':
			formLabel($k,'City');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'addr_state':
			formLabel($k,'STATE');
			formInput($k,'text',$v,"id = '{$k}'"); // change to dropdown?
		break;
		case 'addr_zip':
			formLabel($k,'Zip');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'email':
			formLabel($k,'Email');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'phone_1':
			formLabel($k,'Phone 1');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'phone_2':
			formLabel($k,'Phone 2');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'fax':
			formLabel($k,'Fax');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
	
	}
	clearfix();
*/
?>
