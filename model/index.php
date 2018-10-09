<?php

//include autoload.php file here
require_once 'dompdf/autoload.inc.php';

// Reference the dompdf namespase

Use Dompdf\Dompdf;

$dompdf = new Dompdf();
$html_header = 
$dompdf ->load_html('<h1 style = "text-align:center;">This is My First html to Pdf convertor</h1><hr><div class = "row"> <div style = "text-align:left">Date : <span id = "date">28/09/2018 </span></div><div style = "text-align:right">Exam Time : <span id = "exam_time">00:30:00</span></div> </div>');
$dompdf->setpaper('A4','portrait');
$dompdf->render();



// output the Generated pdf

$dompdf->stream('Tantransh Solutions', array('Attachment'=>0));   


?>