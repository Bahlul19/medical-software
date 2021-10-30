<?php
// functions.php
// Nik Rubenstein -- 1--26-2014
// functions

//////////////////////
//database functions//
//////////////////////

function newLanguage($language){
	$sql = "INSERT INTO languages (language) VALUES ('$language')";
//	echo "<hr> $sql <hr>";
	$go = mysql_query($sql)or die (mysql_error());
	$ret = mysql_insert_id();
	return $ret;
}




function newDepartment($str){
	$sql = "INSERT INTO departments (title) VALUES ('{$str}')";
	$insert = mysql_query($sql) or die(mysql_error());
	$ret = mysql_insert_id();
	return $ret;

}


function updateHistory($patient,$newAppt){
	$sql = "SELECT history FROM patients WHERE id = '{$patient}'";
	$do = mysql_query($sql);
	$row = mysql_fetch_assoc($do);
	$hist = $row['history'];
	$hist = $hist . ',' . $newAppt;
	$sql = "UPDATE patients SET history = '{$hist}' WHERE id = '{$patient}'";
	$upd = mysql_query($sql);

}

function getTables(){
	$ret = array();
	$sql = "SHOW TABLES";// FROM itasca11_portal";
	$go = mysql_query($sql)or die(mysql_error());
	while($row = mysql_fetch_array($go)){
	array_push($ret,$row[0]);
	}
	return $ret;
}

function getFields($table){
	$ar = array();
	//$sql = "SELECT * FROM $table LIMIT 1";
	$sql = "SHOW COLUMNS FROM $table";
	$go = mysql_query($sql);
	//$row = mysql_fetch_array($go);
	while($row = mysql_fetch_array($go)){
	array_push($ar,$row[0]);

	}
	return $ar;
}

function getFullFields($table,$info='0,1,8'){
	$ar = array();
	$info = explode(',',$info);
	$sql = "SHOW FULL COLUMNS FROM $table";
	$go = mysql_query($sql);
	while($row = mysql_fetch_row($go)){
		$newRow = array();
		foreach($info as $key=>$val){
			array_push($newRow,$row[$val]);
		}
		
		//print_r($newRow);hr();
		
		array_push($ar,$newRow);
	}
	return $ar;

}


function insertOne($table,$col,$data){
	$sql = "INSERT INTO $table ($col) VALUES ('$data')";
	$go = mysql_query($sql);
	$ret = mysql_insert_id();
	return $ret;
}

function insertMany($table,$array){
$keys = array();
	$values = array();
	foreach($array as $k => $v){
		array_push($keys,$k);
		array_push($values,"'{$v}'");
		
		
	}
	$keys = implode(',',$keys);
	$values = implode(',',$values);
	$sql = "INSERT INTO {$table} ($keys) VALUES ($values)";
//	echo $sql;
//	echo "<hr>";
	$go = mysql_query($sql)or die(mysql_error());
	$ret = mysql_insert_id();
	return $ret;
}


function updateTable($table,$col,$id,$array){
	// update a table with an array of key value pairs
	foreach($array as $key => $value){
		$sql = "UPDATE {$table} SET {$key} = '{$value}' WHERE {$col} = '{$id}'";
	//	echo "{$sql} <hr>";
		$go = mysql_query($sql)or die(mysql_error());
	}

}

function tableReport($id){
	$x = runReport($id);
	$ar = $x['fields'];
	$data = $x['data'];
	makeTable($data,$ar);
}
// report runner


function dataGet($fieldsArray,$table,$where,$clause){
	// fieldsArray can be an array of fields or "*" 
	if($fieldsArray == '*'){
		$fields = $fieldsArray;
	} else {
		$fields = implode(',',$fieldsArray);

	}
	
	$sql = "SELECT {$fields} FROM $table ";
	if($where){
		$sql .= "WHERE {$where} = '{$clause}'";
	}
	
//	echo $sql;hr();
	$i = 0;
	$go = mysql_query($sql)or die(mysql_error());
	while($row = mysql_fetch_assoc($go)){
		//array_push($ret,$row);
		$ret[$i] = $row;
		$i++;
		
	}
	return $ret;
}

//replace a column of data with data from another table
// primarily for converting id numbers to verbal titles.
// usage replaceData([array of arrays],[replace key],[target table],[target column],[where column])
// creates "SELECT [target column] FROM [target table] WHERE [where colum] = '$value'
// and returns new aOFa table with values replaced.

