<?php
$sendEmail = 'ON';
$emailTo = 'n.rubenstein@cosmicumbrella.com';
if($sendEmail == 'ON'){ // send an email
	$emailHeaders = "From: appointments@itascainterpreter.biz\r\n";
	$emailHeaders .= "MIME-Version: 1.0\r\n";
	$emailHeaders .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject = "Change to appointment number {$thisID}";
	$message = "Appointmnt number {$thisID} has changed. ";
	$message .= " Please log in to <a href = 'http://itascainterpreter.biz/portal'> The Itasca Portal </a> to view this appointment.";
	mail($emailTo,$subject,$message,$emailHeaders)or die("error sending email");
	
}

?>
