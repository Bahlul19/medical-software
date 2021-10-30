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
<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/jquery.plugin.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.tabletoCSV.js" type="text/javascript" charset="utf-8"></script>
<!-- Added for quick load -->
<script type="text/javascript" src="js/jquery.dataTables.min.js"/></script>

    <script>
        $(function(){
            $("#export").click(function(){
                $("#export_table").tableToCSV();
            });
        });
    </script>

<script>
jQuery(function($){
   $("#dob").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#phone").mask("(999) 999-9999");
//   $("#tin").mask("99-9999999");
//   $("#ssn").mask("999-99-9999");
});
</script>


<title> Itasca</title>
<style>
.aptButton{
	font-size:.6em;
	background-color:#CCCCFF;
	border:1px solid #000000;
}
#hidePat{
display:none;
}
.newPat{
color:#FFFFFF;
border:1px solid #FFFFFF;
cursor:pointer;
padding-left:10px;
padding-right:10px;
}
.newPat:hover{
	background-color:#222222;
}

#newPatient{
display:none;
}
.redBlock{
color:#FF0000;
font-size:1.2em;
text-align:center;
width:100%;
font-weight:bold;

}
</style>
<?php
require("{$legos}/head.php");
?>
</head>
<body>


<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");

$loadPat = $_GET['p'];

?>


<div class = 'siteWrap'>


	<div class = 'tableDisplay'>
		<div class = 'formTitle'>
		View Patients 
		<button id="export" data-export="export">Export</button>
		</div>
	<div class = 'redBlock'>
	*At least any two data element fields below are required to be entered for a search.
	</div>	

<table>
	
		<th> ID </td>
		<th> First Name </th>
		<!-- <th><input type='submit' name='ASC' value='Last Name'></th>"; -->
		<!-- <button onclick='myFunction()'>Last Name</button> -->
		<th> Last Name </th>
		<th> MRN </th>
		<th> Gender </th>
		<th> Last Name </th>
		<th> MRN </th>
		<th> Gender </th>
		<th> Last Name </th>
		<th> MRN </th>
		<th> Gender </th>
		<th> Last Name </th>
		<th> MRN </th>
		<th> Gender </th>
		<th> Last Name </th>
		<th> MRN </th>
		<th> Gender </th>
		<th> Last Name </th>
		<th> MRN </th>
		<th> Gender </th>
		<th> Last Name </th>
		<th> MRN </th>
		

		<?php

		$sql = "SELECT * FROM patients ";
		$go =  mysql_query($sql);

		if($sql)
		{
			while($row =  mysql_fetch_assoc($go))
			{
				 echo ' <tr> 
				  <td>'.$row['id'].'</td>
				  <td>'.$row['name_f'].'</td>
				  <td>'.$row['name_l'].'</td>
				  <td>'.$row['mrn'].'</td>
				  <td>'.$row['gender'].'</td>
				  <td>'.$row['dob'].'</td>
				  <td>'.$row['language'].'</td>
				  <td>'.$row['prefered_interpreter'].'</td>
				  <td>'.$row['provider_name'].'</td>
				  <td>'.$row['addr_1'].'</td>
				  <td>'.$row['addr_2'].'</td>
				  <td>'.$row['addr_city'].'</td>
				  <td>'.$row['addr_state'].'</td>
				  <td>'.$row['addr_zip'].'</td>
				  <td>'.$row['insurance_provider'].'</td>
				  <td>'.$row['insurance_id'].'</td>
				  <td>'.$row['phone'].'</td>
				  <td>'.$row['second_phone'].'</td>
				  <td>'.$row['clinic_id'].'</td>
				  <td>'.$row['facility_id'].'</td>
				  <td>'.$row['history'].'</td>
				  <td>'.$row['notes'].'</td>
				       

				  </tr>';
			}
		}


		?>



</table>

<?php


?>


</div>
</div>
