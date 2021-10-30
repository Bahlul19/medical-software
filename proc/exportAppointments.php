<?php
//$phpRoot = '/var/www/portal'; // dev
$phpRoot = '/home/itasca11/public_html/portal'; //Production

if($_SERVER['HTTP_HOST'] != 'itascainterpreter.biz') {
	$phpRoot = '/dev.itascainterpreter.biz/portal';
}

require_once("{$phpRoot}/inc/init.php"); // dev
if($uInfo['role'] == 1 || $uInfo['role'] == 2){

//print_r($_GET);
$sql = $_GET['sql'];
$fileName = $_GET['fileName'];
$fileName = str_replace(' ','_',$fileName);
$fileName = str_replace('/','_',$fileName);
$fileName = str_replace('"','_',$fileName);
$fileName = str_replace("'",'_',$fileName);
$go = mysql_query($sql);
//id,status,apt_date,duration,asap,interpreter_req,patient,facility,clinic,interpreter_claim,interpreter_confirmed,requested_by,date_requested,confirmed_by

$rows = array();
$headers = array(
	'ID',
	'Status',
	'Appointment Date ',
	'Appointment Time',
	'Duration',
	'ASAP', 
	'Int. Requested',
	'Language',
	'Patient Fname',
	'patient Lname',
	'Patient DOB',
	'Facility ID',
	'Clinic',
	'Int Claims',
	'Int. Confirmed',
	'Confirmed By',
	'Date Of Request',
);

array_push($rows,$headers);

while ($row = mysql_fetch_assoc($go)){
$converted = array();
	foreach($row as $k=>$v){
		switch($k){
			default:
				$converted[$k] = $v;
			break;
			
			case "status":
				$sq2 = "SELECT title FROM appointment_status WHERE id = '{$v}'";
				$go2 = mysql_query($sq2) or die(mysql_error());
				$row2 = mysql_fetch_assoc($go2);
				$converted[$k] = $row2['title'];
				
			break; 
			case "apt_date":
				$thisDate = date("m/d/Y",$v);
				$thisTime = date("h:i A",$v);
				$converted['appoitnment_date'] = $thisDate;
				$converted['appointmnet_time'] = $thisTime;
			break;
			case "date_requested":
				$thisDate = date("m/d/Y",$v);
				$thisTime = date("h:i A",$v);
				$converted['req_date'] = "{$thisDate} {$thisTime}";
				//$converted['appointmnet_time'] = $thisTime;
			break;
			case "duration":
				$converted[$k] = $v;
			break;
			case "clinic":
				$sq2 = "SELECT title, addr_1, addr_2, addr_city, addr_state, addr_zip, phone_1 FROM clinics WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$facTitle = $r2['title'];
				$facAdr = $r2['addr_1'] . " ";
				$facAdr .= $r2['addr_2'] . " ";
				$facAdr .= $r2['addr_city'] . " ";
				$facAdr .= $r2['addr_state'] . " ";
				$facAdr .= $r2['addr_zip'] . " ";
				$facPhone = $r2['phone_1'];
				
				$converted[$k] = $facTitle;
			break;
			
			case "interpreter_req":
				$sq2 = "SELECT name_f,name_l FROM users WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$fname = $r2['name_f'];
				$lname = $r2['name_l'];
				
				$converted['fname'] =  "{$fname} {$lname}";
			
			break;
			
			case "interpreter_claim":
				$sq2 = "SELECT name_f,name_l FROM users WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$fname = $r2['name_f'];
				$lname = $r2['name_l'];
				
				$converted['cfname'] =  "{$fname} {$lname}";
			break;
			
			case "interpreter_confirmed":
				$sq2 = "SELECT name_f,name_l FROM users WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$fname = $r2['name_f'];
				$lname = $r2['name_l'];
				
				$converted['fCname'] =  "{$fname} {$lname}";
			
			break;
			
			case 'patient':
				$sq2 = "SELECT name_f,name_l,dob,language FROM patients WHERE id = '{$v}'";
				$go2 = mysql_query($sq2);
				$r2 = mysql_fetch_assoc($go2);
				$pfn = $r2['name_f'];
				$pln = $r2['name_l'];
				$pdob = $r2['dob'];
				$pLang = $r2['language'];
				$sq3 = "SELECT language FROM languages WHERE id = '{$pLang}'";
				$g3 = mysql_query($sq3);
				$r3 = mysql_fetch_assoc($g3);
				$pLang = $r3['language'];
				$converted['language'] = $pLang;
				$converted['pfn'] = $pfn;
				$converted['pln'] = $pln;
				$converted['pdob'] = $pdob;
			break;
			case 'requested_by':
				$sq2 = "SELECT name_f,name_l FROM users WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$fname = $r2['name_f'];
				$lname = $r2['name_l'];
				
				$converted['fRBname'] =  "{$fname} {$lname}";
			break;
			case 'date_requested':
				$reqDate = date("m/d/y h:i A");
				$converted['reqDate'] = $reqDate;
			break;
			
			case 'confirmed_by':
				$sq2 = "SELECT name_f,name_l FROM users WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$fname = $r2['name_f'];
				$lname = $r2['name_l'];
				
				$converted['CBname'] =  "{$fname} {$lname}";
			break;
			
		}
	}
	array_push($rows,$converted);
}
// okay this worked


$fp = fopen("{$phpRoot}/out/{$fileName}.csv", 'w');
foreach($rows as $fields){
	fputcsv($fp, $fields);
}
fclose($fp);



//echo $sql;



//echo "File {$fileName} has been created! ";
echo "<form action = 'dl.php' method = 'post' style = 'display:inline-block;'>";
echo "<input type = 'hidden' name = 'fileName' value = '{$fileName}.csv'>";
echo "<input type = 'hidden' name = 'return' value = 'viewUsers.php'>";
echo "<input type = 'submit' value = 'Download {$fileName}'>";
echo "</form>";
//print_r($rows);
//makeTable($rows);
} else {
	echo "NOT SO MUCH";
}
?>
