<?php require_once '../../vendor/autoload.php' ?>
<?php include_once "../../defineData.php"; ?>
<?php
// make out pdf file by giving it corresponding properties

$stylesheet = file_get_contents('../assets/css/style.css');
$html = '
<html>
<head>
<style>
'.$stylesheet.'
</style>
</head>
<body>

'. $_POST['data'] .'
</body>
</html>
';
$mpdf = new \Mpdf\Mpdf([
	'margin_left' => 20,
	'margin_right' => 15,
	'margin_top' => 48,
	'margin_bottom' => 25,
	'margin_header' => 10,
	'margin_footer' => 10
]);
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle($_POST['title']);
$mpdf->SetAuthor($_POST['author']);
$mpdf->SetHeader('|'.$_POST['title'].'|{PAGENO}');
$mpdf->SetFooter('{PAGENO}');
$mpdf->SetWatermarkText(PROJECT_TITLE);
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);

ob_end_clean();

// $mpdf->Output('MyPDF.pdf', 'D');
$mpdf->Output('filename.pdf','F');
header('Content-type: application/json');
echo json_encode('tdsadsaest');
