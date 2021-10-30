<?php

$SECURE = TRUE;
require("inc/init.php");
?>
<title> Itasca</title>
<?php
require("{$legos}/head.php");
?>

<style type="text/css">
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
</style>

<body>
<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");

?>
<div class="siteWrap">


	<div class="tableDisplay">
		<div class="formTitle">
		Inactive Clincs	
		</div>
<?php
echo "<div id='table-scroll' class='table-scroll'>";
echo "<div class = 'table-responsive table-wrap'>";
echo "<table class='table ClinicInactiveRecordsData main-table' border = '1'>";
echo "<thead><tr>";
	echo "<th> Reactivate Clinic </th>";
	echo "<th> Facility </th>";
	echo "<th>Clinic Title</th>";
	echo "<th>Address 1</th>";
	echo "<th>Address 2</th>";
	echo "<th>City</th>";
	echo "<th>State</th>";
	echo "<th>Zip</th>";
	echo "<th>Email</th>";
	echo "<th>Phone 1</th>";
	echo "<th>Phone 2</th>";
	echo "<th>Fax</th>";
	echo "<th>Notes</th>";
	echo "<th>Contracted date</th>";
	echo "<th>Authorized By</th>";

	
echo "</tr></thead>
<tbody>
";

$sql = "SELECT id,clinic_id,title,addr_1,addr_2,addr_city,addr_state,addr_zip,email,phone_1,phone_2,fax,note,contracted_date,authorized_by FROM clinics WHERE inactive_clinic ='1' ";
$go = mysql_query($sql);


while ($row = mysql_fetch_assoc($go)) {


	echo "<tr>";
	echo '<td><a href="/portal/reactiveClinc.php?id='.$row["id"].'">'.$row["id"].'</a></td>';
	echo '<td>'.$row["clinic_id"].'</td>';
	echo '<td>'.$row["title"].'</td>';
	echo '<td>'.$row["addr_1"].'</td>';
	echo '<td>'.$row["addr_2"].'</td>';
	echo '<td>'.$row["addr_city"].'</td>';
	echo '<td>'.$row["addr_state"].'</td>';
	echo '<td>'.$row["addr_zip"].'</td>';
	echo '<td>'.$row["email"].'</td>';
	echo '<td>'.$row["phone_1"].'</td>';
	echo '<td>'.$row["phone_2"].'</td>';
	echo '<td>'.$row["fax"].'</td>';
	echo '<td>'.$row["note"].'</td>';
	echo '<td>'.$row["contracted_date"].'</td>';
	echo '<td>'.$row["authorized_by"].'</td>';

    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";
 

?>
</div>
