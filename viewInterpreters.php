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
 <!-- This 2-link has been added for ajax live search -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 <?php
	require("{$legos}/head.php");
 ?>
 <style type="text/css">
	/*.search-box-area{
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
	}*/
	#DataTables_Table_0_length, .dataTables_length{
		text-align: right!important;
	}
	.dataTables_length{
		margin-bottom: 10px;
	}
	/*.dataTables_filter {
		display: none;
	}*/
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
	.tableDisplay {
    	text-align: center;
	}
	.dataTables_info {
	    color: #0000ff;
	    font-size: 18px;
	    font-weight: bold;
	}
	.dataTables_paginate {
	    color: #0000ff;
	    font-size: 22px;
	    font-weight: bold;
	}
	.paginate_button {
	    margin-left: 5px;
	}
	.urgent{
		background-color:#000000;
		background-image:url('img/urgent.gif');
		color:#FFFFFF;
		font-weight:bold;
	}
 </style>
</head>
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
		<div class="form-group">
		    <!--<div class="search-box-area">
			    <span class="search-label">Search</span>
			    <input type="text" name="search_text" id="search_text" placeholder="" class="search-box"/>
		    </div>-->
		</div>
		<?php
			/*
			echo "<th> Search </th>";
			echo "</tr>";
			//function formInput($name,$type,$value,$param){
			echo "<tr>";
			echo "<form action = '' method = 'post'>";
			*/
			foreach($_GET as $k => $v){
				print_r($_GET);
				exit();
				if($v != 'ANY' && $v != '' && $v != 'false'){
					if($k != 'hi' && $k != 'hiVal'){
						$others[$k] = $v;
					}
				}
			}
			$where = " WHERE ";
			// if($role == 3){
			// 	$where .= " clinic_id = '{$uInfo['clinic']}' ";
			// }
			// if($role == 4){
			// 	$where .= " facility_id = '{$uInfo['facility']}' ";
			// }
			if($role == 5){
				$where .= " interpreter_id = '{$uInfo['interpreter']}' ";
			}
			foreach($others as $k => $v){
				print_r($v);
				exit();
				if ($where != " WHERE  "){
					$where .= " AND ";
				}
				if($k =='name_f' || $k == 'name_l'){
					$where .= "{$k} LIKE '%{$v}%'"; // names are LIKE %value%
				} else {
					$where .= "{$k} = '{$v}'";
				}
			}
			// $sql = "SELECT id,role,clinic,facility,name_f,name_l,phone_1,phone_2,email,addr_1,addr_2,addr_city,addr_state,addr_zip,uname FROM users WHERE role = 5";
			//$sql = "SELECT id,role,facility,name_f,name_l,phone_1,phone_2,email,addr_1,addr_city,addr_state,addr_zip,uname FROM users WHERE role = 5";
			//$go = mysql_query($sql)or die(mysql_error());
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
	   url:"fetchInterpreters.php",
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
 </body>
</html>
