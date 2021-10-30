<?php
    require_once("inc/init.php");
    
   // require_once("{$htmlRoot}/tcpdf.php");

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';

    $results = mysql_query(
        'SELECT 
        ar.id,
        ar.apt_date as appointment_date,
        ar.clinic,
        ar.interpreter_confirmed,
        CASE WHEN ar.department != 0 THEN (SELECT title from departments WHERE id = ar.department) ELSE 0 END as department,
        ar.patient
        FROM appointment_requests AS ar, clinics AS c
        WHERE
        ar.id = '.$_GET['id'].'
        limit 1'
    );

    $data = array();
    if (!empty($results)) {
        $data = mysql_fetch_assoc($results);

        $patientInfo = array();
        if (!empty($data['patient']) && $data['patient'] != 0) {
            $res = mysql_query('SELECT p.name_f, p.name_l, p.addr_1, p.addr_2, p.addr_city, p.addr_state, p.addr_zip, ip.title as insurance_provider, p.phone, p.insurance_id, p.mrn, p.dob, p.gender FROM patients as p LEFT JOIN insurance_providers as ip ON ip.id = p.insurance_provider WHERE p.id = '.$data['patient'].'');
            $patientInfo = mysql_fetch_assoc($res);
        }

        $clinicInfo = array();
        if (!empty($data['clinic']) && $data['clinic'] != 0) {
            $res = mysql_query('SELECT title as clinic_name, addr_1 as clinic_address1, addr_2 as clinic_address2, addr_city as clinic_city, addr_state as clinic_state, addr_zip as clinic_zip, phone_1 as clinic_phone1, phone_2 as clinic_phone2 FROM clinics WHERE id = '.$data['clinic'].'');
            $clinicInfo = mysql_fetch_assoc($res);
        }

        $interpreterInfo = array();
        if (!empty($data['interpreter_confirmed']) && $data['interpreter_confirmed'] != 0) {
            $res = mysql_query('SELECT CONCAT(u.name_f, " ", u.name_l) as interpreter_name, i.roster_number, l.language as interpreter_language FROM users AS u JOIN interpreters AS i ON i.id = u.id LEFT JOIN languages as l ON l.id = i.language_1 WHERE u.id = '.$data['interpreter_confirmed'].'');
            $interpreterInfo = mysql_fetch_assoc($res);
        }
    }
