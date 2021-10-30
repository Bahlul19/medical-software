<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");
?>
<!doctype HTML>
<html>
<head>
<title> Itasca</title>

 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
 <script src="js/jquery.tabletoCSV.js" type="text/javascript" charset="utf-8"></script>
 <script type="text/javascript" src="js/jquery.dataTables.min.js"/>

    <script>
        $(function(){
            $("#export").click(function(){
                $("#export_table").tableToCSV();
            });
        });
    </script>


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
		View Clinics
		<button id="export" data-export="export">Export</button>

		</div>
<span class="msg-title"><h1>Loading...</h1></span>

<?php
echo "<table class='ClinicRecordsData' border = '1' id = 'export_table'>";
echo "<thead><tr>";
	echo "<th> Edit </th>";
	echo "<th>Clinic ID</td>";
	echo "<th> Facility </td>";
	echo "<th>Clinic Title</td>";
	echo "<th>Address 1</td>";
	echo "<th>Address 2</td>";
	echo "<th>City</td>";
	echo "<th>State</td>";
	echo "<th>Zip</td>";
	echo "<th>Email</td>";
	echo "<th>Phone 1</td>";
	echo "<th>Phone 2</td>";
	echo "<th>Fax</td>";
	echo "<th>Notes</td>";
	echo "<th></td>";
	echo "<th></td>";
	echo "<th>History</td>";

	
echo "</tr></thead>
<tbody>
";


$sql = "SELECT * FROM clinics ";
if($uInfo['role'] == '3' || $uInfo['role'] == 4){ 
	$sql .= " WHERE clinic_id = '{$uInfo['facility']}' ";
}
$sql .= " ORDER BY title, clinic_id, id ASC";
  

$go = mysql_query($sql)or die (mysql_error());
while($row = mysql_fetch_assoc($go)){
	echo "<tr>";
	$mainClinicID = $row['id'];
	$editID = $row['id'];
	echo "<td> <a class = 'editButton' href = 'editClinics.php?c={$editID}'> EDIT </a> </td>";
	$vall = array();
	$myArray = array();
	foreach($row as $key => $value){
		$facID = $row['id'];
		if($key == 'clinic_id'){
			$sq2 = "SELECT title, headquarters from facilities WHERE id = '{$value}' ORDER BY title ASC";
			$get = mysql_query($sq2);
			$r2 = mysql_fetch_assoc($get);
			$clinTitle = $r2['title'];
			if(isset($_POST['search-clinic-button'])){
				//echo "true1";
				$_POST['search-clinic'];
				var_dump(strcasecmp($r2['title'],$_POST['search-clinic']));
			}

			$clinID = $r2['headquarters'];

			if($clinID == $facID) {
				$color = "#DDDDDD";
			} else {
				$color = "#FFFFFF";
			}
			echo "<td style = 'background-color:{$color};'> {$clinTitle} </td>";
		} else {
			echo "<td style = 'background-color:{$color};'> $value </td>";
		}
	}
	echo "<td><a href = '{$htmlRoot}/viewClinicsHistory.php?tp={$mainClinicID}'> View History </a></td>";
	$color = "#FFFFFF";
echo "</tr>";
}
?>
</tbody>
</table>

	</div> 
</div>


<script type="text/javascript">


$(document).ready(function() {
	$('.msg-title').hide();
    $('.ClinicRecordsData').DataTable( {
        responsive: true
    } );
} );


</script>

<?php
require("scripts.php");
?>


</body>
</html>
