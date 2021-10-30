<?php
//$phpRoot = '/var/www/portal'; // dev
$phpRoot = '/home/itasca11/public_html/portal'; //Production

if($_SERVER['HTTP_HOST'] != 'itascainterpreter.biz') {
	$phpRoot = '/dev.itascainterpreter.biz/portal';
}

require_once("{$phpRoot}/inc/init.php"); // dev
// Lets clean $_GET by needed stuff.
$others = array();



foreach($_GET as $k => $v){
	if($v != 'ANY' && $v != '' && $v != 'false'){
		if($k == 'patient'){
			$qq = explode(' ',$v);
			if(is_numeric($qq[0])){
			$others['id'] = $qq[0];
			} else {
			// logic for name search here
			}
		} else {
			$others[$k] = $v;
		}
	}
}

$where = " WHERE ";
if($role == 3){
	$where .= " facility_id = '{$uInfo['facility']}' ";
}
if($role == 4){
	$where .= " facility_id = '{$uInfo['facility']}' ";
}
foreach($others as $k => $v){
	if ($where != " WHERE "){
		$where .= " AND ";
	}
	$where .= "{$k} = '{$v}'";
}


$sql = "SELECT * FROM patients"; // this is the big mod

if($where != ' WHERE '){
		$sql .= $where;
}



$go = mysql_query($sql)or die(mysql_error());

//echo "$sql";
hr();
echo "<table border = '1'>";
echo "<tr>";

	echo "<th> ID </td>";
	echo "<th> First Name </th>";
	echo "<th> Last Name </th>";
	echo "<th> MRN </th>";
	echo "<th> Gender </th>";
	echo "<th> DOB </th>";
	echo "<th> Language </th>";
	echo "<th> Prefered Int </th>";
	echo "<th> Address 1 </th>";
	echo "<th> Address 2 </th>";
	echo "<th> City </th>";
	echo "<th> State </th>";
	echo "<th> Zip </th>";
	echo "<th> Insurace </th>";
	echo "<th> Insurance ID </th>";
	echo "<th> Phone</th>";
	
	echo "<th> Clinic</th>";
	echo "<th> Facility</th>";
	echo "<th> History </th>";
	

	
echo "</tr>";

while ($row = mysql_fetch_assoc($go)){
	$aptId = $row['id'];
echo "<tr>";
	foreach($row as $k=>$v){
		switch($k){
			default:
			echo "<td> {$v} </td>";
			break;
			
			case "language":
				$sq2 = "SELECT language FROM languages WHERE id = '{$v}'";
				$go2 = mysql_query($sq2) or die(mysql_error());
				$row = mysql_fetch_assoc($go2);
				echo "<td> {$row['language']} </td>";
			break; 
			
			case "clinic_id":
				$sq2 = "SELECT title, addr_1, addr_2, addr_city, addr_state, addr_zip, phone_1 FROM clinics WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die ("clinic_id" . mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$facTitle = $r2['title'];
				$facAdr = $r2['addr_1'] . " ";
				$facAdr .= $r2['addr_2'] . " ";
				$facAdr .= $r2['addr_city'] . " ";
				$facAdr .= $r2['addr_state'] . " ";
				$facAdr .= $r2['addr_zip'] . " ";
				$facPhone = $r2['phone_1'];
				
				echo "<td title = '{$facTitle} - Address:{$facAdr} - Phone: {$facPhone}'> $facTitle </td>";
				//echo "<td> CLINIC </td>";
			break;
			
			case "facility_id":
				$sq2 = "SELECT title FROM facilities WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$clinTitle = $r2['title'];
	
				
				echo "<td> $clinTitle </td>";
				//echo "<td> FACILITY </td>";
			break;
			
			
			
			case "insurance_provider";
				$sq2 = "SELECT title FROM insurance_providers WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$insTitle = $r2['title'];
				echo "<td> $insTitle </td>";
			break;

		
		}
	}
	echo "</tr>";

}
echo "</table>";

?>
<div id = 'reportSQL' style = 'display:none;'>
<?php
echo $sql;
?>
</div>
