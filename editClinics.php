<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
$clinic = $_GET['c'];
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
		Editing Clinic Number 
		<?php
		echo $clinic;
		?>
		</div>
<?php
// 'onsubmit="return validateForm();" name = "newClinic" id = "newClinic"'
formForm('proc/editClinics.php','post');
$sql = "SELECT * FROM clinics WHERE id = '{$clinic}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
foreach($row as $k => $v){

	switch($k){
		case 'id':
			formLabel('none','Clinic ID');
			formInput($k,'text',$v,'readonly = "true" style = "background-color:#CCC;"');
		break;
		case 'clinic_id':
			formLabel($k,'Facility');
			$sql = "SELECT title FROM facilityredo WHERE id = '{$v}'";
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
			formLabel($k,'State');
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

		case 'note':
			formLabel($k,'Note');
			formInput($k,'note',$v,"id = '{$k}'");
		break;

		case 'history':
			formLabel($k,'History');
			formInput($k, 'history',$v,"id = '{$k}'", 'readonly = "TRUE"');
		break;
	
	}
	clearfix();
}

formLabel("inactive","Mark Inactive");
echo '<input type="checkbox" name="inactive_clinic" value="1" >';
clearfix();
//formLabel('','');
echo "<input type = 'submit' value = 'Submit Changes'>";
formClose();
formForm('proc/deleteClinic.php','post','onsubmit = "return confirmDelete();"');
formInput('delID','hidden',$clinic);
echo "<input type = 'submit' value = 'Delete This Clinic' class = 'delete' >";
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
var $conf = confirm("You are about to DELETE this clinic. This process is NOT REVERSIBLE. Press OK to PERMANENTLY DELETE this clinic, or Cancel to cancel.");
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
		var isCurrentPage = <? echo $clinic; ?>;
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
            data: {token:theUser,role:userRole,taskStatus:'1',pageId:'<?php echo $clinic; ?>'},
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


