<?php 

require './../vendor/autoload.php';
//require './AfricanBikers/autoload.php';
 

use AfricanBikers\Pdf\Config;
use AfricanBikers\Numeri\Num2Words;
use AfricanBikers\Archive\ImportXls; 

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\IOFactory as IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

error_reporting(E_ALL);

$xls = ($_FILES["file"]["tmp_name"]);

$reader = IOFactory::createReader('Xls');

$reader->setReadDataOnly(TRUE);

try {
  /** Load $inputFileName to a Spreadsheet Object  **/
  $spreadsheet = $reader->load($xls);
} catch(Exception $e) {
  echo('Error loading file: '.$e->getMessage());
}

/*


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
//include './AfricanBikers/Pdf/Config.php';

$pdf = new Config(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$html = Config::Body($spreadsheet);
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Manuel della Gala');
$pdf->setTitle('Ricevuta');
$pdf->setSubject('Donazione');
$pdf->setKeywords('PDF, Donazioni');


// set default header data
$pdf->setHeaderData("./img/logo.jpg", 30, 'Ricevuta', 'Manuel della Gala', array(0,64,255), array(0,64,128));

$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, 32, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(50);
$pdf->setFooterMargin(70);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, 30);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/ita.php')) {
  require_once(dirname(__FILE__).'/lang/ita.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->setFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print


// Print text using writeHTMLCell()


$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
try{

  $pdf->Output('example_001.pdf', 'I');
  throw new Exception("Errore!");

}

catch(Exception $e){

  var_dump($e);

}
