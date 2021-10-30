<?php
//$phpRoot = '/var/www/portal'; // dev
$phpRoot = '/home/itasca11/public_html/portal'; //Production

if($_SERVER['HTTP_HOST'] != 'itascainterpreter.biz') {
	$phpRoot = '/dev.itascainterpreter.biz/portal';
}

//require_once("{$phpRoot}/inc/init.php"); // dev
// Lets clean $_GET by needed stuff.

require("inc/init.php");
$others = array();



foreach($_GET as $k => $v){
	if($v != 'ANY' && $v != '' && $v != 'false'){
		if($k != 'hi' && $k != 'hiVal'){
			$others[$k] = $v;
		}
		
	}
}

$where = " WHERE ";
if($role == 3){
	$where .= " clinic_id = '{$uInfo['clinic']}' ";
}
if($role == 4){
	$where .= " facility_id = '{$uInfo['facility']}' ";
}
foreach($others as $k => $v){
	if ($where != " WHERE "){
		$where .= " AND ";
	}
	if($k =='name_f' || $k == 'name_l'){
		$where .= "{$k} LIKE '%{$v}%'"; // names are LIKE %value%
	} else {
		$where .= "{$k} = '{$v}'";
	}
}


$sql = "SELECT id,role,clinic,facility,name_f,name_l,uname,phone_1,phone_2,email,addr_1,addr_2,addr_city,addr_state,addr_zip FROM users ";

if($where != ' WHERE '){
		$sql .= $where;
}

//$sql .= " ORDER BY name_l ASC ";
$sql .= " ORDER BY role, name_l, name_f ASC ";
hr();

$go = mysql_query($sql)or die(mysql_error());


echo "<table border = '1' id = 'export_table'>";
echo "<tr>";
	if($uInfo['role'] == 1 || $uInfo['role'] == 2){
		echo "<th> EDIT </th>";
	}
	echo "<th> ID </td>";
	echo "<th> Role </td>";
//	echo "<th> Clinic </td>";
	echo "<th> Facility </td>";
	echo "<th> First Name </th>";
	echo "<th> Last Name </th>";
	echo "<th> User Name </td>";
	echo "<th> Phone 1 </td>";
	echo "<th> Phone 2 </td>";
	echo "<th> Email </td>";
	echo "<th> Address 1 </th>";
//	echo "<th> address 2 </th>";
	echo "<th> City </th>";
	echo "<th> State </th>";
	echo "<th> Zip </th>";
	echo "<th> Gender </th>";
	echo "<th> Roster Number </th>";
	echo "<th> Roster Expiration </th>";
	echo "<th> Languages </th>";
	
echo "</tr>";

while ($row = mysql_fetch_assoc($go)){
	
	$aptId = $row['id'];
	$isInt = $row['role'];
	if($isInt == 5){
		$sql2 = "SELECT gender, roster_number, roster_expiration,language_1,language_2,language_3,language_4 FROM interpreters WHERE id = '{$aptId}'";
		$go2 = mysql_query($sql2);
		$intData = mysql_fetch_assoc($go2);
		
		$intLangs = $languageList[$intData['language_1']];
		if($intData['language_2'] != '0'){
		$intLangs .= "<br>" . $languageList[$intData['language_2']];
		}
		if($intData['language_3'] != '0'){
		$intLangs .= "<br>" . $languageList[$intData['language_3']];
		}
		if($intData['language_4'] != '0'){
		$intLangs .= "<br>" . $languageList[$intData['language_4']];
		}
		
		$intGender = $intData['gender'];
		if($intGender == 'M'){
			$intGender = 'Male';
		} elseif ($intGender == 'F'){
			$intGender = 'Female';
		}
		
		
		
		$rosterUnix = strtotime($intData['roster_expiration']);
		//30 days in seconds is 2592000
		$rosDif = $rosterUnix - $unixTimeStamp;
		if($rosDif < 0){
			$rosEXP = 'URGENT';
		} elseif($rosDif < 2592000){
				$rosEXP = 'YES';		
		} else {
				$rosEXP = 'NO';
		}
	} else {
		$rosEXP = 'NO';
	}
	if($rosEXP == 'YES'){
		echo "<tr style = 'background-color:#FF0000;'>";
	} elseif($rosEXP == 'URGENT') {
		echo "<tr style = 'background-color:#000000;color:#FFFFFF;font-weight:bold;'>";
	} else {	
		echo "<tr>";
	}
	if($uInfo['role'] == 1 || $uInfo['role'] == 2){
		echo "<td> <a class = 'editButton' href = 'editUser.php?u={$aptId}'> Edit </a> </td>";
	}
	foreach($row as $k=>$v){
		
		switch($k){
			default:
			echo "<td> {$v} </td>";
			break;
			
			case "role":
				$sq2 = "SELECT title FROM roles WHERE id = '{$v}'";
				$go2 = mysql_query($sq2) or die(mysql_error());
				$row2 = mysql_fetch_assoc($go2);
				echo "<td> {$row2['title']} </td>";
				
			break; 
			
			case "clinic":
			/*	$sq2 = "SELECT title, addr_1, addr_2, addr_city, addr_state, addr_zip, phone_1 FROM clinics WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$facTitle = $r2['title'];
				$facAdr = $r2['addr_1'] . " ";
				$facAdr .= $r2['addr_2'] . " ";
				$facAdr .= $r2['addr_city'] . " ";
				$facAdr .= $r2['addr_state'] . " ";
				$facAdr .= $r2['addr_zip'] . " ";
				$facPhone = $r2['phone_1'];
				
				echo "<td title = '{$facTitle} - Address:{$facAdr} - Phone: {$facPhone}'> $facTitle </td>";
				*/
			break;
			
			case "facility":
				$sq2 = "SELECT title FROM facilities WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$clinTitle = $r2['title'];
	
				
				echo "<td> $clinTitle </td>";
			break;
			
			case 'addr_2':
			//
			break;
		
		}
	}
	if($intData['roster_number']){
		echo "<td> {$intGender} </td>";
		echo "<td> {$intData['roster_number']} </td>";
			if($rosEXP == 'URGENT'){
				echo "<td class = 'urgent'> EXPIRED <br> {$intData['roster_expiration']} </td>";
			} else {
				echo "<td> {$intData['roster_expiration']} </td>";
			}
		echo "<td> $intLangs </td>";
		
		unset($intData['roster_number']);
		unset($intData['roster_expiration']);
		unset($intLangs);
		unset($intGender);
	} else {
		echo "<td> &nbsp; </td>";
		echo "<td> &nbsp; </td>";
		echo "<td> &nbsp; </td>";
		echo "<td> &nbsp; </td>";
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
