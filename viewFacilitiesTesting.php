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


<div class = 'siteWrap'>


	<div class = 'tableDisplay'>
		<div class = 'formTitle'>
		View Facilities
		<button id="export" data-export="export">Export</button>
		</div>

<?php
echo "<div id='table-scroll' class='table-scroll'>";
echo "<div class = 'table-responsive table-wrap'>";
echo "<table class='table main-table' border = '1' id = 'export_table'>";
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
echo "</tr></thead><tbody>";
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
			//$hradr = $fi['addr_1'];
			$hraddress1 = $fi['addr_1'];
			$hraddress2 = $fi['addr_2'];
			$hrcity = $fi['addr_city'];
			$hrstate = $fi['addr_state'];
			$hrzip = $fi['addr_zip'];
			$hremail = $fi['email'];
			$hrphone1 = $fi['phone_1'];
			$hrphone2 = $fi['phone_2'];
			$hrfax = $fi['fax'];
			$hrContractedDate = $fi['contracted_date'];
			$hrAuthorizedBy = $fi['authorized_by'];
			
			echo "<td>{$hqt}</td>";
			echo "<td>{$hraddress1}</td>";
			echo "<td>{$hraddress2}</td>";
			echo "<td>{$hrcity}</td>";
			echo "<td>{$hrstate}</td>";
			echo "<td>{$hrzip}</td>";
			echo "<td>{$hremail}</td>";
			echo "<td>{$hrphone1}</td>";
			echo "<td>{$hrphone2}</td>";
			echo "<td>{$hrfax}</td>";
			echo "<td>{$hrContractedDate}</td>";
			echo "<td>{$hrAuthorizedBy}</td>";
		} else {
			echo "<td> $value </td>";
		}
	}
	// get facilities
	$color = "#FFFFFF";
echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";
?>

	</div> <!-- aptForm -->
</div> <!-- siteWrap -->


<?php
require("scripts.php");
?>


</body>
</html>
