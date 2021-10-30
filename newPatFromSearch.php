<div class = 'aptForm'>
<?php
	formForm("{$htmlRoot}/proc/newPatient.php?ret=search",'post','onsubmit="return validateForm();"');
	
	
	
	// clinic if adfmin
	if($uInfo['role'] == 1 || $uInfo['role'] == 2){ // if they are admin or Itasca staff
		// make a dropdown of clinics
		formLabel('clinic','For Facility',true);
		echo "<oneDrop>";
		formDropdown('facility_id','facilities','id','title','spec','Choose A Facility','','onChange="facSwitch(this.value,\'Default Clinic\');"');
		//formDropdown('clinic_id','facilities','id','title','spec','Choose A Facility','','onChange="facSwitch(this.value,\'Default Clinic\');"');
		echo "</oneDrop>";
		clearfix();
		echo "<div id = 'myBox'></div>";
	} else {
	//	clearfix();
		formLabel('facility_id','Facility',true);
		echo "<input type = 'text' name = 'facility_id' value = '{$uInfo['facility']}' readonly = 'true'>"; // can only do their own clinic
		clearfix();
		if($uInfo['role'] == '3'){ // can only do theior own fac
			$sql = "SELECT * FROM clinics WHERE clinic_id = '{$uInfo['facility']}'";
			$go = mysql_query($sql);
			formLabel('clinic',"Clinic");
			echo "<oneDrop>";
			echo "<select name = 'clinic_id'>";
			while($row = mysql_fetch_assoc($go)){
				$thisFac = $row['title'];
				$thisID = $row['id'];
				echo "<option value = '{$thisID}'> {$thisFac} </option>";
			}
			echo "</select>";
			echo "</oneDrop>";
			clearfix();
		} elseif($uInfo['role'] == 4) { // staff auto fill
			//echo "<input type = 'hidden' name = 'facility_id' value = '{$uInfo['facility']}'>";
		}
	
	}
	
	clearfix();
	hr();
	
	//Name
	formLabel('name_f','First Name',true);
	formInput('name_f','text','','id = "name_f"');
	clearfix();
	formLabel('name_l','Last Name',true);
	formInput('name_l','text','','id = "name_l"');
	clearfix();
	
	//MRN
	formLabel('mrn','MRN');
	formInput('mrn','text','');
	clearfix();
	//gender
	formLabel('gender','Gender',true);
	echo "<oneDrop>";
	$MF = array(
		'N' => 'Please Select',
		'M' => 'Male',
		'F' => 'Female'
	);
	formSelect('gender',$MF,'id = "gender"');
	
	echo "</oneDrop>";
	clearfix();
	//language
	// function formDropdown($name,$table,$fieldV,$fieldW,$default = 'Please Specify', $other = 'other', $params){
	formLabel('langauge','Language',true);
	echo "<oneDrop>";
	formDropdown('language','languages','id','language','Please Specify A Langauge','Please Specify A Langauge','Patient Language Is Not Listed',' onChange="specLangauge();" id = "inputLangauge" ');

	echo "</oneDrop>";
	clearfix();
	
	// specify unlisted langauge (ajaxed in)
	echo "<span id = 'newLangauge'></span>";
	clearfix();
	
	// Prefered Interp
	formLabel('prefered_interpreter','Preferred Interpreter');
	formInput('prefered_interpreter','text','');
	clearfix();
	
	
	// DOB info
	formLabel('dob','Date Of Birth',true);
	echo "<triselect>";
	formSelect ('dobM','1:January,2:February,3:March,4:April,5:May,6:June,7:July,8:August,9:September,10:October,11:November,12:December');
	formSelect('dobD','1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31');
	$yrs = '1900';
	$thisYear = date("Y");
	$thisYear++;
	//not typing over 100 years... for 1900 to 2014
	for($x=1901;$x<$thisYear;$x++){
		$yrs .= ",{$x}";
	}
	formSelect('dobY',"$yrs");
	echo "</triselect>";
	clearfix();
	
	// address
	formLabel('addr_1','Address 1',true);
	formInput('addr_1','text','','id = "addr_1"');
	clearfix();
	formLabel('addr_2','Address 2');
	formInput('addr_2','text','');
	clearfix();
	formLabel('addr_city','City',true);
	formInput('addr_city','text','','id = "addr_city"');
	clearfix();
	formLabel('addr_state','State');
	//formInput('addr_state','text','');
	echo "<oneDrop>";
	echo "<select name = 'addr_state'>";
	require("{$legos}/stateDrop.php");
	echo "</select>";
	echo "</oneDrop>";
	clearfix();
	formLabel('addr_zip','Zip Code',true);
	formInput('addr_zip','text','','id = "addr_zip"');
	clearfix();
	
	//insurance
	formLabel('phone','Telephone',true);
	// $("#phone").mask("(999) 999-9999");
	formInput('phone','text','','id = "phone"');
	clearfix();
	
	// phone numbers
	formLabel('ins_provider', 'Insurance Provider');
	echo "<oneDrop>";
	formDropdown('insurance_provider','insurance_providers','id','title','spec','Please Specify','other');
	echo "</oneDrop>";
	clearfix();
	formLabel('insurance_id','Insurance ID');
	formInput('insurance_id','text','');
	clearfix();
	
	
	
	
	
	
	//submit
	formLabel('blank','');
	formInput('submit','submit','Submit');
	//time
	
	clearfix();
	formClose();
?>
</div>




