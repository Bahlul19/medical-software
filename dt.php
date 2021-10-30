<?php
//testdatephp
require('inc/init.php');



?>

<html>
<head>
<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.datepick.js"></script>
<script>
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

$(function() {
	$('#popupDatepicker2').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

function showDate(date) {
	alert('The date chosen is ' + date);
}
</script>



<title> Itasca</title>
<?php
require("{$legos}/head.php");
?>
</head>

<?php
formLabel('popupDatepicker','Appointment Date');
	formInput('aptDate','text','','readonly="true" id="popupDatepicker"');
	
	hr();
	formLabel('popupDatepicker','Appointment Date');
	formInput('aptDate','text','','readonly="true" id="popupDatepicker2"');
	?>
<body>