function dataReplace($aOFa,$replace,$table,$col,$where){
		$ret = array();
	foreach($aOFa as $k => $v){
		foreach($v as $key => $value){
			if($key == $replace){
				//echo "REPLACE $value With $table - $col WHERE $where = $value ";
				$sql = "SELECT $col FROM $table WHERE $where = '$value'";
				$go = mysql_query($sql);
				$row = mysql_fetch_assoc($go);
				$new = $row[$col];
				$aOFa[$k][$replace] = $new;
			} 
		}
	}
	return $aOFa;
}



// table maker
// function

function makeTable($aOFa,$headers){
	echo "<table border = '1'>";
	// create headers
	if($headers){ 
		if($headers == 'default'){
			$header = $aOFa[0];
		} else {
			$header = $headers;
		}
		echo "<tr>";
		foreach($header as $k=> $v){
				echo "<th> $k </th>";
		}
		echo "</tr>";
	}
	// echo the data
	foreach($aOFa as $k => $v){
		echo "<tr>";
		foreach($v as $key => $value){
			if($key == $_GET['hi'] && $value == $_GET['hiVal']){
				echo "<td class = 'highlight'> $value </td>";
			} else {
				echo "<td>$value </td>";
			}
		}
		echo "</tr>";
	}
	echo "</table>";
}

function kvReverse($array){
	$result = array();
	foreach($array as $k => $v){
		$result[$v] = $k;
	}
	return $result;
}

//////////////////
//form functions//
//////////////////

// make a new form
function formForm($action,$method,$param){
	echo "<form action = '$action' method = '$method' $param>";
}

// close a form
function formClose(){
	echo "</form>";
}

//label
function formLabel($for,$value,$req = false){
	echo "<label id ='labl{$for}' for {$for}> {$value} </label>";
	if ($req){
		echo "<span style = 'color:#FF0000;'> * </span>";
	}
}
//create an input
function formInput($name,$type,$value,$param){
	echo "<input name = '$name' type = '$type' value = '$value' $param>";
}


//create an input
function formTextArea($name,$rows,$value,$height,$id,$class){
	echo "<textarea name = '$name' rows='$rows' cols='$height' $id  $class >$value</textarea> ";
}



//dropdown with a comma separated list, of colon separated key=>value pairs OR
// and array of id=>words (key=> value)
// also works with just a comma sep list, in which case key and value are the same
// expamples:
// formSelect('someName','1:one,2:two,3:three');
// formSelect('someName','1,2,3,4,5');
// formSelect('someName',$array([ key => val , key => val])
function formSelect($name,$list,$params){
	echo "<select name = '{$name}' $params>";
	
	if (is_array($list)){
		foreach($list as $val => $words){
			echo "<option value = '{$val}'> {$words} </option>";
		}
	} else {
		$chunks = explode(',',$list);
		//print_r($chunks);
		foreach($chunks as $k => $v){
			$parts = explode(':',$v);
			$val = $parts[0];
			$words = $parts[1];
			if($words == ''){
				$words = $val;
			}
			echo "<option value = '{$val}'> {$words} </option>";
		//echo "{$val} -- {$words} <br>";
		}
	}
	echo "</select>";
}
// Make a dropdown menu from info in db.
function formDropdown($name,$table,$fieldV,$fieldW,$defaultValue = 'spec',$default = 'Please Specify', $other = 'other',$params){
	$sql = "SELECT $fieldV,$fieldW FROM $table ORDER BY $fieldW ASC";
//	echo $sql;
	echo "<select name = '$name' $params>";
	echo "<option value = '{$defaultValue}'> $default </option>";
	$go = mysql_query($sql) or die (mysql_error());
	while ($row = mysql_fetch_assoc($go)){
	//	print_r($row);
	//	echo "<hr>";
		$words = $row[$fieldW];
		$val = $row[$fieldV];
		
		echo "<option value = '$val'> $words </option>"; 
	}
	echo "<option value = 'other'> $other </option>";
	echo "</select>";
}


//////////////////
//html shortcuts//
//////////////////

function br(){
	echo "<br>";
}
function hr(){
	echo "<hr>";
}


function clearfix(){
	echo "<div class = 'clearfix'></div>";
}



