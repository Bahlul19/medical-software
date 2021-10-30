<?php
error_reporting(E_ALL);
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
$timeNow = date("U");

//$apt = $_GET['a'];
//$apt = $_POST['aptID'];
?>
<!doctype HTML>
<html>
<head>
<style>

.hideMe{
	display:none;
}
</style>

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


	<div class = 'tableDisplay'>
		<div class = 'formTitle'>
		Available Appointments
		</div>
<?php

echo "<div class = 'hideMe' id = 'userId'>{$uInfo['id']}</div>";
echo "<div id = 'appointmentTable'>";
echo "<div class = 'subTitle'> {$uInfo['name_f']}, You have been requested as the interpreter for these appointments </div>";
echo "<div class = 'mine'>";
echo "<center>";
//$where = " WHERE interpreter_req = '{$uInfo['id']}' AND interpreter_confirmed = '0' AND interpreter_claim NOT LIKE '%{$uInfo['id']}%'";
$where = " WHERE interpreter_req = '{$uInfo['id']}' AND interpreter_confirmed = '0' AND interpreter_claim NOT LIKE '%{$uInfo['id']}%' AND (status = '1' OR status = '2')";
$Afields = 'id,status,apt_date,duration,clinic,patient';
$sql = "SELECT $Afields FROM appointment_requests"; // this is the big mod

if($where != ' WHERE '){
	$sql .= $where;
}

//echo "$sql <br>";

$go = mysql_query($sql)or die(mysql_error());
//print_r($uInfo);
//hr();
echo "<table border = '1'>";
echo "<tr>";
//	echo "<td> Edit </td>";
//	echo "<th> ID </td>";
	echo "<th> Status </th>";
	echo "<th> Appointment Date </th>";
	echo "<th> Appointment Time </th>";
	echo "<th> Duration </th>";
	echo "<th> Clinic </th>";
	echo "<th> Language </th>";
	echo "<th> Patient First Name </th>";
	echo "<th> Patient Last Name</th>";
	echo "<th> Request This Appointment</th>";
	echo "<th> Replace This Appointment</th>";
echo "</tr>";

while ($row = mysql_fetch_assoc($go)){
	$aptId = $row['id'];
	// var_dump($aptId);
echo "<tr>";
	foreach($row as $k=>$v){
		switch($k){
			default:
		//	echo "<td> {$v} </td>";
			break;
			
			//patient data swap
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
				echo "<td> {$pLang} </td>";
				echo "<td> {$pfn} </td>";
				echo "<td> {$pln} </td>";
			//	echo "<td> {$pdob} </td>";
				
			break;
			
			case "apt_date":
				$Adate = date("m/d/y",$v);
				$Atime = date("h:i A",$v);
				echo "<td> $Adate </td>";
				echo "<td> $Atime </td>";
			break;
			
			case "duration":
				echo "<td> {$v} </td>";
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
				
				echo "<td title = '{$facTitle} - Address:{$facAdr} - Phone: {$facPhone}'> $facTitle </td>";
			break;
			
		
			
			
			case "status":
				$sq2 = "SELECT title, description FROM appointment_status WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$statT = $r2['title'];
				$statD = $r2['description'];
				echo "<td title = '{$statT} -- {$statD}'> {$statT} </td>";
			break;
			
		
		}
		
	}
	echo "<td  id = 'req_{$row['id']}'> <button value =  '{$row['id']}' onclick = 'request(this.value);'> Confirm </button> </td>";
	

echo "<td  id = 'rep_{$row['id']}'> <button value =  '{$row['id']}' onclick = 'replace(this.value);'> Replace </button> </td>";

}
echo "</table>";
echo "</center>";
echo "</div>";

echo "</div>";
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////   OTHER AVAILABLE APPOINTMETS   /////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

echo "<div id = 'appointmentTable'>";
echo "<div class = 'subTitle'> The following appointments are also available in your language </div>";
echo "<div class = 'other'>";
echo "<center>";

// get list of langs by int
$thisIntsLangs = getLanguagesByInt($uInfo['id']);

foreach($thisIntsLangs as $K => $V){
	if($V == 0 || $V == '0' || !is_numeric($V)){
		$thisIntsLangs[$K] = 'noLang';
	}
}


$il1=$thisIntsLangs['language_1'];
$il2=$thisIntsLangs['language_2'];
$il3=$thisIntsLangs['language_3'];
$il4=$thisIntsLangs['language_4'];

//hr();
//print_r($thisIntsLangs);
//hr();




$Afields = 'id,status,apt_date,duration,clinic,patient,interpreter_claim';
$sql = "SELECT $Afields FROM appointment_requests"; // this is the big mod
$where = " WHERE interpreter_confirmed = '0' AND (interpreter_req = 'ANY' ) "; //OR interpreter_req = '' OR interpreter_req = 'Any') ";
$where .= "AND (interpreter_claim = '' OR interpreter_claim = '{$uInfo['id']}') AND (status = '1' OR status = '2') "; 
$where .= "AND apt_date > '{$timeNow}' "; // only in the future




$where .= " AND language IN ( ";   //'{$il1}', '{$il2}', '{$il3}', '{$il4}') ";
	if($il1 != 'noLang'){
		$whereLangs .= "'{$il1}',";
	}
	if($il2 != 'noLang'){
		$whereLangs .= "'{$il2}',";
	}
	if($il3 != 'noLang'){
		$whereLangs .= "'{$il3}',";
	}
	if($il4 != 'noLang'){
		$whereLangs .= "'{$il4}',";
	}
	$whereLangs = rtrim($whereLangs,',');
	$where .= $whereLangs;
	
