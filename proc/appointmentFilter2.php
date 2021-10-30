<?php
//$phpRoot = '/var/www/portal'; // dev
// $phpRoot = '/home/itasca11/public_html/portal'; //Production

require_once("../inc/init.php"); // dev

// how to get a list of patients by fname lname dob id
// yes, we will do this with a different ajax script.


// Lets clean $_GET by needed stuff.
$others = array();
$stats = array();
$dates = array();
$rDates = array();


//DEBUG
//hr();
//print_r($_GET);
//hr();

//$language = ''; // ? what is this about ?
foreach($_GET as $k => $v){
		if($v != 'ANY' && $v != '' && $v != 'false' && $v){
		// test for ors and in-betweens
		$test = explode("-",$k);
		$hit = $test[1]; // is there a val here?
		if($hit){
			switch($test[0]){
				case "status": // these are selcted statuses
					$statType = $test[1];
					$stats[$statType] = '1';
				break;
				case "apt_date": // we have a date to work with
					$dateType = $test[1];
					$unix = strtotime($v); // unix string of date;
					$dates[$dateType] = $unix; // add the unix stanp to dates array;
				break;
				case 'req_date':
					//echo "TEST1 {$test[1]} <br>";
					$rDateType = $test[1];
					//echo 
					$unixa = strtotime($v); // unix string of date;
					$rDates[$rDateType] = $unixa; // add the unix stanp to dates array;
				break;
			}
			
		} else {
			if($k == 'language' && $v != 0){ // language is special case with sub-query
				$language = $v;
				
			}
			/*if($k =='name_f' || $k == 'name_l' || $k == 'dob'){
				$name_f_l = $k;
				$name_like = $v; // names are LIKE %value%
			}*/
			else {
				$others[$k] = $v;
			}
		}
		
		
	}
}

//DEBUG 
//hr();
//print_r($others);
//hr();

//echo "<hr><hr> language =  {$language} <hr><hr>";

// END DEBUG
/*
elseif($k == 'patient'){
				$patients = explode(',',$v);
				
			}
*/


// loop through stats for OR statement
$ors = "(";
foreach($stats as $k => $v){
	if ($ors != "("){
		$ors .= " OR ";
	}
$ors .= " status = '{$k}' ";
}
$ors .= ")";


//dates GT LT
$c = count($dates);
if($c > 0){
	$dfr = $dates['FROM'];
	$dto = $dates['TO'];
	$dto += 86400;
	if($c == 1){ // ONLY ONE DATE IS IN PLACE
		
		if($dfr != ''){ // we have only a from date
			$dateClause = " apt_date > '{$dfr}' ";
		} else { // we have only a to date
			$dateClause = " apt_date < '{$dto}' ";
		}
	} else { // BOTH DATES ARE IN PLACE
		$dateClause = "( apt_date > '{$dfr}' AND apt_date < '{$dto}' ) ";
	}
}


// rDates GT LT
$c = count($rDates);
if($c > 0){
	$rdfr = $rDates['FROM'];
	$rdto = $rDates['TO'];
	$rdto += 86400;
	if($c == 1){ // ONLY ONE DATE IS IN PLACE
		
		if($rdfr != ''){ // we have only a from date
			$rDateClause = " date_requested > '{$rdfr}' ";
		} else { // we have only a to date
			$rDateClause = " date_requested < '{$rdto}' ";
		}
	} else { // BOTH DATES ARE IN PLACE
		$rDateClause = "( date_requested > '{$rdfr}' AND date_requested < '{$rdto}' ) ";
	}
}


$ands = '';
foreach ($others as $k => $v){
	if ($ands != ''){
		$ands .= " AND ";
	}
	if($k == 'patient'){
		if (is_numeric($v)){
			$ands .= "{$k} IN ( '{$v}' ) ";
		} else {
			$pList = explode(',',$v);
			//print_r($pList);
			//hr();
			foreach($pList as $pk => $pv){
				$pList[$pk] = "'{$pv}'";
			}
			$pString = implode(',',$pList);
			if($pString != '0'){ // allow ofr re-selecting ANY
				$ands .= "{$k} IN ( {$pString} ) ";
			}
		}
		
	} else {
		$ands .= "{$k} = '{$v}'";
	}
}



