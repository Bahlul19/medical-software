<?php
	$SECURE = TRUE;
	require("inc/init.php");
	// here we make a query...
	$run = TRUE;
	$fFname = $_POST['fName'];
	$fLname = $_POST['lName'];
	$fdob = $_POST['dob'];
	$fins = $_POST['ins'];
	$fFac = $_POST['facility'];
	$patLanguage = $_POST['patLanguage'];
	$fLname = str_replace('+', ' ', $fLname);
	$fdob = str_replace('%2F', '/', $fdob);
	if($uInfo['role'] == 3 || $uInfo['role'] == 4){ // view only your own
		$fFac = $uInfo['facility'];
	}
	$fClin = $_POST['clinic']; 
	//remove leading zeros...
	$unix = strtotime($fdob);
	$v = date('n/j/Y', $unix);
	$query = isset($_POST['query']) ? $_POST['query'] : 'empty';
	if($query == "filterSearch") {
		$sql = "SELECT id,name_f,name_l,mrn,gender,dob,language,prefered_interpreter,addr_1,addr_2,addr_city,addr_state,addr_zip,insurance_provider,insurance_id,phone,second_phone,clinic_id,facility_id,history,notes FROM patients";
		$where = ' WHERE ';
		$count = 0;
			if($uInfo['role'] == 3) {
				$uid = $uInfo['facility'];
				$where .= " facility_id = $uid ";
				$count++;
			}
			if($fFname != ''){
				if($where != ' WHERE '){
					$where .= ' AND ';
				}
				$where .= " name_f LIKE '%{$fFname}%' ";
				$count++;
			}
			if($fLname != ''){
				if($where != ' WHERE '){
					$where .= ' AND ';
				}
				$where .= " name_l LIKE '%{$fLname}%' ";
				$count++;
			}
			if($fdob != ''){
				if($where != ' WHERE '){
					$where .= ' AND ';
				}
				$where .= " dob LIKE '%{$v}%' ";
				$count++;
			}
			// langauge
			if($patLanguage != '' && $patLanguage != 'ANY'){
				if($where != ' WHERE '){
					$where .= ' AND ';
				}
				$where .= " language = '{$patLanguage}' ";
				$count++;
			}
			if($fins != ''){
				if($where != ' WHERE '){
					$where .= ' AND ';
				}
				$where .= " insurance_id LIKE '%{$fins}%' ";
				$count+=2;
			}
			if(($fFac != 'ANY' && $fFac != '') && $uInfo['role'] != 3 && $uInfo['role'] != 4){
				if($where != ' WHERE '){
					$where .= ' AND ';
				}
				$where .= " facility_id = '{$fFac}' ";
			}
			if(($fClin != 'ANY' && $fClin != '') && $uInfo['role'] != 4){
				if($where != ' WHERE '){
					$where .= ' AND ';
				}
				$where .= " clinic_id = '{$fClin}' ";
			}
			//run or not
			if($where != ' WHERE ' )
			{ // if where exists and ther are 2 params
				$sql .= $where;
				
				//$run = TRUE;
			}
			$sql .= " ORDER BY name_l, id ASC";
			//$sql .= " ORDER BY name_l ASC";
		if($run) {
			$go = mysql_query($sql)or die(mysql_error());
			//echo "</tr>";
			while ($row = mysql_fetch_assoc($go)){
				$patID = $row['id'];
				$patFname = $row['name_f'];
				$patLname = $row['name_l'];
				$pdob = $row['dob'];
				$aptId = $row['id'];
				echo "<tr>";
					echo "<td>";
					//1 Test Patient 1/1/1914 German
					if($uInfo['role']==4){
						echo "<a class = 'editButton' href = 'viewPatient.php?p={$patID}'>";
						echo "View";
						echo "</a>";
					} else {
						echo "<a class = 'editButton' href = 'editPatient.php?p={$patID}'>";
						echo "Edit";
						echo "</a>";
					}	
					echo "</td>";
					foreach($row as $k=>$v){
						switch($k){
							default:
							echo "<td> {$v} </td>";
							break;
						
							case "language":
								$sq2 = "SELECT language FROM languages WHERE id = '{$v}'";
								$go2 = mysql_query($sq2) or die(mysql_error());
								$row = mysql_fetch_assoc($go2);
								$patLang = $row['language'];
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
								$sq2 = "SELECT title FROM facilityredo WHERE id = '{$v}'";
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

							case 'history':
							if($v != ''){
								echo "<td><a href = '{$htmlRoot}/viewHistory.php?tp={$patID}'> View History </a></td>";
							} else {
								//echo "<td> &nbsp; </td>";
								echo "<td> NONE </td>";
							}
						    break;

						    case "notes";
								echo "<td> {$v} </td>";
							break;
						}
					}
				// new appointment system
				echo "</tr>";
			}
		}
	}
	else {
		if($loadPat == '' || $loadPat == 0) {
			if($uInfo['role'] == 3) {
				$uid = $uInfo['facility'];
				$sql = "SELECT id,name_f,name_l,mrn,gender,dob,language,prefered_interpreter,addr_1,addr_2,addr_city,addr_state,addr_zip,insurance_provider,insurance_id,phone,second_phone,clinic_id,facility_id,history,notes FROM patients WHERE facility_id = $uid ORDER BY name_l, id ASC  LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
			} else{
				$sql = "SELECT id,name_f,name_l,mrn,gender,dob,language,prefered_interpreter,addr_1,addr_2,addr_city,addr_state,addr_zip,insurance_provider,insurance_id,phone,second_phone,clinic_id,facility_id,history,notes FROM patients ORDER BY name_l, id ASC  LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
			}
		} else {
			if($uInfo['role'] == 3) {
				$uid = $uInfo['facility'];
				$sql = "SELECT id,name_f,name_l,mrn,gender,dob,language,prefered_interpreter,addr_1,addr_2,addr_city,addr_state,addr_zip,insurance_provider,insurance_id,phone,second_phone,clinic_id,facility_id,history,notes FROM patients WHERE id = '{$loadPat}' and facility_id = $uid";
			} else{
				$sql = "SELECT id,name_f,name_l,mrn,gender,dob,language,prefered_interpreter,addr_1,addr_2,addr_city,addr_state,addr_zip,insurance_provider,insurance_id,phone,second_phone,clinic_id,facility_id,history,notes FROM patients WHERE id = '{$loadPat}'";
			}
		}
		if($run){
			$go = mysql_query($sql)or die(mysql_error());
			while ($row = mysql_fetch_assoc($go)){
				$patID = $row['id'];
				$patFname = $row['name_f'];
				$patLname = $row['name_l'];
				$pdob = $row['dob'];
				$aptId = $row['id'];
				echo "<tr>";
					echo "<td>";
						//1 Test Patient 1/1/1914 German
						if($uInfo['role']==4){
							echo "<a class = 'editButton' href = 'viewPatient.php?p={$patID}'>";
							echo "View";
							echo "</a>";
						} else {
							echo "<a class = 'editButton' href = 'editPatient.php?p={$patID}'>";
							echo "Edit";
							echo "</a>";
						}
					echo "</td>";
					foreach($row as $k=>$v) {
						switch($k){
							default:
							echo "<td> {$v} </td>";
							break;

							case "language":
								$sq2 = "SELECT language FROM languages WHERE id = '{$v}'";
								$go2 = mysql_query($sq2) or die(mysql_error());
								$row = mysql_fetch_assoc($go2);
								$patLang = $row['language'];
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
								$sq2 = "SELECT title FROM facilityredo WHERE id = '{$v}'";
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
							case 'history':
								if($v != ''){
									echo "<td><a href = '{$htmlRoot}/viewHistory.php?tp={$patID}'> View History </a></td>";
								} else {
									//echo "<td> &nbsp; </td>";
									echo "<td> NONE </td>";
								}
						    break;

						    case "notes";
								echo "<td> {$v} </td>";
							break;
						}
					}
				// new appointment system
				echo "</tr>";
			}
		}
 	}
?>

