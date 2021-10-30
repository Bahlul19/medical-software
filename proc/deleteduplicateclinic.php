<?php
//dete department and re-assign users
//$SECURE = TRUE;
require("../inc/init.php");


$cl = $_GET['q'];
$clinicparts = explode('_',$cl);
// $thisDept = $parts[1];

//This line added for the clinic id into the website
$thisClinic = $clinicparts[1];
$sql = "SELECT title from clinics WHERE id = '{$thisClinic}' ORDER BY title ASC";
//var_dump($sql);
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$clinicTitle = $row['title'];

echo "You are about to delete the clinic called {$clinicTitle} from the system. <br><br>";

$sql = "SELECT id FROM appointment_requests WHERE clinic = '{$thisClinic}'";
$go = mysql_query($sql);

// var_dump($sql);

$num = mysql_num_rows($go);




// echo "<input type = 'hidden' id = 'clinicdelId' value = '{$thisClinic}'>";

echo "<input type = 'hidden' id = 'delId' value = '{$thisClinic}'>";

if($num > 0){ // if there are appointments in this department
	echo "There are currently <b> {$num} </b> appointments using this clinic. <br><br>";
	echo "Please select from the dropdown menu which clinic you wish to re-assign to the appointments currently assigned to \"{$clinicTitle}\"<br><br>";
	
	echo "Please note, deleteing a clinic <b>CAN NOT</b> be undone. By pressing \"Re-assign And Delete\" you will delete the department called \"{$clinicTitle}\" ";
	echo " and reassign all appointments to the replacement clinic you select. <br><br>";
	
	
	$sql = "select id, title FROM clinics WHERE id <> '{$thisClinic}' ORDER BY title ASC";
	$go = mysql_query($sql);
	
	
	echo "Please select which clinic you wish to assign to all appointents currently assigned to \"{$clinicTitle}\":<br>";
	echo "<select id = 'newClinic' name = 'newClinic' >";
	
	
	while($row = mysql_fetch_assoc($go)){
		$optId = $row['id'];
		$optTitle = $row['title'];
		echo "<option value = '{$optId}'> $optTitle </option>";
	}
	
	echo "</select>";
	//echo "This is a result {$l} <br>";
echo "<br><button onclick = 'updateDeleteClinic();'> Re-assign And Delete </button>";
echo "&nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp; <button onclick = 'modalClose();'> Cancel </button>";


} else {
	echo "There are zero appointments with this clinic. Deleting immediately.<br>";
	$delthis = "DELETE FROM clinics WHERE id = '{$thisClinic}'";
	$go = mysql_query($delthis);
	echo "Clinic {$clinicTitle} has been deleted. <br> <br> ";
	echo "<a href = '/portal/viewClinics.php' style = 'border:1px solid #000;padding:5px 3px 5px 3px;background-color:#ccc;'> Close </a>";
}




?>

