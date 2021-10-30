<?php
    require_once "vendor/dompdf/dompdf_config.inc.php";

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
    
    if (strpos($url,'itascainterpreter_dev') !== false) {
        $path = '/itascainterpreter_dev';

    }
    if (!empty($_POST['aptID'])) {
        $dompdf = new DOMPDF();
        $dompdf->set_paper("A4", "portrait");

        $html = file_get_contents($protocol.$_SERVER['HTTP_HOST'].'/portal/WofPdfLayout.php?id='.$_POST['aptID'].'');
        $dompdf->load_html($html);
        $dompdf->render();

        $dompdf->stream("Current Itasca WOF.pdf");
    }

    if (!empty($_REQUEST['appointment_id'])) {
        $dompdf = new DOMPDF();
        $dompdf->set_paper("A4", "portrait");

        $html = file_get_contents($protocol.$_SERVER['HTTP_HOST'].$path.'/portal/WofPdfLayout.php?id='.$_REQUEST['appointment_id'].'');
        $dompdf->load_html($html);
        $dompdf->render();

        $dompdf->stream("Current Itasca WOF.pdf");
    }
?>