$where .= " ) "; // close it
// and language in IntIUnfo lang1-4 filtyer status pending new,
// AND interpreter_claim <> ''

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// LANGUAGE LOGIC ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//$langSpoken = getLanguagesByInt($uInfo['id']); 		
/*													//////////
foreach($langSpoken as $lk => $lv){																		//////////
	if($lv == '0'){																						//////////
		unset($langSpoken[$lk]);																		//////////
	}																									//////////
}																										//////////
// replace patlist with language from appointment table													//////////
$patList = '';																							//////////
$patListPrime = array();																				//////////
foreach($langSpoken as $key => $value){																	//////////
	$thesePats = getPatientsByLanguage($value);															//////////
	foreach($thesePats as $ignore => $thisPat){															//////////
		if($thisPat != ''){																				//////////
			$patList .= "{$thisPat},";																	//////////
		}																								//////////
	} 																									//////////
}																										//////////
$patList = rtrim($patList, ',');																		//////////
$patList = str_replace(',',"','",$patList);																//////////
$patList = "'{$patList}'"; // Wow... got it.															//////////
$where .= " AND patient IN ( $patList ) "; 		
*/
//$thisIntLanguages = implode(',',$langSpoken);
//$where .= "AND language IN ( $thisIntLanguages )";														//////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// STATUS FILTER  ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//$sf = "'1','2'"; 																						//////////
//$where .= " AND status IN ( {$sf} ) "; 																	//////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($where != ' WHERE '){
	$sql .= $where;
}
$sql .= " ORDER BY apt_date ASC ";
//echo "$sql <br>";

//hr();
//echo $sql;
//hr();

$go = mysql_query($sql)or die(mysql_error());


echo "<table border = '1'>";
echo "<tr>";
//	echo "<td> Edit </td>";
	echo "<th> ID </td>";
	echo "<th> Status </th>";
	echo "<th> Appointment Date </th>";
	echo "<th> Appointment Time </th>";
	echo "<th> Duration </th>";
	echo "<th> Clinic </th>";
	echo "<th> Language </th>";
//	echo "<th> Patient First Name </th>";
//	echo "<th> Patient Last Name</th>";
	echo "<th> Request This Appointment</th>";

echo "</tr>";

while ($row = mysql_fetch_assoc($go)){
	$aptId = $row['id'];
echo "<tr>";
//echo "<td> <a class = 'editButton' href = '{$htmlRoot}/appointmentEditor.php?a={$aptId}'> Edit </a> </td>";

	foreach($row as $k=>$v){
		switch($k){
			default:
		//	echo "<td> {$v} </td>";
			break;
			
			//patient data swap
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
				echo "<td> {$pLang} </td>";
			//	echo "<td> {$pfn} </td>";
			//	echo "<td> {$pln} </td>";
			//	echo "<td> {$pdob} </td>";
				
			break;
			
			case "apt_date":
				$Adate = date("m/d/y",$v);
				$Atime = date("h:i A",$v);
				echo "<td> $Adate </td>";
				echo "<td> $Atime </td>";
			break;
			
			case "duration":
				echo "<td> {$v} </td>";
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
				
				echo "<td title = '{$facTitle} - Address:{$facAdr} - Phone: {$facPhone}'> $facTitle </td>";
			break;
			
		
			
			
			case "status":
				$sq2 = "SELECT title, description FROM appointment_status WHERE id = '{$v}'";
				$go2 = mysql_query($sq2)or die (mysql_error());
				$r2 = mysql_fetch_assoc($go2);
				$statT = $r2['title'];
				$statD = $r2['description'];
				echo "<td title = '{$statT} -- {$statD}'> {$statT} </td>";
			break;
			
			case "id":
				echo "<td> $v </td>";
			break;
		
		}
	}
	//// function dataGet($fieldsArray,$table,$where,$clause){
	
	if($row['interpreter_claim'] != $uInfo['id']){
		echo "<td id = 'req_{$row['id']}'> <button  value =  '{$row['id']}' onclick = 'request(this.value);'> Request </button> </td>";
		echo "</tr>";
	} else {
		echo "<td> Requested </td>";
	}

}


echo "</center>";
echo "</div>";
echo "</div>";
?>

	</div> <!-- aptForm -->
</div> <!-- siteWrap -->


<?php
require("scripts.php");
?>
<script>
function request($str){
//	alert($str);
	var $uid = document.getElementById("userId").innerHTML;
	// Jax a request to 
	$getString = "uid="+$uid+"&apt="+$str;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		//	alert("READY "+xmlhttp.readyState+" status "+xmlhttp.status);
			document.getElementById("req_"+$str).innerHTML=xmlhttp.responseText;
			
		} else {
		//	alert("NOT READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		}
	} 
	xmlhttp.open("GET","proc/intClaim.php?"+$getString,true);
	xmlhttp.send();
	
	
}

function replace($str){
//	alert($str);
	var $uid = document.getElementById("userId").innerHTML;
	// Jax a request to 
	$getString = "uid="+$uid+"&apt="+$str;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		//	alert("READY "+xmlhttp.readyState+" status "+xmlhttp.status);
			document.getElementById("rep_"+$str).innerHTML=xmlhttp.responseText;
			
		} else {
		//	alert("NOT READY "+xmlhttp.readyState+" status "+xmlhttp.status);
		}
	} 
	xmlhttp.open("GET","proc/intReplace.php?"+$getString,true);
	xmlhttp.send();
	
	
}
</script>

</body>
</html>
