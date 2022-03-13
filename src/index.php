<?php 

require './../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory as IOFactory;


error_reporting(E_ALL);
$xls = ($_FILES["file"]["tmp_name"]);

$reader = IOFactory::createReader('Xls');
$reader->setReadDataOnly(TRUE);
$spreadsheet = $reader->load($xls);

$worksheet = $spreadsheet->getActiveSheet();

for($i="B"; $i<="E";$i++)
    $cellValue[] = $spreadsheet->getActiveSheet()->getCell($i.$_POST["riga"])->getValue();

 

$html = <<<HTML
<h1 style="text-align:right">$cellValue[3]</h1>
<div>
    Donatore: $cellValue[0] $cellValue[1]
</div>

<div>
    Importo: $cellValue[2]
</div>

<div>
   
</div>
    

HTML;

include './AfricanBikers/Pdf/Config.php';




