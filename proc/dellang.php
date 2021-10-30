<?php
require("../inc/init.php");
//
$press = $_GET['q'];
$ch = explode('_',$press);
$delLang = $ch[1];

echo "delete language {$delLang} -- ";
$sql = "SELECT language FROM languages WHERE id = '{$delLang}'";
$go = mysql_query($sql)or die (mysql_error());
$row = mysql_fetch_assoc($go);
//print_r($row);
$delLangName = $row['language'];
echo " ( \"{$delLangName}\" ) <br>";
$sql = "SELECT id FROM patients WHERE language = '{$delLang}'";
$go = mysql_query($sql);
$num = mysql_num_rows($go); 


echo "<input type = 'hidden' id = 'delId' value = '{$delLang}'>";

if($num > 0){ // if there are appointments in this language
	echo "There are currently <b> {$num} </b> patients who speak this language. <br><br>";
	echo "Please select from the dropdown menu which Language you wish to re-assign to the patients currently assigned to \"{$delLangName}\"<br><br>";
	
	echo "Please note, deleteing a language <b>CAN NOT</b> be undone. By pressing \"Re-assign And Delete\" you will delete the language called \"{$delLangName}\" ";
	echo " and reassign all patients to the replacement language you select. <br><br>";
	
	
	$sql = "select id, language FROM languages WHERE id <> '{$delLang}'";
	$go = mysql_query($sql);
	
	
	echo "Please select which langauge you wish to assign to all appointents currently assigned to \"{$delLangName}\":<br>";
	echo "<select id = 'newLang' name = 'newLang' >";
	
	
	while($row = mysql_fetch_assoc($go)){
		$optId = $row['id'];
		$optLang = $row['language'];
		echo "<option value = '{$optId}'> $optLang </option>";
	}
	
	echo "</select>";
	echo "<hr>";
	echo "<br><button onclick = 'updateDeleteLang();'> Re-assign And Delete </button>";
	echo "&nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp; <button onclick = 'modalClose();'> Cancel </button>";


} else {
	echo "This language is not spoken by any patients <br>";
	echo "Deleting immediately. <br>";
	$sq3 = "DELETE FROM languages WHERE id = '{$delLang}'";
	$go = mysql_query($sq3);
	echo "Done! <br><br>";
	echo "<a href = '/portal/editLanguages.php' style = 'border:1px solid #000;padding:5px 3px 5px 3px;background-color:#ccc;'> Close </a>";

}


?>