/* if($patients){
 	if ($ands != ''){
		$ands .= " AND ";
		$ands .= " patient IN ( {$patients} ) ";
	}
 } else {
 	//echo "NO PATIENTS";
 	//hr();
 }
*/
// now we construct the WHERE

$where = ' WHERE ';


//stats
if ($ors != '()'){
	$where .= $ors;
}


//dates
if ($dateClause != ''){
	if($where != ' WHERE '){
		$where .= " AND ";
	}
	$where .= $dateClause;
}

//rDates
if ($rDateClause != ''){
	if($where != ' WHERE '){
		$where .= " AND ";
	}
	$where .= $rDateClause;
}



// the rest
if($ands != ''){
	if($where != ' WHERE '){
		$where .= " AND ";
	}
	$where .= $ands;
}

/*if($name_f_l){
		$where .= "AND patient IN (SELECT id FROM patients WHERE {$name_f_l} LIKE '%{$name_like}%') "; // names are LIKE %value%
	}*/

// Okay here we are going to kludge in another damn thing for language
if($language){
$where .= "AND patient IN (SELECT id FROM patients WHERE language = '{$language}') ";
}


$Afields = 'id,status,apt_date,duration,department,asap,patient,facility,clinic,interpreter_claim,interpreter_confirmed,requested_by,date_requested,confirmed_by';
$sql = "SELECT $Afields FROM appointment_requests";


if($where != " WHERE "){
	$where = str_replace("tp =","patient =",$where);
		$sql .= $where;
	}

$orderBy = "apt_date";
$orderDirection = "ASC";
$sql .= " ORDER BY {$orderBy} {$orderDirection}";

$go = mysql_query($sql)or die($sql . " -- " . mysql_error());


echo "<table class='table InterperterRecordsData main-table PatientRecordsData' id = 'export_table' border = '1'>";
//echo "<table  border = '1' id = 'export_table'>";

// *****************************************************************
// *****************************************************************
// The new way *****************************************************
// *****************************************************************
// *****************************************************************


echo "<tr>";
	if($uInfo['role'] == 4){
		echo "<th> View </th>";
	} else {
		echo "<th> Edit </th>";
	}
	echo "<th> ID </td>";
	echo "<th> Status </th>";
	echo "<th> Date </th>";
	echo "<th> Time </th>";
	echo "<th> Duration </th>";
	echo "<th> Department </th>";
	echo "<th> ASAP </th>";
	echo "<th> Requested Interpreter </th>";
	
	echo "<th> Language </th>";
	echo "<th> Patient First Name </th>";
	echo "<th> Patient Last Name</th>";
	echo "<th> Patient DOB</th>";
	// echo "<th> Provider Name</th>";
	
	// echo "<th> Facility </th>";
	echo "<th> Clinic </th>";
	
	echo "<th> Interpreter Claims </th>";
	echo "<th> Confirmed Interpreter </th>";
		
	echo "<th> Requested By </th>";
	echo "<th> Provider Name</th>";
	echo "<th> Date Of Request </th>";
	echo "<th> Confirmed By </th>";
	
echo "</tr>";
// *****************************************************************
// *****************************************************************
// *****************************************************************
// *****************************************************************

