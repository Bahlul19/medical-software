<?php
//scripts.php
// Nik Rubenstein -- 11-26-2014
// javascripts etc to place before body close
?>
<script>

/////////////////////
// Facility Switch //
/////////////////////
function facilitySwitch($str){


	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("currentFacility").innerHTML=xmlhttp.responseText;
		} else {
			alert(xmlhttp.readyState+" -- "+xmlhttp.status);
		}
	}
	xmlhttp.open("GET","proc/facilitySwitch.php?q="+$str,true);
	xmlhttp.send();
	
	

}


///////////////////////////////////////////////////
// Clinic Switch (must change facility list too) //
///////////////////////////////////////////////////
function clinicSwitch($str){

	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("currentClinic").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","/portal/proc/clinicSwitch.php?q="+$str,true);
	xmlhttp.send();
	
	//alert("happened");
}

function clinFacSwitch($str){
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("facilitySwitch").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","/portal/proc/clinFacSwitch.php?q="+$str,true);
	xmlhttp.send();
}

function patientParse($str){
	$str = $str.replace("  "," ");
//	alert($str);
	var $chunks = $str.split(" ");
	var $chLength = $chunks.length;
	//alert($chLength);
	var $id = $chunks[0];
	/* $sql = "SELECT prefered_interpreter FROM patients WHERE id = '{$id}'";
	$go = mysql_query($sql);
	$row = mysql_fetch_assoc($go);
	$prefInt = $row['prefered_interpreter']; */
	if($chLength == 5){
		var $name_f = $chunks[1];
		var $name_l = $chunks[2];
		var $dob = $chunks[3];
		var $lang = $chunks[4];
		//var $phone = $chunks[5];
	} else if($chLength == 6) {
		var $name_fa = $chunks[1];
		var $name_fb = $chunks[2];
		var $name_f = $name_fa+" "+$name_fb;
		var $name_l = $chunks[3];
		var $dob = $chunks[4];
		var $lang = $chunks[5];
		//var $phone = $chunks[5];	
	} else if($chLength == 7) {
		var $name_fa = $chunks[1];
		var $name_fb = $chunks[2];
		var $name_fc = $chunks[3];
		var $name_f = $name_fa+" "+$name_fb+" "+$name_fc;
		var $name_l = $chunks[4];
		var $dob = $chunks[5];
		var $lang = $chunks[6];
		//var $phone = $chunks[5];	
	} else if($chLength == 8) {
		var $name_fa = $chunks[1];
		var $name_fb = $chunks[2];
		var $name_fc = $chunks[3];
		var $name_fd = $chunks[4];
		var $name_f = $name_fa+" "+$name_fb+" "+$name_fc+" "+$name_fd;
		var $name_l = $chunks[5];
		var $dob = $chunks[6];
		var $lang = $chunks[7];
		//var $phone = $chunks[5];	
	}
	
	
	document.getElementById("patData").innerHTML="<label> Patient ID </label><input type = 'text' name = 'patId' value = '"+$id+"'><div class = clearfix></div><label> Patient First Name </label><input type = 'text' name = 'patFName' value = '"+$name_f+"'><div class = clearfix></div><label>Patient Last Name</label><input type = 'text' name = 'patLName' value = '"+$name_l+"'><div class = clearfix></div><label>Patient Date Of Birth</label><input type = 'text' name= 'patDOB' value = '"+$dob+"'><div class = clearfix></div><label> Language</label><input type = 'text' name = 'language' value = '"+$lang+"'><div class = clearfix></div>";
	//<label>Patient Phone Number</label><input type='text' name = 'patPhone' value = '"+$phone+"'>";
	
//	document.getElementById("remove").innerHTML='';
}


</script>

<script>

//basic ajax stuff for php here.
function showUser(str) {
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","getuser.php?q="+str,true);
  xmlhttp.send();
}
</script>


<script>
function specLanguage(){
	var $specify = document.getElementById("inputLanguage").value;
	alert("test-"+$specify);
	/*
	if($specify == 'other'){
		document.getElementById("newLanguage").innerHTML="<label for 'newLanguage' style = 'color:#009900;'> Please Specify A Language </label> <label style = 'color:#009900;'> In The Comments Section </label>";
	} else {
		document.getElementById("newLanguage").innerHTML="";
	}*/
	
}

</script>






<script>
function facSwitch($str,$words) {
	if (window.XMLHttpRequest) {
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("myBox").innerHTML=xmlhttp.responseText;
		} 
	}
	xmlhttp.open("GET","/portal/proc/facilitySwitch.php?q="+$str+"&w="+$words,true);
	xmlhttp.send();
}



</script>

<script>

$(function() {
	$(".autoInterp").autocomplete({
		source: "proc/autofillInterp.php",
		minLength: 1
	});				
});

//autocomplete Patient
$(function() {
	//autocomplete Interpreter requested
	$(".autoPatient").autocomplete({
		source: "proc/autofillPatient.php",
		minLength: 1
	});				
});

</script>

<script>

function copyToClipboard() {
  	/* Get the text field */
  	var copyText = document.getElementById("video-conference-link");
	if (copyText.value !== '') {
		/* Select the text field */
		copyText.select();
		copyText.setSelectionRange(0, 99999); /*For mobile devices*/

		/* Copy the text inside the text field */
		document.execCommand("copy");

		/* Alert the copied text */
		alert('The Video link has been copied');
	} else {
		alert('Video Link not available');
	}
}

$(document).ready(function() {
	$('#get-appointment-submit').click(function () {
		$('#join-url').hide();
		$.post(
			'/portal/proc/ajaxRequests/getAppointmentDetailsById.php',
			{
				jobId: $('#appointment-id').val()
			},
			function(data){
				var data = $.parseJSON(data);
				if (!$.isEmptyObject(data)) {
					if (data.id) {
						if (data.interpreter_twilio_link) {
							var url = data.interpreter_twilio_link;
							var joineeName = url.match(/name=([^&]+)/)[1];
							var userName = encodeURI(data.requested_by);
							var newUrl = url.replace(joineeName, userName);
							$('#video-conference-link').val(newUrl);
							$('#join-url').attr('href', newUrl).show();
						}
					} else {
						$('#video-conference-link').val('');
						alert('Appointment not found');
					}
				}
			}
		);
	});
});
</script>