/// report running mania
function runReport($id){
	$ret = array();
	$sql = "SELECT * FROM reports WHERE id = '{$id}'";
	$go = mysql_query($sql)or die(mysql_error());
	$row = mysql_fetch_assoc($go);

	$id = $row['id'];
	////////////////////////
	//title of report
	////////////////////////
	$title = $row['title'];
	
	////////////////////////
	//permissions
	////////////////////////
	$perms = $row['perms'];
	////////////////////////
	//primary table
	////////////////////////
	$table = $row['tbl'];
	////////////////////////
	// fields to show
	////////////////////////
	$fields = $row['fields'];
	$selectFields = array();
	$selectNames = array();
	$fArray = explode(",",$fields);
	foreach($fArray as $k => $v){
		$ch = explode ('=',$v);
		$name = $ch[0];
		$field = $ch[1];
		array_push($selectFields,$field); // we have the fields to select from primary table
		array_push($selectNames,$name); // we have what they will be called in the report
	}
	////////////////////////
	// filter
	////////////////////////
	$filter = $row['filter'];
	$test = str_replace(" ","",$filter); // is there a filter?
	if($test == ''){
		$test = FALSE;
	} else {
		$test = TRUE;
	}
	$filter = str_replace("EQ","=",$filter);
	$filter = str_replace("GT",">",$filter);
	$filter = str_replace("LT","<",$filter);
	$filter = str_replace("DT","!=",$filter);
	$filter = str_replace("*","%",$filter);
	
	//temporary measure
	$filter = str_replace("{REPLACE}","1",$filter);
	


	////////////////////////
	// REPLACEMENTS
	///////////////////////
	$replace = $row['rep'];
	//echo "$replace";hr();hr();
	
	
	$rp = explode('][',$replace); 
	$replacementFields = array();
	$repAofA = array(); // getting closer.
	foreach($rp as $k => $v){
		$subArray = array();
		$v = str_replace('[','',$v); //strip off the remaining brackets 
		$v = str_replace(']','',$v); ///////////////////////////////////
		$ch = explode('=',$v);
		$field2replace = $ch[0]; // this is the field we will replace
		$data = $ch[1]; // this is the rest of the data about the replacement
		$repAofA[$field2replace] = '1'; // inoculate the array to get a place holder
		$ch = explode('-',$data);
		$replacementTable = $ch[0];
		array_push($subArray,$replacementTable); // subArray 0 => $replacementTable
		
		
		$subFields = $ch[1]; // these are the individual replacement fields
		$ch = explode(')(',$subFields);
		foreach($ch as $kk=>$vv){
			$vv = str_replace('(','',$vv); // strip off the remaining parenths
			$vv = str_replace(')','',$vv); ///////////////////////////////////
			//echo $replacementTable . ' -- ' . $kk . '--> ' . $vv;hr();
			array_push($subArray,$vv);
		}
		$repAofA[$field2replace] = $subArray; // inoculate the array to get a place holder
		
	}
	//print_r($repAofA);
	
	// Now we have an array called $repAofA which has keys named after the field that will be replaced
	// The value of eachindex is an array with index[0] as the name of the TABLE to draw replacements from
	// followed by 1 or more field, named field pairs separted by comma.
	
	
	
	// Lets try to make a query!!
	
	
	// first we get the field names.
	
	$fieldString = implode(',',$selectFields);
	
	$sql = "SELECT {$fieldString} FROM $table ";
	if($test){ //if there is a where clause
		$sql .= "WHERE {$filter}";
	}
	
//	echo "$sql";hr();hr();
	
	$go = mysql_query($sql) or die (mysql_error());
	$finalArray = array();
	
	
	
	
	
	while ($row = mysql_fetch_assoc($go)){
		$resultsArray = array();
	//	print_r($row);hr();
		
		
		
		
		
		foreach($row as $k=>$v){
	//		echo "key = $k : val = $v <br>";
			$chex = $repAofA[$k];
			if($chex != ''){ // if there is replaqcementy info for this field
				$sub = $repAofA[$k];
				

				$subZero = $sub[0]; // ninja table replacement master.
				unset($sub[0]); // remove ninja. FINISH HIM!!!!
				$subFields = array();
				
				foreach($sub as $kk => $vv){
					$ch = explode(',',$vv);
					$FF = $ch[0];
					$NN = $ch[1];
					$subFields[$NN] = $FF;
				}
				$subFieldStr = implode(',',$subFields);
				
				
				
				$subSql = "SELECT $subFieldStr FROM $subZero WHERE id = '{$v}'";
				//br();br();echo $subSql;br();br();
				$go2 = mysql_query($subSql) or die(mysql_error());
				$row2 = mysql_fetch_assoc($go2);
				

				
				
				foreach($row2 as $kkk => $vvv){
					$resultsArray[$kkk] = $vvv;
				}
				//function array_insert($array,$values,$offset) {
			//	$newRow = array_insert($row,$row2,1);
				
				
			} else {
				$resultsArray[$k] = $v;
			
			}
			
			
		}
		array_push($finalArray,$resultsArray);
		
	}


	return $finalArray;
}


