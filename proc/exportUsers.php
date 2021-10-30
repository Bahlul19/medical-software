<?php
//$phpRoot = '/var/www/portal'; // dev
$phpRoot = '/home/itasca11/public_html/portal'; //Production

if($_SERVER['HTTP_HOST'] != 'itascainterpreter.biz') {
	$phpRoot = '/dev.itascainterpreter.biz/portal';
}

require_once("{$phpRoot}/inc/init.php"); // dev

//print_r($_GET);
$sql = $_GET['sql'];
$fileName = $_GET['fileName'];
$fileName = str_replace(' ','_',$fileName);
$fileName = str_replace('/','_',$fileName);
$fileName = str_replace('"','_',$fileName);
$fileName = str_replace("'",'_',$fileName);
$go = mysql_query($sql);

$rows = array();
$headers = array(
	'ID',
	'Role',
	'Gender',
	'Roster No',
	'Roster Exp',
	'Languages',
	'Clinic',
	'Facility',
	'First Name',
	'Last Name',
	'User Name',
	'Phone 1',
	'Phone 2',
	'Email',
	'Address 1',
	'Address 2',
	'City',
	'State',
	'Zip'
	
);

array_push($rows,$headers);

while ($row = mysql_fetch_assoc($go)){
	$thisId = $row['id'];
$converted = array();
	foreach($row as $k=>$v){
		switch($k){
			default:
				$converted[$k] = $v;
			break;
			
			case "role":
				$sq2 = "SELECT title FROM roles WHERE id = '{$v}'";
				$go2 = mysql_query($sq2) or die(mysql_error());
				$row2 = mysql_fetch_assoc($go2);
				$converted[$k] = $row2['title'];
				if($v == 5){
					$isInt = TRUE; // is an interpreter
				} else {
					$isInt = FALSE; // not
				}
				
				// put the whole int show here?
				
				if($isInt){ // int data get?
			$sql2 = "SELECT * FROM interpreters WHERE id = '{$thisId}'";
			$go2= mysql_query($sql2);
			$r2 = mysql_fetch_assoc($go2);
			
			
			$gender = $r2['gender'];
			$l1 = $r2['language_1'];
			$l2 = $r2['language_2'];
			$l3 = $r2['language_3'];
			$l4 = $r2['language_4'];
			$rosID = $r2['roster_number'];
			$rosEXP = $r2['roster_expiration'];
			
			$s3 = "SELECT language FROM languages WHERE id = '{$l1}'";
			$g = mysql_query($s3);
			$rr1 = mysql_fetch_assoc($g);
			$l1 = $rr1['language'];
			
			$s3 = "SELECT language FROM languages WHERE id = '{$l2}'";
			$g = mysql_query($s3);
			$rr1 = mysql_fetch_assoc($g);
			$l2 = $rr1['language'];
			
			$s3 = "SELECT language FROM languages WHERE id = '{$l3}'";
			$g = mysql_query($s3);
			$rr1 = mysql_fetch_assoc($g);
			$l3 = $rr1['language'];
			
			$s3 = "SELECT language FROM languages WHERE id = '{$l4}'";
			$g = mysql_query($s3);
			$rr1 = mysql_fetch_assoc($g);
			$l4 = $rr1['language'];
			
			$converted['gender'] = $gender;
			$converted['roster_no'] = $rosID;
			$converted['roster_exp'] = $rosEXP;
			$converted['languages'] = "{$l1}, {$l2}, {$l3}, {$l4}";
			
		} else { // no, dont
			$converted['gender'] = '';
			$converted['roster_no'] = '';
			$converted['roster_exp'] = '';
			$converted['languages'] = "";
		}
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
			
			case "facility":
				$sq2 = "SELECT title FROM facilities WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$clinTitle = $r2['title'];
	
				
				$converted[$k] =  $clinTitle;
			break;
		}
		
		
		
		//
	}
	array_push($rows,$converted);
}
// okay this worked

$fp = fopen("{$phpRoot}/out/{$fileName}.csv", 'w');
foreach($rows as $fields){
	fputcsv($fp, $fields);
}
fclose($fp);






//print_r($converted);
//echo"<hr>";

echo "File {$fileName} has been created! ";
echo "<form action = 'dl.php' method = 'post' style = 'display:inline-block;'>";
echo "<input type = 'hidden' name = 'fileName' value = '{$fileName}.csv'>";
echo "<input type = 'hidden' name = 'return' value = 'viewUsers.php'>";
echo "<input type = 'submit' value = 'Click Here To Download'>";
echo "</form>";

//print_r($rows);
//makeTable($rows);
?>
