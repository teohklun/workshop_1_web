<?php 
//for download pdf

$file_url = 'http://localhost/test/public/report/filename.pdf';
header('Content-Type: application/pdf');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=mdpf.pdf"); 
readfile($file_url); // do the double-download-dance (dirty but worky)
return true;