$(document).ready(function() {

    $(document).on("click", ".view-job-details", function(){
        $('.loader').show();

        $.post(
            "/portal/proc/ajaxRequests/getAppointmentDetailsById.php",
            {
                jobId: this.id
            },
            function(data){
                var data = $.parseJSON(data);
                if (!$.isEmptyObject(data)) {
                    $('.idData').text(data.id);
                    $(".aptID:hidden").val(data.id);
                    $('.clinicData').text(data.clinic);
                   $('.appointmentDateData').text(data.date);
                    $('.appointmentTimeData').text(data.time);
                    $('.asapData').text(data.asap);
                    $('.durationData').text(data.duration);
                    $('.procedureData').text(data.department);
                    $('.patientFirstNameData').text(data.name_f);
                    $('.patientLastNameData').text(data.name_l);
                    $('.patientMrnData').text(data.mrn);
                    $('.patientDobData').text(data.dob);
                    $('.patientGenderData').text(data.gender);
                    $('.patientLanguageData').text(data.language);
                    $('.preferredInterpreterData').text(data.prefered_interpreter);
                    $('.address1Data').text(data.addr_1);
                    $('.address2Data').text(data.addr_2);
                    $('.cityData').text(data.addr_city);
                    $('.stateData').text(data.addr_state);
                    $('.zipData').text(data.addr_zip);
                     $('.phoneData').text(data.phone);

                    $('.insuranceData').text(data.insurance_provider);
                    $('.insuranceIdData').text(data.insurance_id);
                    $('.reqInterpreterData').text(data.interpreter_req);
                    $('.interpreterClaimData').text(data.interpreter_claim);
                    $('.confirmedInterpreterData').text(data.interpreter_confirmed);
                    $('.apptStatusData').text(data.status);
                    $('.requestedByData').text(data.requested_by);
                     $('.requestedDateData').text(data.date_request + ' ' +data.time_request);

                    $('.loader').hide();

                    $('.job-detail-dialog').dialog({
                        draggable: false,
                        modal: true,
                        maxWidth:600,
                        width: 600,
                        title: 'Viewing Appointment Number ' + data.id
                    });
                }
            }
        );
    });

    $(document).on("click", ".printWOF-btn", function(){
        $('form').attr('action', '/portal/printWOFPDF.php');
        $('form').attr('onsubmit', '');
        $('form').submit();
    });

    $(document).on("click", ".appointment-edit #submit", function(){
        $('form').attr('action', '/portal/proc/appointmentEditor.php');
        $('form').attr('onsubmit', 'return validateForm();');
        $('form').submit();
    });
});


//converts unix timestamp to date format - mm/dd/YY
function formatDate(inputDate, type) {
    var date = new Date(inputDate*1000);
    if (type == 1) {
        var months_arr = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        var year = date.getFullYear();
        var month = months_arr[date.getMonth()];
        var day = (date.getDate() < 10) ? '0' + date.getDate() : date.getDate();
        
        var convdataTime = month+'/'+day+'/'+year;
    } else {
        var hours = date.getHours();

        var format = 'AM';

        if (hours > 12) {
            hours -= 12;
            format = 'PM';
        } else if (hours === 0) {
           hours = 12;
        }

       hours = (hours < 10) ? '0'+hours : hours;
     
        var minutes = "0" + date.getUTCMinutes();

        var convdataTime = hours + ':' + minutes.substr(-2) + ' ' + format;
    }

    return convdataTime;
}