while ($row = mysql_fetch_assoc($go)){
	//var_dump($row);
	//die();
	$aptId = $row['id'];

	//new code conditional check


	
	// colors
	$bgcolor="#FFFFFF"; // default
	
	
	// Today and next day appointments are RED if not confirmed
	
	if (($row['apt_date'] >= $midnightToday&& $row['apt_date'] <= $midnightDayAfter) && ($row['status'] != 3)){
		$bgcolor = "#FF0000";
	}
	
	if($row['asap'] == 'YES' && $row['status'] != '3'){
		$bgcolor="#FFA500";
	} elseif ($row['asap'] == 'CC') {
		$bgcolor="#DDDDDD";
	}
	
	// PAST DUE NEW AND PENDING ARE GREEN
	
	if ($row['apt_date'] < $midnightToday && ($row['status'] == 1 || $row['status'] == 2) ){
		$bgcolor = "#D6E3BC";
	}
	
	if($row['status'] == 6){
		$bgcolor= "#FFFF00";
	}
	
echo "<tr style = 'background-color:{$bgcolor};'>";
if($uInfo['role'] == 4){
	echo "<td> <a class = 'editButton' href = '{$htmlRoot}/appointmentViewer.php?a={$aptId}'> View </a> </td>";
} 
else {
	echo "<td> <a class = 'editButton' href = '{$htmlRoot}/appointmentEditor.php?a={$aptId}'> Edit </a> </td>";
}
	foreach($row as $k=>$v){
		$thisPatient = $row['patient'];
		switch($k){
			default:
			echo "<td> {$v} </td>";
			break;
			
			//patient data swap
			case 'patient':
				

				$sq2 = "SELECT prefered_interpreter,name_f,name_l,dob,language FROM patients WHERE id = '{$v}'";

				$go2 = mysql_query($sq2);
				$r2 = mysql_fetch_assoc($go2);
				$pPi = $r2['prefered_interpreter'];
				$pfn = $r2['name_f'];
				$pln = $r2['name_l'];
				$pdob = $r2['dob'];
				$pLang = $r2['language'];
				$sq3 = "SELECT language FROM languages WHERE id = '{$pLang}'";
				$g3 = mysql_query($sq3);
				$r3 = mysql_fetch_assoc($g3);
				$pLang = $r3['language'];
				echo "<td> {$pPi} </td>";
				echo "<td> {$pLang} </td>";
				echo "<td> {$pfn} </td>";
				echo "<td> {$pln} </td>";
				echo "<td> {$pdob} </td>";
				//echo "<td> {$pproname} </td>";
				
			break;
			
			
			
			case "apt_date":
				$Adate = date("m/d/y",$v);
				$Atime = date("h:i A",$v);
				if($v > $midnightToday && $v < $midnightDayAfter &&  ($row['status'] == 1 || $row['status'] == 2)){ // is this appointment today?
					//echo "<td style = 'background-color:#FF0000;color:#FFFFFF;font-weight:bold;'>{$Adate}</td>";
					echo "<td> $Adate </td>";
				} else {
					echo "<td> $Adate </td>";
				}
				echo "<td> $Atime </td>";
			break;
			
			case "duration":
				echo "<td> {$v} </td>";
			break;
			
			case "department":
				$sq4 = "SELECT title FROM departments WHERE id = '{$v}'";
				$go4 = mysql_query($sq4);
				$ro4 = mysql_fetch_assoc($go4);
				$deptTitle = $ro4['title'];
				echo "<td> {$deptTitle} </td>";
			break;
					
			case "asap":
				if($v == 'YES'){
					echo "<td> {$v} </td>";
				} else {
					echo "<td> {$v} </td>";
				}
			break;
			
			case 'facility':
				$sq2 = "SELECT title FROM facilityredo WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die ($sq2 . " -- " . mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				
			break;
			
			case "clinic":
				$sq2 = "SELECT title, addr_1, addr_2, addr_city, addr_state, addr_zip, phone_1 FROM clinics WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die ($sq2 . " -- " . mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$facTitle = $r2['title'];
				$facAdr = $r2['addr_1'] . " ";
				$facAdr .= $r2['addr_2'] . " ";
				$facAdr .= $r2['addr_city'] . " ";
				$facAdr .= $r2['addr_state'] . " ";
				$facAdr .= $r2['addr_zip'] . " ";
				$facPhone = $r2['phone_1'];
			
					echo "<td title = '{$facTitle} - Address:{$facAdr} - Phone: {$facPhone}'> $facTitle </td>";
			break;
			
			case "interpreter_req":
				/*$sq2 = "SELECT prefered_interpreter FROM patients WHERE id = '{$thisPatient}'";
				$go2 = mysql_query($sq2);
				$r2 = mysql_fetch_assoc($go2);
				$prefInt = $r2['prefered_interpreter'];
				echo "<td> {$prefInt} </td>";*/
				if($v != ''){ // nobody
					$sq2 = "SELECT name_f, name_l FROM users WHERE id = '{$v}'";
					$go2 = mysql_query($sq2)or die (mysql_error());
					$r2 = mysql_fetch_assoc($go2);
					$intF = $r2['name_f'];
					$intL = $r2['name_l'];
					$intName = $intF . ' ' . $intL;
				echo "<td> {$intName} </td>";
				} else {
					echo "<td> No Interpreter </td>";
				}
			
				
			break; 
			
			case "interpreter_claim":
				if($v != ''){ // nobody
					$sq2 = "SELECT name_f, name_l, phone_1, phone_2, email FROM users WHERE id = '{$v}'";
					$go2 = mysql_query($sq2)or die (mysql_error());
					$r2 = mysql_fetch_assoc($go2);
					$intF = $r2['name_f'];
					$intL = $r2['name_l'];
					$intPh1 = $r2['phone_1'];
					$intPh2 = $r2['phone_2'];
					$intEmail = $r2['email'];
					$intName = $intF . ' ' . $intL;
					$intContact = 'Phone 1: ' . $intPh1 . ' Phone 2: ' . $intPh2 . ' Email: ' . $intEmail;
				echo "<td title = '{$intContact}'> {$intName} </td>";
				} else {
					echo "<td> No Claims </td>";
				}
				
			break;
			case "interpreter_confirmed":
				if($v != 0){ // nobody
					$sq2 = "SELECT name_f, name_l, phone_1, phone_2, email FROM users WHERE id = '{$v}'";
					$go2 = mysql_query($sq2)or die (mysql_error());
					$r2 = mysql_fetch_assoc($go2);
					$intF = $r2['name_f'];
					$intL = $r2['name_l'];
					$intPh1 = $r2['phone_1'];
					$intPh2 = $r2['phone_2'];
					$intEmail = $r2['email'];
					$intName = $intF . ' ' . $intL;
					$intContact = 'Phone 1: ' . $intPh1 . ' Phone 2: ' . $intPh2 . ' Email: ' . $intEmail;
				echo "<td title = '{$intContact}'> {$intName} </td>";
				
				} else {
					echo "<td> Not Confirmed </td>";
				}
			break;
			
			case "requested_by":
				echo "<td> {$v} </td>";
			break;
			
			case "date_requested":
				$Rdate = date("m/d/y h:i A",$v);
				echo "<td> {$Rdate} </td>";
			break;
			
			case "status":
				$sq2 = "SELECT title, description FROM appointment_status WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$statT = $r2['title'];
				$statD = $r2['description'];
				echo "<td title = '{$statT} -- {$statD}'> {$statT} </td>";
			break;
			
			case "confirmed_by":
				if($v != 0){ // nobody
					$sq2 = "SELECT name_f, name_l, phone_1, phone_2, email FROM users WHERE id = '{$v}'";
					$go2 = mysql_query($sq2)or die (mysql_error());
					$r2 = mysql_fetch_assoc($go2);
					$intF = $r2['name_f'];
					$intL = $r2['name_l'];
					$intPh1 = $r2['phone_1'];
					$intPh2 = $r2['phone_2'];
					$intEmail = $r2['email'];
					$intName = $intF . ' ' . $intL;
					$intContact = 'Phone 1: ' . $intPh1 . ' Phone 2: ' . $intPh2 . ' Email: ' . $intEmail;
				echo "<td title = '{$intContact}'> {$intName} </td>";
				
				} else {
					echo "<td> Not Confirmed </td>";
				}
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




