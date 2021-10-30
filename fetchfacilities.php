<?php
	$SECURE = TRUE;
	require("inc/init.php");
	if(isset($_POST["query"])) {
		$search = $_POST["query"];
		$query = "SELECT id,title,headquaters_clinic,address1,address2,city,state,zip,email,telephone1,telephone2,faxnumber,contracted_date,authorized_by FROM facilityredo WHERE
			(id LIKE '".$search."'
			OR title LIKE '".$search."%'
			OR headquaters_clinic LIKE '".$search."'
			OR address1 LIKE '".$search."'
			OR address2 LIKE '".$search."'
			OR city LIKE '".$search."'
			OR state LIKE '".$search."'
			OR zip LIKE '".$search."'
			OR email LIKE '".$search."'
			OR telephone1 LIKE '".$search."'
			OR telephone2 LIKE '".$search."%')
			";
			$go = mysql_query($query)or die(mysql_error());
			echo "<table id = 'export_table' class='table InterperterRecordsData main-table' border = '1'>";
			echo "<thead><tr>";
			
			echo "<th> Edit </th>";
			echo "<th>Facility ID</td>";
			echo "<th>Facility Title</td>";
			echo "<th> Headquarters </td>";
			echo "<th> Address One </td>";
			echo "<th> Address Two </td>";
			echo "<th> City </td>";
			echo "<th> State </td>";
			echo "<th> Zip Code </td>";
			echo "<th> Email </td>";
			echo "<th> Telephone 1 </td>";
			echo "<th> Telephone 2 </td>";
			echo "<th> Fax Number </td>";
			echo "<th> Contracted Date </td>";
			echo "<th> Authorized By </td>";
			echo "</tr></thead>";
			echo "<tbody>";
		
			while($row = mysql_fetch_assoc($go))
			{
				echo '<tr>';
				echo "<td> <a class = 'editButton' href = 'editFacilities.php?id={$row['id']}'> EDIT </a> </td>";
				echo '<td>'.$row['id'].'</td>';
				echo '<td>'.$row['title'].'</td>';
				echo '<td>'.$row['headquaters_clinic'].'</td>';
				echo '<td>'.$row['address1'].'</td>';
				echo '<td>'.$row['address2'].'</td>';
				echo '<td>'.$row['city'].'</td>';
				echo '<td>'.$row['state'].'</td>';
				echo '<td>'.$row['zip'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				echo '<td>'.$row['telephone1'].'</td>';
				echo '<td>'.$row['telephone2'].'</td>';
				echo '<td>'.$row['faxnumber'].'</td>';
				echo '<td>'.$row['contracted_date'].'</td>';
				echo '<td>'.$row['authorized_by'].'</td>';
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
	}
	else {
		$query = "SELECT id,title,headquaters_clinic,address1,address2,city,state,zip,email,telephone1,telephone2,faxnumber,contracted_date,authorized_by FROM facilityredo";
		$go = mysql_query($query)or die(mysql_error());
		echo "<table id = 'export_table' class='table InterperterRecordsData main-table' border = '1'>";
		echo "<thead><tr>";
		echo "<th> Edit </th>";
		echo "<th>Facility ID</td>";
		echo "<th>Facility Title</td>";
		echo "<th> Headquarters </td>";
		echo "<th> Address One </td>";
		echo "<th> Address Two </td>";
		echo "<th> City </td>";
		echo "<th> State </td>";
		echo "<th> Zip Code </td>";
		echo "<th> Email </td>";
		echo "<th> Telephone 1 </td>";
		echo "<th> Telephone 2 </td>";
		echo "<th> Fax Number </td>";
		echo "<th> Contracted Date </td>";
		echo "<th> Authorized By </td>";
		echo "</tr></thead>";
		echo "<tbody>";
		while($row = mysql_fetch_assoc($go))
		{
			echo '<tr>';
			echo "<td> <a class = 'editButton' href = 'editFacilities.php?id={$row['id']}'> EDIT </a> </td>";
			echo '<td>'.$row['id'].'</td>';
			echo '<td>'.$row['title'].'</td>';
			
			//new code start
			/*$headquaters_clinic = $row['headquaters_clinic'];
			$query2 = "SELECT title FROM clinics WHERE id = $headquaters_clinic";
		    $go2 = mysql_query($query2);
			$row2 = mysql_fetch_assoc($go2);
			echo '<td>'.$row2['title'].'</td>';*/
			//end
			echo '<td>'.$row['headquaters_clinic'].'</td>';
			echo '<td>'.$row['address1'].'</td>';
			echo '<td>'.$row['address2'].'</td>';
			echo '<td>'.$row['city'].'</td>';
			echo '<td>'.$row['state'].'</td>';
			echo '<td>'.$row['zip'].'</td>';
			echo '<td>'.$row['email'].'</td>';
			echo '<td>'.$row['telephone1'].'</td>';
			echo '<td>'.$row['telephone2'].'</td>';
			echo '<td>'.$row['faxnumber'].'</td>';
			echo '<td>'.$row['contracted_date'].'</td>';
			echo '<td>'.$row['authorized_by'].'</td>';
			echo "</tr>";
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
