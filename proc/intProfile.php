<?php
require("../inc/init.php");
?>
<div style = "width:100%;height:50px;background-color:#00FF00;text-align:center;"> 
<?php
$intTable = $_GET;
$uid = $intTable['uid'];
$usTable = array();
// Okay gather the USER table info
$usTable['phone_1'] = $intTable['phone_1'];
$usTable['phone_2'] = $intTable['phone_2'];
$usTable['email'] = $intTable['email'];
$usTable['addr_1'] = $intTable['addr_1'];
$usTable['addr_2'] = $intTable['addr_2'];
$usTable['addr_city'] = $intTable['addr_city'];
$usTable['addr_state'] = $intTable['addr_state'];
$usTable['addr_zip'] = $intTable['addr_zip'];
$usTable['date_hire'] = $intTable['date_hire'];
$usTable['edu'] = $intTable['edu'];
unset($intTable['edu']);
unset($intTable['phone_1']);
unset($intTable['phone_2']);
unset($intTable['email']);
unset($intTable['addr_1']);
unset($intTable['addr_2']);
unset($intTable['addr_city']);
unset($intTable['addr_state']);
unset($intTable['addr_zip']);
unset($intTable['uid']);

//unset($usTable['uid']);

// Okay so now we have users tabel data and interpreter table data separate.
// function updateTable($table,$col,$id,$array){
// $sql = "UPDATE {$table} SET {$key} = '{$value}' WHERE {$col} = '{$id}'";

//print_r($usTable);
updateTable('users','id',$uid,$usTable);
updateTable('interpreters','id',$uid,$intTable);
echo "Your Changes Have Been Saved.";

?>

</div>
