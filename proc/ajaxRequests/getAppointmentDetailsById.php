<?php
    require_once("../../inc/init.php");

    if (!empty($_POST['jobId'])) {
        $results = mysql_query(
            'SELECT 
            ar.id as id,
            c.title as clinic,
            ar.apt_date as appointment_date,
            ar.asap,
            ar.duration,
            CASE WHEN ar.department != 0 THEN (SELECT title from departments WHERE id = ar.department) ELSE 0 END as department,
            ar.patient,
            CASE WHEN (ar.interpreter_req != "" AND ar.interpreter_req != "ANY") THEN (SELECT CONCAT(name_f, " ", name_l) from users WHERE id = ar.interpreter_req) ELSE "Any" END as interpreter_req,
            ar.interpreter_claim,
            CASE WHEN ar.interpreter_confirmed  != 0 THEN (SELECT CONCAT(name_f, " ", name_l) from users WHERE id = ar.interpreter_confirmed) ELSE "" END as interpreter_confirmed,
            ar.status,
            ar.requested_by,
            ar.date_requested,
            ar.interpreter_twilio_link
            FROM appointment_requests AS ar, clinics AS c
            WHERE c.id = ar.clinic
            AND
            ar.id = '.$_POST['jobId'].'
            limit 1'
        );

        if (!empty($results)) {
            $data = mysql_fetch_assoc($results);
           
            
            if (!empty($data['patient']) && $data['patient'] != 0) {
                $res = mysql_query('SELECT p.name_f, p.name_l, p.mrn, p.dob, p.gender, l.language, p.prefered_interpreter, p.addr_1, p.addr_2, p.addr_city, p.addr_state, p.addr_zip,p.phone, ip.title as insurance_provider, p.insurance_id FROM patients as p LEFT JOIN languages as l ON l.id = p.language LEFT JOIN insurance_providers as ip ON ip.id = p.insurance_provider WHERE p.id = '.$data['patient'].'');
                $res = mysql_fetch_assoc($res);
            }
            $data['date']=date('m  /  d  /  y', $data['appointment_date']);
            $data['time']=date('h  :  i  A', $data['appointment_date']);
            $data['date_request']=date('m  /  d  /  y', $data['date_requested']);
            $data['time_request']=date('h  :  i  A', $data['date_requested']);
            
            $data['name_f'] = !empty($res['name_f']) ? $res['name_f'] : '';
            $data['name_l'] = !empty($res['name_l']) ? $res['name_l'] : '';
            $data['mrn'] = !empty($res['mrn']) ? $res['mrn'] : '';
            $data['dob'] = !empty($res['dob']) ? $res['dob'] : '';
            $data['gender'] = !empty($res['gender']) ? $res['gender'] : '';
            $data['language'] = !empty($res['language']) ? $res['language'] : '';
            $data['prefered_interpreter'] = !empty($res['prefered_interpreter']) ? $res['prefered_interpreter'] : '';
            $data['addr_1'] = !empty($res['addr_1']) ? $res['addr_1'] : '';
            $data['addr_2'] = !empty($res['addr_2']) ? $res['addr_2'] : '';
            $data['addr_city'] = !empty($res['addr_city']) ? $res['addr_city'] : '';
            $data['addr_state'] = !empty($res['addr_state']) ? $res['addr_state'] : '';
            $data['addr_zip'] = !empty($res['addr_zip']) ? $res['addr_zip'] : '';
            $data['phone'] = !empty($res['phone']) ? $res['phone'] : '';
            $data['insurance_provider'] = !empty($res['insurance_provider']) ? $res['insurance_provider'] : '';
            $data['insurance_id'] = !empty($res['insurance_id']) ? $res['insurance_id'] : '';
        
            switch($data['status']) {
                case 1:
                    $status = 'NEW';
                break;
                case 2:
                    $status = 'PENDING';
                break;
                case 3:
                    $status = 'CONFIRMED';
                break;
                case 4:
                    $status = 'DENIED';
                break;
                case 5:
                    $status = 'CANCELLED';
                break;
                case 6:
                    $status = 'CANCEL REQUESTED';
                break;
                default : $status = 'other';
            }
            $data['status'] = $status;

            echo json_encode($data);
        } else {
            echo false;
        }
    } else {
        echo false;
    }
?>
