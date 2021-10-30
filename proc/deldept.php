<?php
//dete department and re-assign users
//$SECURE = TRUE;
require("../inc/init.php");


$l = $_GET['q'];

$parts = explode('_',$l);
$thisDept = $parts[1];
$sql = "select title from departments WHERE id = '{$thisDept}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$deptTitle = $row['title'];

echo "You are about to delete the department called {$deptTitle} from the system. <br><br>";

$sql = "select id FROM appointment_requests WHERE department = '{$thisDept}'";
$go = mysql_query($sql);
$num = mysql_num_rows($go);


echo "<input type = 'hidden' id = 'delId' value = '{$thisDept}'>";

if($num > 0){ // if there are appointments in this department
	echo "There are currently <b> {$num} </b> appointments using this department. <br><br>";
	echo "Please select from the dropdown menu which department you wish to re-assign to the appointments currently assigned to \"{$deptTitle}\"<br><br>";
	
	echo "Please note, deleteing a department <b>CAN NOT</b> be undone. By pressing \"Re-assign And Delete\" you will delete the department called \"{$deptTitle}\" ";
	echo " and reassign all appointments to the replacement department you select. <br><br>";
	
	
	$sql = "select id, title FROM departments WHERE id <> '{$thisDept}' ORDER BY title ASC";
	$go = mysql_query($sql);
	
	
	echo "Please select which department you wish to assign to all appointents currently assigned to \"{$deptTitle}\":<br>";
	echo "<select id = 'newDept' name = 'newDept' >";
	
	
	while($row = mysql_fetch_assoc($go)){
		$optId = $row['id'];
		$optTitle = $row['title'];
		echo "<option value = '{$optId}'> $optTitle </option>";
	}
	
	echo "</select>";
	//echo "This is a result {$l} <br>";
echo "<br><button onclick = 'updateDeleteDept();'> Re-assign And Delete </button>";
echo "&nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp; <button onclick = 'modalClose();'> Cancel </button>";


} else {
	echo "There are zero appointments with this deprtment. Deleting immediately.<br>";
	$delthis = "DELETE FROM departments WHERE id = '{$thisDept}'";
	$go = mysql_query($delthis);
	echo "Department {$deptTitle} has been deleted. <br> <br> ";
	echo "<a href = '/portal/editDepartments.php' style = 'border:1px solid #000;padding:5px 3px 5px 3px;background-color:#ccc;'> Close </a>";
}




?>

