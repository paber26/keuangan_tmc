<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

$html = '
<html>
<head>
<style>
@page { size: A5 landscape; margin: 10px; }
@page a4_portrait { size: A4 portrait; margin: 10px; }
.page2 { page: a4_portrait; page-break-before: always; }
</style>
</head>
<body>
    <div>Page 1 (A5 landscape)</div>
    <div class="page2">Page 2 (A4 portrait)</div>
</body>
</html>
';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
file_put_contents('test.pdf', $dompdf->output());
echo "PDF created";
