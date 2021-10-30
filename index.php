<?php
$SECURE = FALSE;
require_once("inc/init.php");
?>
<!doctype HTML>
<html>
<head>

<style>
.homePage{
	border:3px solid #000000;
	background-color:#FFFFFF;
	color:#000000;
	margin:auto;
	margin-top:10px;
	padding:10px 30px 10px 30px;
	text-align:center;
}

.homePage table{
	border-collapse:collapse;
	padding:10px;
}

.homePage td{
	margin-top:10px;
}

.homePage table th{
	border-bottom:2px solid #000000;
}
.homePage table a{
	margin-top:10px;
	display:inline-block;
	width:90%;
	text-decoration:none;
	color:#000000;
	background-color:#dddddd;
	border:1px solid #000000;
}

.loginCenter{
width:30%;
margin:auto;
border:3px solid #000000;
padding:30px;
}

.isDisabled {
  color: currentColor;
  cursor: not-allowed;
  opacity: 0.5;
  text-decoration: none;
}
.video-conference-link {
	opacity: 0;
	position: absolute;
}
.appointment-id {
	width: 42%;
}
.get-appointment-submit {
	width: 42% !important;
}
.copy-to-clipboard {
	width: 45% !important;
	margin-right: 5px;
}
.join-link {
	width: 42%  !important;
}
</style>




<title> Itasca</title>
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
<div class = 'homePage'>
		<div class = 'formTitle'>
		Welcome
		</div>

