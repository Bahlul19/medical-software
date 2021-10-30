<?php
$SECURE = TRUE;
require("inc/init.php");

//new code for 24-12-18
$facilityEditID = $_GET['id'];


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

.headquarters
{
	line-height: 1.2em;
}

</style>
<link href="css/jquery.datepick.css" rel="stylesheet">
<script src="js/jquery.datepick.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script>
jQuery(function($){
 //  $("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#telephone1").mask("(999) 999-9999");
   $("#telephone2").mask("(999) 999-9999");
   $("#faxnumber").mask("(999) 999-9999");
//   $("#tin").mask("99-9999999");
//   $("#ssn").mask("999-99-9999");
});
</script>
<script>
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

<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>


<div class = 'siteWrap'>


	<div class = 'aptForm'>
		<div class = 'formTitle'>
		Editing Facility Number 
		<?php
		echo $facility;
		?>
		</div>
<?php

//new code of 24-12-18

formForm('proc/editFacilities.php','post');
$sql = "SELECT * FROM facilityredo WHERE id = '{$facilityEditID}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
foreach($row as $k => $v)
{

	switch($k)
	{
		case 'id':
			formInput($k,'hidden',$v,"id = '{$_GET['id']}'");
		break;
		case 'title':
			formLabel($k,'Title');
			formInput($k,'text',$v,"id = '{$k}'");
		break;

		case 'headquaters_clinic':
			formLabel($k,'Headquater');
			formInput($k,'text',$v,'id = "{$k}"','readonly = "true"');
			//formInput('','text',$thisFac,'readonly = "true"');
				
			/*formLabel($k,'Headquater');
			$sql = "SELECT title FROM clinics WHERE id = '{$v}'";
			$g2 = mysql_query($sql);
			$r2 = mysql_fetch_assoc($g2);
			$fTitle = $r2['title'];
			formInput($k,'hidden',$v,'readonly = "true" style = "background-color:#CCC;"');
			formInput('ignore','test',$fTitle,'readonly = "true" style = "background-color:#CCC;"');*/
		break;
		case 'address1':
			formLabel($k,'Address 1');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'address2':
			formLabel($k,'Address 2');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'city':
			formLabel($k,'City');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'state':
			formLabel($k,'State');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'zip':
			formLabel($k,'Zip');
			formInput($k,'number',$v,"id = '{$k}'");
		break;
		case 'email':
			formLabel($k,'Email');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'telephone1':
			formLabel($k,'TelePhone 1');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'telephone2':
			formLabel($k,'TelePhone 2');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'faxnumber':
			formLabel($k,'Fax Number');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
		case 'contracted_date':
			formLabel('popupDatepicker','Date');
			//formInput($k,'text',$v,"id = '{$k}'");
			formInput($k,'text',$v,'readonly="true" id="popupDatepicker" onblur="checkBook();"');
		break;
		case 'authorized_by':
			formLabel($k,'Authorized By');
			formInput($k,'text',$v,"id = '{$k}'");
		break;
	}
clearfix();
}

echo "<input type = 'submit' value = 'Submit Changes'>";
formClose();
formForm('proc/deleteFacility.php','post','onsubmit = "return confirmDelete();"');
formInput('delID','hidden',$facilityEditID);
echo "<input type = 'submit' value = 'Delete This Facility' class = 'delete' >";
formClose();
clearfix();
?>




	</div> <!-- aptForm -->
</div> <!-- siteWrap -->
<script>
function confirmDelete(){
var $conf = confirm("You are about to DELETE this Facility. This process is NOT REVERSIBLE All clinics associated with this facility will also be deleted. Press OK to PERMANENTLY DELETE this facility, or Cancel to cancel.");
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
?>


</body>
</html>


