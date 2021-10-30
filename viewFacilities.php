<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("inc/init.php");

// $editID = $_GET['id'];

//$editID = $_GET['id'];

//$facility = $_GET['f'];

?>
<!doctype HTML>
<html>
<head>
<title> Itasca</title>
<!--new one link 1-3-19-->
 <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
 <!-- This 2-link has been added for ajax live search -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.tabletoCSV.js" type="text/javascript" charset="utf-8"></script>
    <script>
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

<style type="text/css">


.search-box-area{
		text-align: left !important;
	}
	.search-box {
		width: 333px;
		margin-bottom: 20px;
		height: 40px;
	}
	.search-label{
		font-size: 20px;
		font-weight: 900;
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


<div class = 'siteWrap'>


	<div class = 'tableDisplay'>
		<div class = 'formTitle'>
		View Facilities
		<button id="export" data-export="export">Export</button>
		</div>

		<?php
		echo "<div id='table-scroll' class='table-scroll'>";
		echo "<div class = 'table-responsive table-wrap' id='result'>";
		echo "</div>";
		echo "</div>";
		?>

<script>
	$(document).ready(function(){
	 load_data();
	 function load_data(query)
	 {
	  $.ajax({
	   url:"fetchfacilities.php",
	   method:"POST",
	   data:{query:query},
	   success:function(data)
	   {
	    $('#result').html(data);
	   }
	  });
	 }
	 $('#search_text').keyup(function(){
	  var search = $(this).val();
	  if(search != '')
	  {
	   load_data(search);
	  }
	  else
	  {
	   load_data();
	  }
	 });
	});
 </script>
	</div> <!-- aptForm -->
</div> <!-- siteWrap -->

<?php
	require("scripts.php");
?>