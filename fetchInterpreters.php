<?php
	$SECURE = TRUE;
	require("inc/init.php");
	if(isset($_POST["query"])) {
		$search = $_POST["query"];
		$query = "SELECT id,role,facility,name_f,name_l,phone_1,phone_2,email,addr_1,addr_city,addr_state,addr_zip,uname FROM users WHERE
			(id LIKE '".$search."'
			OR name_f LIKE '".$search."%'
			OR name_l LIKE '".$search."'
			OR phone_1 LIKE '".$search."'
			OR phone_2 LIKE '".$search."'
			OR email LIKE '".$search."'
			OR addr_1 LIKE '".$search."'
			OR addr_city LIKE '".$search."'
			OR addr_state LIKE '".$search."'
			OR addr_zip LIKE '".$search."'
			OR uname LIKE '".$search."%')
			AND role = 5";
		$go = mysql_query($query)or die(mysql_error());
		echo "<table class='table InterperterRecordsData main-table' border = '1'>";
		echo "<thead><tr>";
			if($uInfo['role'] == 1 || $uInfo['role'] == 2){
				echo "<th> EDIT </th>";
			}
			echo "<th> ID </th>";
			echo "<th> Role </th>";
			//echo "<th> Facility </th>";
			echo "<th> First Name </th>";
			echo "<th> Last Name </th>";
			echo "<th> Phone 1 </th>";
			echo "<th> Phone 2 </th>";
			echo "<th> Email </th>";
			echo "<th> Address </th>";
			echo "<th> City </th>";
			echo "<th> State </th>";
			echo "<th> Zip </th>";
			echo "<th> User Name </th>";
			echo "<th> Gender </th>";
			echo "<th> Roster Number </th>";
			echo "<th> Roster Expiration </th>";
			echo "<th> Languages</th>";
		echo "</tr></thead>";
		echo "<tbody>";
			while ($row = mysql_fetch_assoc($go)) {
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

				if($rosEXP != 'URGENT') {
					if($rosEXP == 'YES'){
						echo "<tr style = 'background-color:#FF0000;'>";
					} elseif($rosEXP == 'URGENT') {
						//echo "<tr style = 'background-color:#000000;color:#FFFFFF;font-weight:bold;'>";
					} else {	
						echo "<tr>";
					}
					if($uInfo['role'] == 1 || $uInfo['role'] == 2){
						echo "<td> <a class = 'editButton' href = 'editInterpreter.php?u={$aptId}'> Edit </a> </td>";
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
							break;
							
							case "facility":
							break;
							
							case 'addr_2':
							break;
						
						}
					}
					if ($intGender && $intData['roster_number']) {
						echo "<td> {$intGender} </td>";
					}else { echo "<td> &nbsp; </td>"; }
					if ($intData['roster_number']) {
						echo "<td> {$intData['roster_number']} </td>";
					}else { echo "<td> &nbsp; </td>"; }
					if($rosEXP == 'URGENT'){
						echo "<td class = 'urgent'> EXPIRED <br> {$intData['roster_expiration']} </td>";
					} else {
						if ($intData['roster_expiration'] && $intData['roster_number']) {
							echo "<td> {$intData['roster_expiration']} </td>";
						}else{echo "<td> &nbsp; </td>";}
					}
					if ($intLangs && $intData['roster_number']) {
						echo "<td> {$intLangs} </td>";
					}else{echo "<td> &nbsp; </td>";}	
					echo "</tr>";
				} else{}
		} 
		echo "</tbody>";
		echo "</table>";
	}
	else {
		$query = "SELECT id,role,facility,name_f,name_l,phone_1,phone_2,email,addr_1,addr_city,addr_state,addr_zip,uname FROM users WHERE role = 5";
		$go = mysql_query($query)or die(mysql_error());
		echo "<table class='table InterperterRecordsData main-table' border = '1'>";
		echo "<thead><tr>";
			if($uInfo['role'] == 1 || $uInfo['role'] == 2){
				echo "<th> EDIT </th>";
			}
			echo "<th> ID </th>";
			echo "<th> Role </th>";
			echo "<th> First Name </th>";
			echo "<th> Last Name </th>";
			echo "<th> Phone 1 </th>";
			echo "<th> Phone 2 </th>";
			echo "<th> Email </th>";
			echo "<th> Address </th>";
			echo "<th> City </th>";
			echo "<th> State </th>";
			echo "<th> Zip </th>";
			echo "<th> User Name </th>";
			echo "<th> Gender </th>";
			echo "<th> Roster Number </th>";
			echo "<th> Roster Expiration </th>";
			echo "<th> Languages</th>";
		echo "</tr></thead>";
		echo "<tbody>";
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
				if($rosEXP == 'YES') {
					echo "<tr style = 'background-color:#FF0000;'>";
				}
				elseif ($rosEXP == 'NO') {	
					echo "<tr>";
				}
				if($uInfo['role'] == 1 || $uInfo['role'] == 2){
					if($rosEXP != 'URGENT'):
						echo "<td> <a class = 'editButton' href = 'editInterpreter.php?u={$aptId}'> Edit </a> </td>";
					endif;
				}
				foreach($row as $k=>$v){
					switch($k){
						default:
							if($rosEXP != 'URGENT'):
								echo "<td> {$v} </td>";
							endif;
						break;
						
						case "role":
							$sq2 = "SELECT title FROM roles WHERE id = '{$v}'";
							$go2 = mysql_query($sq2) or die(mysql_error());
							$row2 = mysql_fetch_assoc($go2);
							if($rosEXP != 'URGENT'):
								echo "<td> {$row2['title']} </td>";
							endif;
						break; 
						
						case "clinic":
						break;
						
						case "facility":
							/*$sq2 = "SELECT title FROM facilities WHERE id = '{$v}'";
							$go2 = mysql_query($sq2)or die (mysql_error());
							$r2 = mysql_fetch_assoc($go2);
							$clinTitle = $r2['title'];

							if($rosEXP != 'YES' && $rosEXP != 'URGENT'):				
							echo "<td> $clinTitle </td>";
							endif;*/
						break;
						
						case 'addr_2':
						
						break;
					
					}
				}
				if($rosEXP != 'URGENT'):
					if ($intGender && $intData['roster_number']) {
						echo "<td> {$intGender} </td>";
					} else { echo "<td> &nbsp; </td>"; }
					if ($intData['roster_number']) {
						echo "<td> {$intData['roster_number']} </td>";
					} else { echo "<td> &nbsp; </td>"; }
					if ($intData['roster_expiration'] && $intData['roster_number']) {
						echo "<td> {$intData['roster_expiration']} </td>";
					} else { echo "<td> &nbsp; </td>"; }
					if ($intLangs && $intData['roster_number']) {
						echo "<td> {$intLangs} </td>";
					}else{ echo "<td> &nbsp; </td>"; }
				endif;
				if($rosEXP != 'URGENT') {
					echo "</tr>";
				}
			}
		echo "</tbody>";
		echo "</table>";
	}
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.msg-title').hide();
	    $('.InterperterRecordsData').DataTable( {
	        
	    });
	});
</script>