<?php
require("../inc/init.php");
?>

<?php
$thisUser = $_GET['u'];
$sec = $_GET['s'];
$tempPass = substr($sec, 0, 8);
if($tempPass == ''){
	$tempPass = 'H72i6cB9';
}
$newPass = md5($tempPass);

// compose an email
$subject = 'Your Itasca Portal Password Has Been Reset. <br>';
$message = "Your password has been reset. Your temporary password is {$tempPass} <br>";
$message .= "You must change your password on your next login.<br>";
$message .= "Please visit <a href = 'https://itascainterpreter.biz/portal'> https://itascainterpreter.biz/portal </a> to change your password. ";

//$headers = "From: Portal@itascainterpreter.biz \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset = ISO-8859-1\r\n";
$headers .= "From: Portal@itascainterpreter.biz" . "\r\n" .
"Reply-To: {$to}" . "\r\n" .
"X-Mailer: PHP/" . phpversion();
//echo "SEC = $sec";
$sql = "SELECT password, email FROM users WHERE id = '{$thisUser}'";
$go = mysql_query($sql);
$row = mysql_fetch_assoc($go);
$check = $row['password'];
$to = $row['email']; // so we can send an email
if($to == ''){
	echo '<div style = "width:100%;height:50px;background-color:#FF0000;text-align:center;"> ';
	echo "This User Has No Email Address";
	echo "</div>";
} else {
	//if($sec == $check){
		
	
		// we can continue
		//echo "All Good! {$tempPass} ";
		
		if(mail($to,$subject,$message,$headers)){
			$sql = "UPDATE users SET password = '{$newPass}' WHERE id = '{$thisUser}'";
			$reset = mysql_query($sql);
			$sql = "UPDATE users SET pass_reset = '1' WHERE id = '{$thisUser}'";
			$reset = mysql_query($sql);
			echo '<div style = "width:100%;height:50px;background-color:#00FF00;text-align:center;"> ';
			echo "Password Has Been Reset";
			echo "</div>";
		} else {
			echo '<div style = "width:100%;height:50px;background-color:#FF0000;text-align:center;"> ';
			echo "Email did not send";
			echo "</div>";
		}
		
		echo "</div>";
	/*} else {
		// shenanigans
		echo '<div style = "width:100%;height:50px;background-color:#FF0000;text-align:center;"> ';
		echo "Checksum Failed!";
		echo "</div>";
	} */

}

/*
$intTable = $_GET;
$uid = $intTable['uid'];
$usTable = array();
// Okay gather the USER table info
$usTable['phone_1'] = $intTable['phone_1'];
$usTable['phone_2'] = $intTable['phone_2'];
$usTable['email'] = $intTable['email'];
unset($intTable['phone_1']);
unset($intTable['phone_2']);
unset($intTable['email']);
unset($intTable['uid']);
//unset($usTable['uid']);

// Okay so now we have users tabel data and interpreter table data separate.
// function updateTable($table,$col,$id,$array){
// $sql = "UPDATE {$table} SET {$key} = '{$value}' WHERE {$col} = '{$id}'";

//print_r($usTable);
updateTable('users','id',$uid,$usTable);
updateTable('interpreters','id',$uid,$intTable);
*/
?>

</div>
