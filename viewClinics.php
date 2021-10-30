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


<style type="text/css">
	
.deletex{
	background-color:#FF0000;
	color:#FFFFFF;
	font-weight:bold;
	font-size:.8em;
	width:10px;
	height:15px;
	line-height:15px;
	padding:0px 3px;
	DISPLAY:INLINE-BLOCK;
}

#modalplace{
	width:100%;
	height:400 px;
	background-color:#666;
	color:#FFF;
	display:none;
	z-index:999;
	text-align:center;
}

.modalWindow{
	margin-left:auto;
	margin-right:auto;
	margin-top:50px;
	width:50%;
	height:300px;
	background-color:#FFF;
	color:#000;
	border:2px solid #FF0000;
}

	.deletex{
		background-color:#FF0000;
		color:#FFFFFF;
		font-weight:bold;
		font-size:.8em;
		width:10px;
		height:15px;
		line-height:15px;
		padding:0px 3px;
		DISPLAY:INLINE-BLOCK;
	}

	#modalplace{
		width:100%;
		height:400 px;
		background-color:#666;
		color:#FFF;
		display:none;
		z-index:999;
		text-align:center;
	}

	.modalWindow{
		margin-left:auto;
		margin-right:auto;
		margin-top:50px;
		width:50%;
		height:300px;
		background-color:#FFF;
		color:#000;
		border:2px solid #FF0000;
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
	
</style>
 <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
 <script src="js/jquery.tabletoCSV.js" type="text/javascript" charset="utf-8"></script>

    <script>
    	/* old code
        $(function(){
            $("#export").click(function(){
                $("#export_table").tableToCSV();
            });
        });
        */

    //new code 3-3-19
	$(document).ready(function($){
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

<div id = 'modalplace'> 
	<div class = 'modalWindow' id = 'modalWindow'>
		
	</div>

</div>

</div>


<div class = 'siteWrap' id="siteWrap">


	<div class = 'tableDisplay'>
		<div class = 'formTitle'>
		View Clinics
		<button id="export" data-export="export">Export</button>

		</div>
<span class="msg-title"><h1>Loading...</h1></span>

<?php
echo "<div id='table-scroll' class='table-scroll'>";
echo "<div class = 'table-responsive table-wrap'>";
echo "<table class='table ClinicRecordsData main-table' border = '1' id = 'export_table'>";
echo "<thead><tr>";
	echo "<th> Edit </th>";
	echo "<th> Delete </th>";
	echo "<th>Clinic ID</th>";
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
	
echo "</tr></thead>
<tbody>
";


$sql = "SELECT id,clinic_id,title,addr_1,addr_2,addr_city,addr_state,addr_zip,email,phone_1,phone_2,fax,note FROM clinics ";
	$sql .= " WHERE inactive_clinic = 0 ";
if($uInfo['role'] == '3' || $uInfo['role'] == 4){ 
	$sql .= " WHERE clinic_id = '{$uInfo['facility']}' AND inactive_clinic = 0";
}
$sql .= " ORDER BY title, clinic_id, id ASC ";
  

$go = mysql_query($sql)or die (mysql_error());
while($row = mysql_fetch_assoc($go)){
	echo "<tr>";
	$mainClinicID = $row['id'];

	echo "<div>
		<input type='hidden' id='clinicID' value='" . $mainClinicID . "'>
	</div>";

	$editID = $row['id'];
	echo "<td> <a class = 'editButton' href = 'editClinics.php?c={$editID}'> EDIT </a> </td>";
	echo "<td> &nbsp;&nbsp;&nbsp;<div id = 'deldept_{$mainClinicID}' class = 'deletex' onclick = 'delclinic (this.id)'>X</div> </td>";
	$vall = array();
	$myArray = array();
	foreach($row as $key => $value){
		$facID = $row['id'];
		if($key == 'clinic_id'){
			$sq2 = "SELECT title, headquaters_clinic from facilityredo WHERE id = '{$value}' ORDER BY title ASC";
			$get = mysql_query($sq2);
			$r2 = mysql_fetch_assoc($get);
			$clinTitle = $r2['title'];
			if(isset($_POST['search-clinic-button'])){
				//echo "true1";
				$_POST['search-clinic'];
				var_dump(strcasecmp($r2['title'],$_POST['search-clinic']));
			}

			$clinID = $r2['headquaters_clinic'];

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

	$color = "#FFFFFF";
echo "</tr>";
}
?>
</tbody>
</table>
</div>
</div>

	</div> 
</div>


<script type="text/javascript">


$(document).ready(function() {
	$('.msg-title').hide();
    $('.ClinicRecordsData').DataTable( {
        responsive: true
    } );
} );

//copy from editDepartments.php file fo checking the delete issue

function delclinic($str){
	//console.log($str);
	document.getElementById('modalplace').style.display = 'block';
	document.getElementById("siteWrap").style.display = "none";
	//document.getElementById('modalWindow').innerHTML = $str;

	console.log(window.XMLHttpRequest);
	
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("modalWindow").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/deleteduplicateclinic.php?q="+$str,true);

	// console.log(xmlhttp.open("GET","/portal/proc/deleteduplicateclinic.php?q="+$str,true));
	xmlhttp.send();

}

function modalClose(){
	document.getElementById('modalplace').style.display = 'none';
	document.getElementById("siteWrap").style.display = "block";
}

function updateDeleteClinic(){

	var $newClinic = document.getElementById("newClinic").value;

	var $oldClinic = document.getElementById("delId").value;

	var $mainClinicID = document.getElementById("clinicID").value;

	console.log($oldClinic);
	
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			alert("deleting"+$oldClinic+" -- replacing with "+$newClinic);
			document.getElementById("modalWindow").innerHTML=xmlhttp.responseText;
		} 
	}
	
	xmlhttp.open("GET","/portal/proc/deleteduplicateclinicpart2.php?del="+$oldClinic+"&rep="+$newClinic+"&cl="+$mainClinicID,true);
	xmlhttp.send();
}

</script>

<?php
require("scripts.php");
?>


</body>
</html>