?>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        <style type="text/css">
            @page {
                margin-left: 1.8em;
                margin-bottom: 2cm;
                margin-top: 2cm;
            }
            p {margin: 0; padding: 0;}
            .ft01{font-size:16px;font-family:Helvetica;color:#000000;font-weight: bold;}
            .ft04{font-size:15px;font-family:Helvetica;color:#000000;font-weight: bold;}
            .ft02{font-size:14px;font-family:Helvetica;color:#000000;font-weight: bold;}
            .ft010{font-size:11px;font-family:Helvetica;color:#000000;font-weight: bold;}
            .ft09{font-size:19px;font-family:Helvetica;color:#000000;font-weight: bold;}
            .ft012{font-size:22px;font-family:Helvetica;color:#000000;font-weight: bold;}
            .ft011{font-size:17px;font-family:Helvetica;color:#000000;font-weight: bold;}
            .ft07{font-size:13px;font-family:Helvetica;color:#000000;font-weight: bold;}
            .ft016{font-size:14px;line-height:21px;font-family:Helvetica;color:#000000;font-weight: bold;}
            .ft015{font-size:15px;font-family:Helvetica;color:#c0c0c0;font-weight: bold;}
        </style>
    </head>

    <body bgcolor="#FFFFFF" vlink="blue" link="blue">
        <div id="page1-div" style="position:relative;width:918px;height:1188px;">
            <img width="918" height="1188" src="<?php echo $protocol.$_SERVER['HTTP_HOST']. '/portal/img/pdf.png'; ?>" alt="background image"/>
            
            <p style="position:absolute;top:34px;left:535px;white-space:nowrap" class="ft01">
                <i><b>APPOINTMENT ID#</b></i>
                <div style="border-bottom: 1px solid;width: 100px;top: 34px;left: 688px;position: absolute;text-align: center;" class="ft01">
                    <b><?php
                        echo $data['id'];
                    ?></b>
                </div>
            </p>
            
            <p style="position:absolute;top:78px;left:511px;white-space:nowrap" class="ft01">
                <b>Itasca Staff Only:</b>
            </p>
            
            <p style="position:absolute;top:100px;left:511px;white-space:nowrap" class="ft016">
                <b>REJECTED: </b>No Billable Insur.___ &#160;Unable to verify___
            </p>

            <p style="position:absolute;top:122px;left:511px;white-space:nowrap" class="ft016">
                Too Old ___ &#160;Not Enough Info ___ &#160;No Signature ___
            </p>
            
            <p style="position:absolute;top:178px;left:135px;white-space:nowrap" class="ft04">
                <b>&#160; UCARE&#160; &#160;&#160;</b>
            </p>

            <p style="position:absolute;top:178px;left:261px;white-space:nowrap" class="ft04">
                <b>&#160; HEALTHPARTNERS&#160; &#160; &#160; &#160;</b>
            </p>

            <p style="position:absolute;top:178px;left:481px;white-space:nowrap" class="ft04">
                <b>&#160;MA&#160; &#160;&#160;</b>
            </p>

            <p style="position:absolute;top:178px;left:568px;white-space:nowrap" class="ft04">
                <b>&#160; &#160; BLUEPLUS&#160; &#160; &#160; &#160;</b>
            </p>

            <p style="position:absolute;top:178px;left:702px;white-space:nowrap" class="ft04">
                <b>&#160; &#160;OTHERS_____</b>
            </p>

            <p style="position:absolute;top:227px;left:54px;white-space:nowrap" class="ft012"><b>Appointment Date:</b></p>

            <p style="position:absolute;top:231px;left:255px;white-space:nowrap;border-bottom:1px solid;font-size:15px;" class="ft04">
                <span style="padding-left:5px;padding-right:5px;"><b>
                    <?php
                        echo date('m  /  d  /  y', $data['appointment_date']);
                    ?>
                </b></span>
            </p>

            <p style="position:absolute;top:227px;left:467px;white-space:nowrap" class="ft012"><b>Appointment Time:</b></p>

            <p style="position:absolute;top:231px;left:670px;white-space:nowrap;border-bottom:1px solid;font-size:15px;" class="ft04">
                <span style="padding-left:5px;padding-right:5px;"><b>
                    <?php
                        echo date('h  :  i  A', $data['appointment_date']);
                    ?>
                </b></span>
            </p>

            <p style="position:absolute;top:300px;left:54px;white-space:nowrap" class="ft011"><b>Patient Information</b></p>

            <p style="position:absolute;top:336px;left:54px;white-space:nowrap" class="ft04"><b>[Name]</b>
                <?php
                    $patientName = array();
                    $patientName[] = !empty($patientInfo['name_f']) ? $patientInfo['name_f'] : '';
                    $patientName[] = !empty($patientInfo['name_l']) ? $patientInfo['name_l'] : '';
                    echo implode(' ', array_filter($patientName));
                ?>
            </p>

            <p style="position:absolute;top:377px;left:54px;white-space:nowrap" class="ft04"><b>[Address]</b>
                <?php
                    $address = array();
                    $address[] = !empty($patientInfo['addr_1']) ? $patientInfo['addr_1'] : '';
                    $address[] = !empty($patientInfo['addr_2']) ? $patientInfo['addr_2'] : '';
                    echo implode(' / ', array_filter($address));
                ?>
            </p>

            <p style="position:absolute;top:417px;left:54px;white-space:nowrap" class="ft04"><b>[City / State / Zip]</b>
                <?php
                    $addressDetail = array();
                    $addressDetail[] = !empty($patientInfo['addr_city']) ? $patientInfo['addr_city'] : '';
                    $addressDetail[] = !empty($patientInfo['addr_state']) ? $patientInfo['addr_state'] : '';
                    $addressDetail[] = !empty($patientInfo['addr_zip']) ? $patientInfo['addr_zip'] : '';
                    echo implode(' / ', array_filter($addressDetail));
                ?>
            </p>

            <p style="position:absolute;top:458px;left:54px;white-space:nowrap" class="ft04"><b>[Phone Number]</b>
                <?php
                    echo !empty($patientInfo['phone']) ? $patientInfo['phone'] : '';
                ?>
            </p>

            <p style="position:absolute;top:498px;left:54px;white-space:nowrap" class="ft04"><b>[Insurance ID Number / MRN]</b>
                <?php
                    $mrn = array();
                    $mrn[] = !empty($patientInfo['insurance_id']) ? $patientInfo['insurance_id'] : '';
                    $mrn[] = !empty($patientInfo['mrn']) ? $patientInfo['mrn'] : '';
                    echo implode(' / ', array_filter($mrn));
                ?>
            </p>

            <p style="position:absolute;top:539px;left:54px;white-space:nowrap" class="ft04"><b>[Date of Birth / Gender]</b>
                <?php
                    $dob = array();
                    $dob[] = !empty($patientInfo['dob']) ? $patientInfo['dob'] : '';
                    $dob[] = !empty($patientInfo['gender']) ? $patientInfo['gender'] : '';
                    echo implode(' / ', array_filter($dob));
                ?>
            </p>

            <p style="position:absolute;top:576px;left:54px;white-space:nowrap" class="ft04"><b>[Interpreter Performance]</b></p>

            <p style="position:absolute;top:574px;left:258px;white-space:nowrap" class="ft04"><b>Satisfied</b></p>

            <p style="position:absolute;top:574px;left:351px;white-space:nowrap" class="ft04"><b>Not Satisfied</b></p>

            <p style="position:absolute;top:300px;left:477px;white-space:nowrap" class="ft011"><b>Facility Information</b></p>

            <p style="position:absolute;top:336px;left:477px;white-space:nowrap" class="ft04"><b>[Name]</b>
                <?php
                    echo !empty($clinicInfo['clinic_name']) ? $clinicInfo['clinic_name'] : '';
                ?>
            </p>

            <p style="position:absolute;top:377px;left:477px;white-space:nowrap" class="ft04"><b>[Address]</b>
                <?php
                    $address = array();
                    $address[] = !empty($clinicInfo['clinic_address1']) ? $clinicInfo['clinic_address1'] : '';
                    $address[] = !empty($clinicInfo['clinic_address2']) ? $clinicInfo['clinic_address2'] : '';
                    echo implode(' , ', array_filter($address));
                ?>
            </p>

            <p style="position:absolute;top:417px;left:477px;white-space:nowrap" class="ft04"><b>[City / State / Zip]</b>
                <?php
                    $addressDetail = array();
                    $addressDetail[] = !empty($clinicInfo['clinic_city']) ? $clinicInfo['clinic_city'] : '';
                    $addressDetail[] = !empty($clinicInfo['clinic_state']) ? $clinicInfo['clinic_state'] : '';
                    $addressDetail[] = !empty($clinicInfo['clinic_zip']) ? $clinicInfo['clinic_zip'] : '';
                    echo implode(' / ', array_filter($addressDetail));
                ?>
            </p>

            <p style="position:absolute;top:458px;left:477px;white-space:nowrap" class="ft04"><b>[Phone Number]</b>
                <?php
                    $phone = array();
                    $phone[] = !empty($clinicInfo['clinic_phone1']) ? $clinicInfo['clinic_phone1'] : '';
                    $phone[] = !empty($clinicInfo['clinic_phone2']) ? $clinicInfo['clinic_phone2'] : '';
                    echo implode(' / ', array_filter($phone));
                ?>
            </p>

            <p style="position:absolute;top:498px;left:477px;white-space:nowrap" class="ft04"><b>[Practitioner Name]</b></p>

            <p style="position:absolute;top:539px;left:477px;white-space:nowrap" class="ft04"><b>[Dept or Procedure]</b>
                <?php
                    echo !empty($data['department']) ? $data['department'] : '';
                ?>
            </p>

            <p style="position:absolute;top:576px;left:479px;white-space:nowrap" class="ft04"><b>[Responsible Party]</b></p>
            
            <p style="top:610px; position:absolute; left:128px;" class="ft011"><b>*WOF must be submitted within 30 days from date of service without penalty.</b></p>
        
            <p style="position:absolute;top:650px;left:368px;white-space:nowrap" class="ft011"><b>Interpreter Information</b></p>

            <p style="position:absolute;top:684px;left:70px;white-space:nowrap" class="ft011"><b>Name:</b>
                <?php
                    $name = array();
                    $name = array_filter(explode(' ', $interpreterInfo['interpreter_name']));
                    $name = array_combine(range(0, count($name)-1), array_values($name));
                ?>
                <div style="top:684px; position:absolute; left:128px;width:12%;" class="ft04">
                    <?php echo !empty($name[0]) ? $name[0] : ''; ?>
                </div>

                <div style="top:684px; position:absolute; left:292px;width:12%;" class="ft04">
                    <?php echo !empty($name[1]) ? $name[1] : ''; ?>
                </div>

                <div style="top:684px; position:absolute; left:500px;width:12%;" class="ft04">
                    <?php echo !empty($name[2]) ? $name[2] : ''; ?>
                </div>

                <div style="top:684px; position:absolute; left:722px;width:12%;" class="ft04">
                    <?php echo !empty($interpreterInfo['interpreter_language']) ? $interpreterInfo['interpreter_language'] : ''; ?>
                </div>
            </p>

            <p style="position:absolute;top:704px;left:124px;white-space:nowrap" class="ft011"><b>First</b></p>

            <p style="position:absolute;top:704px;left:286px;white-space:nowrap" class="ft011"><b>Middle</b></p>

            <p style="position:absolute;top:704px;left:502px;white-space:nowrap" class="ft011"><b>Last</b></p>

            <p style="position:absolute;top:704px;left:718px;white-space:nowrap" class="ft011"><b>Language</b></p>

            <p style="position:absolute;top:788px;left:157px;white-space:nowrap" class="ft011"><b>Interpreter Signature</b></p>

            <p style="position:absolute;top:788px;left:477px;white-space:nowrap" class="ft011"><b>MN Roster ID#</b></p>

            <p style="position:absolute;top:750px;left:502px;white-space:nowrap" class="ft04">
                <?php echo !empty($interpreterInfo['roster_number']) ? $interpreterInfo['roster_number'] : ''; ?>
            </p>

            <p style="position:absolute;top:788px;left:714px;white-space:nowrap" class="ft011"><b>Date</b></p>

            <p style="position:absolute;top:827px;left:56px;white-space:nowrap" class="ft011"><b>To be Completed by Clinic/Support Staff ONLY</b></p>

            <p style="position:absolute;top:830px;left:440px;white-space:nowrap" class="ft01"><b>Type of Service:</b></p>

            <p style="position:absolute;top:830px;left:600px;white-space:nowrap" class="ft01"><b>Clinical</b></p>

            <p style="position:absolute;top:830px;left:694px;white-space:nowrap" class="ft01"><b>Home Visit</b></p>

            <p style="position:absolute;top:830px;left:804px;white-space:nowrap" class="ft01"><b>Other</b></p>

            <p style="position:absolute;top:857px;left:112px;white-space:nowrap" class="ft01"><b>Pharmacy visit</b></p>

            <p style="position:absolute;top:857px;left:426px;white-space:nowrap" class="ft01"><b>No Show/Cancel</b></p>

            <p style="position:absolute;top:857px;left:622px;white-space:nowrap" class="ft01"><b>Satisfied</b></p>

            <p style="position:absolute;top:886px;left:112px;white-space:nowrap" class="ft01"><b>Patient present Staff initial</b></p>

            <p style="position:absolute;top:886px;left:427px;white-space:nowrap" class="ft01"><b>Conference Call</b></p>

            <p style="position:absolute;top:886px;left:623px;white-space:nowrap" class="ft01"><b>Not Satisfied</b></p>

            <p style="position:absolute;top:890px;left:724px;white-space:nowrap" class="ft010"><b>(Comment section below)</b></p>

            <p style="position:absolute;top:938px;left:70px;white-space:nowrap" class="ft09"><b>Arrival Time:</b></p>

            <p style="position:absolute;top:944px;left:290px;white-space:nowrap" class="ft04"><b>AM / PM</b></p>
            
            <p style="position:absolute;top:938px;left:372px;white-space:nowrap" class="ft09"><b>Start Time:</b></p>
            <p style="position:absolute;top:938px;left:597px;white-space:nowrap" class="ft09"><b>End Time:</b></p>
            <p style="position:absolute;top:944px;left:793px;white-space:nowrap" class="ft04"><b>AM / PM</b></p>
            
            <p style="position:absolute;top:980px;left:72px;font-size:13px;" class="ft01"><b>By signing this form you are hereby authorizing Itasca to provide this service and the above form is complete and correct.</b></p>

            <p style="position:absolute;top:1032px;left:117px;white-space:nowrap" class="ft01"><b>Clinic Staff Signature</b></p>

            <p style="position:absolute;top:1032px;left:455px;white-space:nowrap" class="ft01"><b>Date</b></p>

            <p style="position:absolute;top:1032px;left:670px;white-space:nowrap" class="ft01"><b>Printed Name</b></p>

            <p style="position:absolute;top:1068px;left:66px;white-space:nowrap" class="ft011"><b>Comments:&#160;</b></p>

            <p style="position:absolute;top:1130px;left:258px;white-space:nowrap" class="ft04">475 Etna Street / Suite 01 / St. Paul / MN / 55106</p>

            <p style="position:absolute;top:1148px;left:296px;white-space:nowrap" class="ft04">Telephone: (651)457-7400 / FAX: (651)457-7700</p>

            <p style="position:absolute;top:1162px;left:74px;white-space:nowrap" class="ft07">©2021 Itasca Corporation</p>
            
            <p style="position:absolute;top:1162px;left:810px;white-space:nowrap" class="ft07">02/21</p>

            <p style="position:absolute;top:1162px;left:395px;white-space:nowrap" class="ft04">www.itascacorp.biz</p>
        </div>
    </body>
</html>
