<?php
	//lazyload

	// View Clinics : BENSON
	// Show clinics and associated facilities
	// Nik Rubenstein 12-10-2014
	$SECURE = TRUE;
	require("inc/init.php");
?>
<!doctype HTML>
<html>
<head>
	<link href="css/jquery.datepick.css" rel="stylesheet">
	<!-- Added jquery for quick load -->
	<script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
	<script src="js/jquery.plugin.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.tabletoCSV.js" type="text/javascript" charset="utf-8"></script>
	<script>
		$('.PatientRecordsData').hide();
		//new code 3-3-19
		$(document).ready(function($){
			 $("#export").click(function(){
			 	$("#export_table").tableToCSV();
			 });
		});
	</script>
	<script>
		jQuery(function($){
		   $("#phone").mask("(999) 999-9999");
		});
	</script>
	<script src="js/jquery.datepick.js"></script>
	<script>
	$(function() {
		$('#dob').datepick();
		$('#inlineDatepicker').datepick({onSelect: showDate});
	});
	</script>
	<!-- This 2-link has been added for ajax live search for view patints -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<title> Itasca</title>
	<style>
		.dataTables_filter {
			display: none;
		}
		#load_data_message {
			display: none;
		}
		.aptButton{
			font-size:.6em;
			background-color:#CCCCFF;
			border:1px solid #000000;
		}
		.redBlock{
			color:#FF0000;
			font-size:1.2em;
			text-align:center;
			width:100%;
			font-weight:bold;
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
			<?php
				echo "<div id = 'filter'>";
				echo "<div id='table-scroll' class='table-scroll'>";
				echo "<div class = 'table-responsive table-wrap'>";
					echo "<table class='table InterperterRecordsData main-table'>";
					echo "<tr>";
					echo "<th style = 'font-size:1.0em;'> First Name </th>";
					echo "<th> Last Name </th>";
					echo "<th> Date Of Birth </th>";
					echo "<th> Language </th>";
					echo "<th> Insurance ID </th>";
					if($uInfo['role'] == 1 || $uInfo['role'] == 2){ // only if they have a choice
						echo "<th> Facility </th>"; // can choose both
						echo "<th> Clinic </th>"; // ""
					} 
					// Add user-clini-facility-filter-here
					if($uInfo['role'] == 3){ // they can view facs
						echo "<th> Clinic </th>";
					}
					echo "<th> Search </th>";
					echo "</tr>";
					echo "<tr>";
					echo "<form action='' method='GET'>";
						//fname
						echo "<td style = 'text-align:center;'>";
						echo "<input type='text' size = '15' name='fName' id = 'fName' style = 'font-size:1.0em;' >";
						echo "</td>";
						//lname
						echo "<td>";
						echo "<input type='text' size = '15' name='lName' id = 'lName'>";
						echo "</td>";
						//dob
						echo "<td>";
						echo "<input type='text' size = '10' name='dob' id = 'dob'>";
						echo "</td>";
						// add language
						echo "<td>";
						echo "<select name = 'patLanguage' id = 'patLanguage'>";
						echo "<option value = 'ANY'> ANY </option>";
						foreach($languageList as $lid => $lTitle){
							echo "<option value = '{$lid}'> {$lTitle} </option>";
						}
						echo "</select>";
						echo "</td>";
						//add Insurance ID
						echo "<td>";
						echo "<input type='text' size = '20' name='ins' id = 'ins'>";
						echo "</td>";
						//Facility dropdown
						if($uInfo['role'] == 1 || $uInfo['role'] == 2){
							$sql = "SELECT id, title FROM facilityredo ORDER BY title ASC";
							echo "<td>";
							$go = mysql_query($sql)or die(mysql_error());
							echo "<select name = 'facility' id = 'facility'>";
							echo "<option value = 'ANY'> ANY </option>";
							while ($row = mysql_fetch_assoc($go)){
								echo"<option value = '{$row['id']}'> {$row['title']} </option>";
							}		
							echo "</select>";
							echo "</td>";
						} else {
							echo "<input type = 'hidden' id = 'facility' name = 'facility' value = '{$uInfo['facility']}'>";
						}
						// Clinic Dropdown
						if($uInfo['role'] == 1 || $uInfo['role'] == 2 || $uInfo['role'] == 3){ // if there is a choice
							$sql = "SELECT id, title FROM clinics ORDER BY title ASC";
							echo "<td>";
							if($uInfo['role'] == 3){
								$sql .= " WHERE clinic_id = '{$uInfo['facility']}' ";
							}
							$go = mysql_query($sql);
							echo "<select name = 'clinic' id = 'clinic'>";
							echo "<option value = 'ANY'> ANY </option>";
							while ($row = mysql_fetch_assoc($go)){
								echo"<option value = '{$row['id']}'> {$row['title']} </option>";
							}		
							echo "</select>";
							echo "</td>";
						} else {
						}
						echo "<td><input type = 'submit' value = 'submit'> </td>";
					echo "</tr>";
					echo "</form>";
					echo "</table>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				// Okay we will ajax the data in from here....
				echo "<div id = 'showTable'>";
				hr();
				echo "<div id='load_data_message'></div>"; ?>
				<?php 
				echo "<div id='tbl-outer table-scroll' class='table-scroll'>";
				echo "<div class = 'table-responsive table-wrap' id='tbl-inner'>";
				echo "<table class='table InterperterRecordsData main-table PatientRecordsData' border = '1' id = 'export_table'>";
				echo "<thead><tr>";
					if($uInfo['role']==4){
						echo "<th> View </th>";
					} else {
						echo "<th> Edit </th>";
					}
					echo "<th> ID </th>";
					echo "<th> First Name </th>";
					echo "<th> Last Name </th>";
					echo "<th> MRN </th>";
					echo "<th> Gender </th>";
					echo "<th> DOB </th>";
					echo "<th> Language </th>";
					echo "<th> Preferred Int </th>";
					echo "<th> Address 1 </th>";
					echo "<th> Address 2 </th>";
					echo "<th> City </th>";
					echo "<th> State </th>";
					echo "<th> Zip </th>";
					echo "<th> Insurance </th>";
					echo "<th> Insurance ID </th>";
					echo "<th> Phone</th>";
				    echo "<th> Second Phone</th>";
					echo "<th> Clinic</th>";
					echo "<th> Facility</th>";
					echo "<th> History </th>";
				    echo "<th> Note </th>";
					//echo "<th> Appointment </th>";
				echo "</tr></thead>";
				echo "<tbody  id='result'>";
				echo "</tbody>";
				echo "</table>";
				echo "</div>";
				echo "</div>";
				echo "</div>"; // showTable
			?>
			<span class="msg-title"><h1>Loading...</h1></span>
			<div id = 'hidePat'>
			</div>
		</div> <!-- aptForm -->
	</div> <!-- siteWrap -->
	<script>
		$(document).ready(function(){
			//give table height for bottom scrollbar
			function giveTableHeight() {
				vph = $(window).height();
				vph = vph - 340;
				vph2 = vph - 20;
				$('#tbl-outer').css({'height': vph + 'px'});
				$('#tbl-inner').css({'height': vph2 + 'px'});
			}
			giveTableHeight();
			var limit = 7;
			var start = 0;
			var search;
			function getUrlVars() {
			    var vars = {};
			    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			        vars[key] = value;
			    });
			    return vars;
			}
			function getUrlParam(parameter, defaultvalue){
			    var urlparameter = defaultvalue;
			    if(window.location.href.indexOf(parameter) > -1){
			        urlparameter = "filtered";
			        }
			    return urlparameter;
			}
			var filtered = getUrlParam('fName','notFiltered');
			function load_data(query) {
				$.ajax({
			   		url:"lazyloadfetch.php",
				    method:"POST",
				    data:{query:search, limit:limit, start:start},
				    cache:false,
			   		success:function(data) {
			    		$('#result').append(data);
			    		if(data == '') {	
							$('#load_data_message').html("<button type='button' class='btn btn-info'>No Data Found</button>");
							$('.PatientRecordsData').DataTable({
						        responsive: true,
						        paging: false,
						    });
						}
						else {
							$('.PatientRecordsData').DataTable({
						        responsive: true,
						        paging: false,
						        retrieve: true,
						    });
							$('#load_data_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
						}
						setTimeout(function(){
							start = start + limit;
				            load_data(); //this will send request again and again;
			            }, 1000);
					}
			    });
			}
			if(filtered =="filtered") {
				newUFilter();	
			}
			else {
				load_data();
				$(window).scroll(function() {
					if($(window).scrollTop() + $(window).height() > $("#result").height()) {
						start = start + limit;
						if(search == undefined) {
							setTimeout(function(){
								load_data();
							}, 1000);
						}
					}
				});
			}
			function newUFilter() {
				var fName = getUrlVars()["fName"];
				var lName = getUrlVars()["lName"];
				var dob = getUrlVars()["dob"];
				var ins = getUrlVars()["ins"];
				var fac = getUrlVars()["facility"];
				var patLanguage = getUrlVars()["patLanguage"];
				var clinic = getUrlVars()["clinic"];
				var search = "filterSearch";
				$.ajax({
				   		url:"lazyloadfetch.php",
					    method:"POST",
					    data:{query:search, fName:fName, lName:lName, dob:dob, clinic:clinic, patLanguage:patLanguage, ins:ins},
					    cache:false,
				   		success:function(data) {
						    $('#result').children().remove();
				    		$('#result').append(data);
				    		if(data == '') {	
								$('#load_data_message').html("<button type='button' class='btn btn-info'>No Data Found</button>");
								$('.PatientRecordsData').DataTable({
							        responsive: true,
							        paging: false,
							    });
							}
							else {
								$('.PatientRecordsData').DataTable({
							        responsive: true,
							        paging: false,
							        retrieve: true,
							    });
								$('#load_data_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
							}	
				   		}
				    });
			}
		});
	</script>	
	<!-- new add data table -->
	<script type="text/javascript">
		$(window).load(function() {
		 	// executes when complete page is fully loaded, including all frames, objects and images
		 	$('.msg-title').hide();
			$('.PatientRecordsData').show();
		 
		});
	</script>
	<?php
		require("scripts.php");
	?>
</body>
</html>
