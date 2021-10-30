<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$apt = $_GET['a'];
?>

<style type="text/css">
	
.isDisabled {
  color: currentColor;
  cursor: not-allowed;
  opacity: 0.5;
  text-decoration: none;
}


</style>

<link href="css/jquery.datepick.css" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.datepick.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"/></script>

<script>
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

function showDate(date) {
}
</script>



<?php
//nav.php
// Nik Rubenstein -- 11-26-2014
// Navigation bar, user dependant.


// clinic users menu
// New facility
// New patient
// view edit patients
// New appointment
// view / edit appointments
// switch facility

// admin menu
// new clinic
// new patient
//new interpreter
// new appointment
//view schedules
//edit patient
//edit interpreters
//edit clinics

//echo "<div class = 'nv'>";
echo "<div class = 'nav' id='updateAppointmentEditHistory'>";
echo "<center>";
if($_SESSION['logged']){
	echo "<a href = '{$htmlRoot}'> Home </a>";
}
switch($role){
	case 1: // sys admin
		echo "<a href = '{$htmlRoot}/editDepartments.php'> Departments </a>";
		echo "<a href = '{$htmlRoot}/inactiveClinics.php'> Inactive Clinics </a>";
		echo "<a href = '{$htmlRoot}/viewInterpreters.php'> Interpreter </a>";
		echo "<a href = '{$htmlRoot}/editLanguages.php'> Languages </a>";
		echo "<a href = '{$htmlRoot}/newClinic.php'> New Clinic </a>";
		
		echo "<a href = '{$htmlRoot}/newFacility.php'> New Facility </a>";
		
		echo "<a href = '{$htmlRoot}/viewClinics.php'> View Clinics </a>";
		echo "<a href = '{$htmlRoot}/viewFacilities.php'> View Facilities </a>";
		echo "<a href = '{$htmlRoot}/newPatient.php'> New Patient </a>";
		echo "<a href = '{$htmlRoot}/viewPatients.php'> View Patients </a>";
		echo "<a href = '{$htmlRoot}/newUser.php'> New User </a>";
		echo "<a href = '{$htmlRoot}/viewUsers.php'> View Users </a>";
		echo "<a href = '{$htmlRoot}/searchPatients.php'> New Appointment </a>";
		echo "<a href = '{$htmlRoot}/viewAppointments.php'> View Appointments </a>";
		
	break;
	case 2: // itasca staff
		echo "<a href = '{$htmlRoot}/editDepartments.php'> Departments </a>";
		echo "<a href = '{$htmlRoot}/inactiveClinics.php'> Inactive Clinics </a>";	
		echo "<a href = '{$htmlRoot}/viewInterpreters.php'> Interpreter </a>";	
		echo "<a href = '{$htmlRoot}/editLanguages.php'> Languages </a>";
		echo "<a href = '{$htmlRoot}/viewClinics.php'> View Clinics </a>";
		echo "<a href = '{$htmlRoot}/viewFacilities.php'> View Facilities </a>";
		echo "<a href = '{$htmlRoot}/newPatient.php'> New Patient </a>";
		echo "<a href = '{$htmlRoot}/viewPatients.php'> View Patients </a>";
		echo "<a href = '{$htmlRoot}/newUser.php'> New User </a>";
		echo "<a href = '{$htmlRoot}/viewUsers.php'> View Users </a>";
		echo "<a href = '{$htmlRoot}/searchPatients.php'> New Appointment </a>";
		echo "<a href = '{$htmlRoot}/viewAppointments.php'> View Appointments </a>";
		
	break;
	case 3: // clinic manager
	
		echo "<a href = '{$htmlRoot}/viewPatients.php'> View Patients </a>";
		echo "<a href = '{$htmlRoot}/searchPatients.php'> New Appointment </a>";
		//echo "<a href = '{$htmlRoot}/newAppointment.php'> New Appointment </a>";
		echo "<a href = '{$htmlRoot}/viewAppointments.php'> View Appointments </a>";
	break;
	
	case 4: // clinic staff
	
		 echo "<a href = '{$htmlRoot}/viewPatients.php'> View Patients </a>";
	
		echo "<a href = '{$htmlRoot}/viewAppointments.php'> View Appointments </a>";
	break;
	
	case 5:
		echo "<a href = '{$htmlRoot}/intProfile.php'> My Information </a>";
		echo "<a href = '{$htmlRoot}/intSchedule.php'> My Schedule </a>";
		echo "<a href = '{$htmlRoot}/intAppointments.php'> Available Appointments </a>";
		echo '<a href="files/Itasca-document.pdf" alt="doc download PDF" download>Download WOF</a>';
	break;

}
echo "</center>";
echo "</div>";
?>

<script type="text/javascript">
	var theUser = <?php echo "'".$_SESSION['uInfo']['uname']."'"; ?>;
	$("#updateAppointmentEditHistory").click(function(){
      $.ajax({
            type: "POST",
            data: {token:theUser,taskStatus:'0'},
            url: "serverPostUserStatus.php",
            success: function(data){              
            	 console.log(data);
                }
           });
     });
</script>