function getUinfo($uid){
// clinic
// function dataGet($fieldsArray,$table,$where,$clause){
	$u = dataGet("*",'users','id',$uid);
	$u = $u[0];
	$_SESSION['uInfo'] = $u;
	$uInfo = $u;
	$sql = "SELECT * FROM clinics WHERE id = '{$uInfo['clinic']}'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	$uInfo['clinic_title'] = $row['title'];

	$_SESSION['activeClinic'] = $uInfo['clinic'];
	$role = $uInfo['role'];

	//facility
	$sql = "SELECT * FROM facilities WHERE id = '{$uInfo['facility']}'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	$uInfo['facility_title'] = $row['title'];
	return $u;
}


function getIntsByLanguage($lang,$x,$notExp = 'FALSE'){
	// $notExp will filter out expired inetrpreters when set to TRUE, default is FALSE
	$intsSpeak = array();
	$targetLanguage = $lang;
	$qry = "SELECT roster_expiration, id FROM interpreters WHERE language_1 = '{$targetLanguage}' OR language_2 = '{$targetLanguage}' OR language_3 = '{$targetLanguage}' OR language_4 = '{$targetLanguage}'"; // join to users table? get names.
	$go2 = mysql_query($qry)or die(mysql_error());
	while ($row2 = mysql_fetch_assoc($go2)){
		$expire = $row2['roster_expiration'];
		$expUnix = strtotime($expire);
		$tdUnix = date("U");
		$ints = $row2['id'];
		if($notExp == 'TRUE'){
			if($expUnix > $tdUnix){
				array_push($intsSpeak,$ints);
			}
		} else {
			array_push($intsSpeak,$ints);
		}
	}
	$ddString = array();
	$intArray = array();
	array_push($ddString,'0:none');
	foreach($intsSpeak as $kk => $vv){
		$sq3 = "SELECT id, name_f, name_l FROM users WHERE id = '{$vv}'";
		$g3 = mysql_query($sq3);
		$r3 = mysql_fetch_assoc($g3);
		$tID = $r3['id'];
		$tNAME = $r3['name_f'] . " " . $r3['name_l'];
		$newStr = "{$r3['id']}:{$r3['name_f']} {$r3['name_l']}";
		array_push($ddString,$newStr);
		$intArray[$tID] = $tNAME;
	}
	if ($x != 'byID'){
		return $ddString;// = implode(',',$ddString);
	} else {
		return $intArray;
	}
}
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
function getLanguagesByInt($uid){
	$sql = "SELECT language_1,language_2,language_3,language_4 FROM interpreters WHERE id = '{$uid}'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	return $row;
}

function getPatientsByLanguage($language){
	$patients = array();
	$sql = "SELECT id FROM patients WHERE language = '{$language}'";
	$go = mysql_query($sql);
	while($row = mysql_fetch_assoc($go)){
		array_push($patients,$row['id']);
	}
	return $patients;
}

function doubleBook($user,$field,$start,$dur,$thresh){
// for a given user, 
	// take unixtime duration and threshhold in minutes and return true (maybe overlap) if true and false if false
	$threshSec = $thresh * 60; // thresh in seconds
	$durSec = $dur * 60; // duration in seconds
	$bStart = $start - $threshSec; // blocked time start
	$bEnd = $start + $durSec + $threshSec; // blocked time end 
	$sql = "SELECT id, apt_date FROM appointment_requests WHERE {$field} = '{$user}' ";
	$sql .= " AND apt_date > '{$bStart}' AND apt_date < '{$bEnd}' ";
	$sql .= "AND status NOT IN ('4','5','6') ";
	$go = mysql_query($sql)or die(mysql_error());
	$rows = mysql_num_rows($go);
	if($rows > 0){
		$row = mysql_fetch_assoc($go);
		$aId = $row['id'];
		$aTime = $row['apt_date'];
		$ret = array();
		$ret[$aId]=$aTime;
		return $ret;
	} else {
		return 'OKAY';
	}
	
}

require_once $phpRoot . '/twilio/lib/Services/Twilio.php';

function sendSms($messageBody, $toNumber) {
	$twilio = new Services_Twilio('ACd9700d88d99f3606283e85ca97b4b03c', '62a9eedd83ee6e06488efbca7fcedf50');
	$message = $twilio->account->messages->sendMessage(
	    '+12055256985',
	    $toNumber,
		$messageBody
	);
	return $message;
}