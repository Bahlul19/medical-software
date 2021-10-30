<?php
$SECURE = TRUE;
require("inc/init.php");
?>
<!doctype HTML>
<html>
<head>
<title> Itasca View Interpreters</title>

 <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
 <script src="js/jquery.tabletoCSV.js" type="text/javascript" charset="utf-8"></script>
  

<?php
require("{$legos}/head.php");
?>
<style type="text/css">
	#DataTables_Table_0_length{

		text-align: right!important;
	}
	.table-scroll {
		position:relative;
		max-width:100%;
		margin:auto;
		overflow: hidden;
	}
	.table-wrap {
		width:100%;
		overflow:auto;
	}
	.table-scroll table {
		width:100%;
		margin:auto;
		border-collapse:separate;
		border-spacing:2;
	}
	.table-scroll tr {
	    color: #000000;
	    text-align: center;
	    font-family: "Times New Roman", Times, serif;
	}
	.table-scroll th {
	    background-color: #99CCff;
	    color: #000000;
	    font-family: "Times New Roman", Times, serif;
	}
	.table-scroll th, .table-scroll td {
		padding:5px 2px;
		border:1px solid #000;
		white-space:nowrap;
		vertical-align:top;
	}
	.table-scroll td {
		text-align: left;
	}
	.table-scroll thead, .table-scroll tfoot {
		background:#f9f9f9;
	}
	.editButton {
	    font-size: .8em;
	    width: 30px;
	    background-color: #CCFFCC;
	    text-decoration: none;
	    display: inline-block;
	    padding: 2px;
	    border: 1px solid #000000;
	    color: #000000;
	}
</style>

<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>

<div class = 'siteWrap' id="siteWrap">


	<div class = 'tableDisplay'>
		<div class = 'formTitle'>
				View Interpreters		

		</div>
<span class="msg-title"><h1>Loading...</h1></span>

<?php

$sql = "SELECT id,role,facility,name_f,name_l,phone_1,phone_2,email,addr_1,addr_city,addr_state,addr_zip,uname FROM users WHERE role = 5";

//$sql = "SELECT id,role,facility FROM users WHERE role = 5";


$go = mysql_query($sql)or die(mysql_error());
echo "<div id='table-scroll' class='table-scroll'>";
echo "<div class = 'table-responsive table-wrap'>";
echo "<table class='table InterperterRecordsData main-table' border = '1'>";
echo "<thead><tr>";
	if($uInfo['role'] == 1 || $uInfo['role'] == 2){
		echo "<th> EDIT </th>";
	}
	//echo "<th> EDIT <th>";
	echo "<th> ID </th>";
	echo "<th> Role </th>";
	echo "<th> Facility </th>";
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
	
echo "</tr></thead>
<tbody>
";

while ($row = mysql_fetch_assoc($go)){
	//echo "<tr>";
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
	
	if($uInfo['role'] == 1 || $uInfo['role'] == 2){

		if($rosEXP != 'YES' && $rosEXP != 'URGENT'):
			echo "<td> <a class = 'editButton' href = 'editUser.php?u={$aptId}'> Edit </a> </td>";
		endif;
	}

	foreach($row as $k=>$v){
		
		switch($k){
			default:

			if($rosEXP != 'YES' && $rosEXP != 'URGENT'):

				echo "<td> {$v} </td>";

			endif;
			break;
			
			case "role":
				$sq2 = "SELECT title FROM roles WHERE id = '{$v}'";
				$go2 = mysql_query($sq2) or die(mysql_error());
				$row2 = mysql_fetch_assoc($go2);

				if($rosEXP != 'YES' && $rosEXP != 'URGENT'):
					echo "<td> {$row2['title']} </td>";
				endif;
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

				if($rosEXP != 'YES' && $rosEXP != 'URGENT'):				
				echo "<td> $clinTitle </td>";
				endif;
			break;
			
			case 'addr_2':
			//
			break;
		
		}
	}
	if($intData['roster_number']){
		if($rosEXP != 'YES' && $rosEXP != 'URGENT'):
		echo "<td> {$intGender} </td>";
		echo "<td> {$intData['roster_number']} </td>";
		endif;
			if($rosEXP == 'URGENT'){
				//echo "<td class = 'urgent'> EXPIRED <br> {$intData['roster_expiration']} </td>";
			} else {
				if($rosEXP != 'YES' && $rosEXP != 'URGENT'):
					echo "<td> {$intData['roster_expiration']} </td>";
				endif;
			}

		if($rosEXP != 'YES' && $rosEXP != 'URGENT'):
			echo "<td> $intLangs </td>";
		endif;
		
		//unset($intData['roster_number']);
		//unset($intData['roster_expiration']);
		//unset($intLangs);
		//unset($intGender);
	} else {
		echo "<td> &nbsp; </td>";
		echo "<td> &nbsp; </td>";
		echo "<td> &nbsp; </td>";
		echo "<td> &nbsp; </td>";
	}
	
	echo "</tr>";

}
echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";



?>


<script type="text/javascript">
	$(document).ready(function() {
		$('.msg-title').hide();
	    $('.InterperterRecordsData').DataTable( {
	        responsive: true
	    });
	});
</script>

	</div> <!-- aptForm -->
</div> <!-- siteWrap -->






<?php
require("scripts.php");
?>




</body>
</html>


