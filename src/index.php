<?php 

require './../vendor/autoload.php';
require './AfricanBikers/Archive/ImportXls.php';

use Exception;

use AfricanBikers\Archive\ImportXls;

use PhpOffice\PhpSpreadsheet\IOFactory as IOFactory;

error_reporting(E_ALL);
$xls = ($_FILES["file"]["tmp_name"]);

$reader = IOFactory::createReader('Xls');
$reader->setReadDataOnly(TRUE);
$spreadsheet = $reader->load($xls);

//$worksheet = $spreadsheet->getActiveSheet()->getCell('S9')->getCalculatedValue();
//echo($worksheet);
for($i="B"; $i<="U";$i++)
    $cellValue[] = $spreadsheet->getActiveSheet()->getCell($i.$_POST["riga"])->getCalculatedValue();

    

$html = <<<HTML
<h1 style="text-align:right">$cellValue[2]</h1>
<div>
    Donatore:$cellValue[1]
</div>

<div>
    Importo: $cellValue[16]
</div>

<div> 
   
</div>
HTML;

/*
$desc = $cellValue[3];
$name = $cellValue[0];
$surname = $cellValue[1];
$import = $cellValue[2];

//TODO mettere in setup

try {
    $import = new ImportXls();
    
    $import->question('CREATE DATABASE IF NOT EXISTS africanbikers;');
    $import->conn = null;
    //echo "Database created";
  } catch(PDOException $e) {
    echo  "<br>" . $e->getMessage();
  }
  
  $conn = null;

  try {
    $import = new ImportXls();
    $link = $import->conn;
    //$link->question('CREATE DATABASE IF NOT EXISTS africanbikers;');

    $import->question('USE africanbikers;');
    $import->createTable("donatori",["nome" => "CHAR(20)","cognome"=>"CHAR(20)","importo"=>"FLOAT","descrizione"=>"VARCHAR(255)"]);
       
    $link = null;

    echo "Table created";
  } catch(PDOException $e) {
    echo  "<br>" . $e->getMessage();
  }

  try {
    $import = new ImportXls();
    $link = $import->conn;
    //$link->question('CREATE DATABASE IF NOT EXISTS africanbikers;');

    $import->question('USE africanbikers;');
    $import->insert("donatori",["nome" => "Manuel","cognome"=>"della Gala","importo"=>1000,"descrizione"=>"sdafsadfnsalkndkanfdsad"]);
       
    $link = null;

    
    
  } catch(PDOException $e) {
    echo  "<br>" . $e->getMessage();
  }*/
  
  
  // TODO end
include './AfricanBikers/Pdf/Config.php';