<?php
$imgSize = '100';
if($_SESSION['logged']){


	switch($role){
		case 1: // sys admin
			echo "<table width = '100%'>";
				echo "<tr>";
					echo "<th width = '25%'>";
						echo "<img src = '{$htmlRoot}/img/clinic.png' width = '{$imgSize}'>";
						br();
						echo "Clinics And Facilities";
					echo "</th>";
					echo "<th width = '25%'>";
						echo "<img src = '{$htmlRoot}/img/patient.png' width = '{$imgSize}'>";
						br();
						echo "Patients";
					echo "</th>";
					echo "<th width = '25%'>";
						echo "<img src = '{$htmlRoot}/img/interpreter.png' width = '{$imgSize}'>";
						br();
						echo "Users";
					echo "</th>";
					echo "<th width = '25%'>";
						echo "<img src = '{$htmlRoot}/img/schedule.png' width = '{$imgSize}'>";
						br();
						echo "Appointments";
					echo "</th>";
				echo "</tr>";
				
				echo "<tr>";

					echo "<td><a href = '{$htmlRoot}/newClinic.php'>New Clinic </a></td>";
					echo "<td><a href = '{$htmlRoot}/newPatient.php'>New Patient</a></td>";
					echo "<td><a href = '{$htmlRoot}/newUser.php'>New User </a></td>";
					echo "<td><a href = '{$htmlRoot}/searchPatients.php'>New Appointment</a></td>";
				echo "</tr>";
				
				echo "<tr>";

					 echo "<td><a href = '{$htmlRoot}/newFacility.php'>New Facility </a></td>";
					echo "<td><a href = '{$htmlRoot}/viewPatients.php'>View Patients</a></td>";
					echo "<td><a href = '{$htmlRoot}/viewUsers.php'>View Users (All Roles)</a></td>";
					echo "<td><a href = '{$htmlRoot}/viewAppointments.php'>View / Edit Appointments</a></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td><a href = '{$htmlRoot}/viewClinics.php'>View Clinics</a></td>";
					echo "<td> &nbsp; </td>";
					echo "<td> &nbsp; </td>";
					echo "<td>
								<input type='text' id='appointment-id' class='appointment-id' value='' placeholder='ICONNECT APPT ID' />
								<a href='javascript:void(0);' id='get-appointment-submit' class='get-appointment-submit'>Submit</a>
						</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td><a href = '{$htmlRoot}/viewFacilities.php'>View Facilities</a></td>";
					echo "<td> &nbsp; </td>";
					echo "<td> &nbsp; </td>";
					echo "<td>
								<input type='text' id='video-conference-link' class='video-conference-link' value='' />
								<a href='javascript:void(0);' onclick='copyToClipboard()' class='copy-to-clipboard'>Copy</button>
								<a href='javascript:void(0);' id='join-url' class='join-link' target='_blank' style='display: none'>Join</button>
						</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td> &nbsp; </td>";
					echo "<td></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td> &nbsp; </td>";
					echo "<td></td>";
				echo "</tr>";
			echo "</table>";
		break;
		case 2: // itasca staff
			echo "<table width = '100%'>";
				echo "<tr>";
					echo "<th width = '25%'>";
						echo "<img src = '{$htmlRoot}/img/clinic.png' width = '{$imgSize}'>";
						br();
						echo "Clinics And Facilities";
					echo "</th>";
					echo "<th width = '25%'>";
						echo "<img src = '{$htmlRoot}/img/patient.png' width = '{$imgSize}'>";
						br();
						echo "Patients";
					echo "</th>";
					echo "<th width = '25%'>";
						echo "<img src = '{$htmlRoot}/img/interpreter.png' width = '{$imgSize}'>";
						br();
						echo "Users";
					echo "</th>";
					echo "<th width = '25%'>";
						echo "<img src = '{$htmlRoot}/img/schedule.png' width = '{$imgSize}'>";
						br();
						echo "Appointments";
					echo "</th>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td><a href = '{$htmlRoot}/viewClinics.php'>View Clinics</a></td>";
					echo "<td><a href = '{$htmlRoot}/newPatient.php'>New Patient</a></td>";
					echo "<td><a href = '{$htmlRoot}/newUser.php'>New User </a></td>";
					echo "<td><a href = '{$htmlRoot}/searchPatients.php'>New Appointment</a></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td><a href = '{$htmlRoot}/viewFacilties.php'>View Facilities</a></td>";
					echo "<td><a href = '{$htmlRoot}/viewPatients.php'>View Patients</a></td>";
					echo "<td><a href = '{$htmlRoot}/viewUsers.php'>View Users (All Roles)</a></td>";
					echo "<td><a href = '{$htmlRoot}/viewAppointments.php'>View / Edit Appointments</a></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td> &nbsp; </td>";
					echo "<td> &nbsp; </td>";
					echo "<td> &nbsp; </td>";
					echo "<td>
								<input type='text' id='appointment-id' class='appointment-id' value='' placeholder='ICONNECT APPT ID' />
								<a href='javascript:void(0);' id='get-appointment-submit' class='get-appointment-submit'>Submit</a>
						</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td> &nbsp; </td>";
					echo "<td> &nbsp; </td>";
					echo "<td> &nbsp; </td>";
					echo "<td>
								<input type='text' id='video-conference-link' class='video-conference-link' value='' />
								<a href='javascript:void(0);' onclick='copyToClipboard()' class='copy-to-clipboard'>Copy</button>
								<a href='javascript:void(0);' id='join-url' class='join-link' target='_blank' style='display: none'>Join</button>
						</td>";
				echo "</tr>";
				
			echo "</table>";
			break;
		case 3: // clinic manager
			echo "<table width = '100%'>";
				echo "<tr>";
					
					echo "<th width = '50%'>";
						echo "<img src = '{$htmlRoot}/img/patient.png' width = '{$imgSize}'>";
						br();
						echo "Patients";
					echo "</th>";
				
					echo "<th width = '50%'>";
						echo "<img src = '{$htmlRoot}/img/schedule.png' width = '{$imgSize}'>";
						br();
						echo "Appointments";
					echo "</th>";
				echo "</tr>";
				
				echo "<tr>";					
					echo "<td><a href = '{$htmlRoot}/viewPatients.php'>View Patients</a></td>";					
					echo "<td><a href = '{$htmlRoot}/searchPatients.php'>New Appointment</a></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td></td>";
					echo "<td><a href = '{$htmlRoot}/viewAppointments.php'>View / Edit Appointments</a></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td></td>";
					echo "<td>
						<input type='text' id='appointment-id' class='appointment-id' value='' placeholder='ICONNECT APPT ID' />
						<a href='javascript:void(0);' id='get-appointment-submit' class='get-appointment-submit'>Submit</a>
					</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td></td>";
					echo "<td>
							<input type='text' id='video-conference-link' class='video-conference-link' value='' />
							<a href='javascript:void(0);' onclick='copyToClipboard()' class='copy-to-clipboard'>Copy</button>
							<a href='javascript:void(0);' id='join-url' class='join-link' target='_blank' style='display: none'>Join</button>
						</td>";
				echo "</tr>";
			echo "</table>";
			
		break;
		case 4: // Limited
			echo "<table width = '100%'>";
				echo "<tr>";
					echo "<th width = '50%'>";
						echo "<img src = '{$htmlRoot}/img/patient.png' width = '{$imgSize}'>";
						br();
						echo "Patients";
					echo "</th>";
					echo "<th width = '50%'>";
						echo "<img src = '{$htmlRoot}/img/schedule.png' width = '{$imgSize}'>";
						br();
						echo "Appointments";
					echo "</th>";
				echo "</tr>";
				
				
				
				echo "<tr>";
				
					echo "<td><a href = '{$htmlRoot}/viewPatients.php'>View Patients</a></td>";
					
					echo "<td><a href = '{$htmlRoot}/viewAppointments.php'>View Appointments</a></td>";
				echo "</tr>";
			echo "</table>";
		break;
		case 5: // interpreter
			echo "<table width = '100%'>";
				echo "<tr>";
					echo "<th width = '33%'>";
						echo "<a href = '{$htmlRoot}/intProfile.php'>";
						echo "<img src = '{$htmlRoot}/img/interpreter.png' width = '{$imgSize}'>";
						br();
						echo "My Information";
						echo "</a>";
					echo "</th>";
					echo "<th width = '33%'>";
						echo "<a href = '{$htmlRoot}/intSchedule.php'>";
						echo "<img src = '{$htmlRoot}/img/schedule.png' width = '{$imgSize}'>";
						br();
						echo "My Schedule";
						echo "</a>";
					echo "</th>";
					echo "<th width = '33%'>";
						echo "<a href = '{$htmlRoot}/intAppointments.php'>";
						echo "<img src = '{$htmlRoot}/img/newSchedule.png' width = '{$imgSize}'>";
						br();
						echo "Available Appointments";
						echo "</a>";
					echo "</th>";
				echo "</tr>";
			echo "</table>";
		break;


	} // switch role
} else { // if not logged in show centered login
//	echo "You must be logged in to continue.";
	echo "<div class = 'aptForm'>";
	echo "<div class = 'formTitle'>";
		echo "Please Log In";
	echo "</div>";
	formForm("{$htmlRoot}/proc/login.php","post");
//	echo "<span>User Name: &nbsp;&nbsp;</span>";
	formLabel("uname","User Name");
	formInput('uname','text'); //works
	clearfix();
	//echo "<span> Password: &nbsp;&nbsp;</span>";
	formLabel("pass","Password");
	formInput('pass','password'); //works
	clearfix();
	formInput('submit','submit','Log In','class = "loginButton"'); //works
	formClose();
	clearfix();
	echo "</div>";
}
?>
</div>
</div>


<?php
require("scripts.php");
?>
</body>
</html>


