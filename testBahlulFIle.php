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
		View Facilities
		<button id="export" data-export="export">Export</button>
		</div>

<?php
echo "<table border = '1' id = 'export_table'>";
echo "<tr>";
	echo "<th> Edit </th>";
	echo "<th>Facility ID</td>";
	echo "<th>Facility Title</td>";
	echo "<th> Headquarters </td>";

	
echo "</tr>";

$sql = "SELECT * FROM facilities ";
if($uInfo['role'] == '3' || $uInfo['role'] == 4){ // clinic managers and staff can only see their own stuff.
	$sql .= " WHERE id = '{$uInfo['facility']}' ";
}
$sql .= " ORDER BY title ASC";
  

$go = mysql_query($sql)or die (mysql_error());
while($row = mysql_fetch_assoc($go)){
	echo "<tr>";
	$editID = $row['id'];
	echo "<td> <a class = 'editButton' href = 'editFacilities.php?f={$editID}'> EDIT </a> </td>";
	// catch vars from clinics
	foreach($row as $key => $value){
		if($key == 'headquarters'){
		//function dataGet($fieldsArray,$table,$where,$clause){
			$fi = dataGet('*','clinics','id',$value);
			$fi = $fi[0];
			$hqt = $fi['title'];
			$hradr = $fi['addr_1'];
			$hradr .= " {$fi['addr_2']}";
			$hradr .= " {$fi['addr_city']}";
			$hradr .= " {$fi['addr_state']}";
			$hradr .= " {$fi['addr_zip']}";
			echo "<td title = '{$hradr}' >{$hqt}</td>";
		} else {
			echo "<td> $value </td>";
		}
	}
	// get facilities
	$color = "#FFFFFF";
echo "</tr>";
}
?>

	</div> <!-- aptForm -->
</div> <!-- siteWrap -->


<?php
require("scripts.php");
?>


</body>
</html>
