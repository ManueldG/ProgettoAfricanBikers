<?php 

require './../vendor/autoload.php';
require './AfricanBikers/Archive/ImportXls.php';

use AfricanBikers\Archive\ImportXls;

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

$desc = $cellValue[3];
$name = $cellValue[0];
$surname = $cellValue[1];
$import = $cellValue[2];

//TODO mettere in setup
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

    echo "Ok";
    
  } catch(PDOException $e) {
    echo  "<br>" . $e->getMessage();
  }
  */
  
  // TODO end

//include './AfricanBikers/Pdf/Config.php';

error_reporting(E_ALL); // Genera un boundary 

var_dump($success = mail('manuel.dellagala@gmail.com', 'My Subject', "test"));

$mail_boundary = "=_NextPart_" . md5(uniqid(time())); 
$to = "manueldg@tiscali.it"; 
$subject = "Testing e-mail"; 
$sender = "manuel.dellagala@gmail.com"; 


$headers = "From: $sender\n"; 
$headers .= "MIME-Version: 1.0\n"; 
$headers .= "Content-Type: multipart/alternative;\n\tboundary=\"$mail_boundary\"\n";
$headers .= "X-Mailer: PHP " . phpversion(); // Corpi del messaggio nei due formati testo e HTML 

$text_msg = "$name $surname $import $desc"; 
$html_msg = "<b>messaggio</b> in formato <p><a href='http://www.aruba.it'>html</a><br><img src=\"http://hosting.aruba.it/image_top/top_01.gif\" border=\"0\">$name $surname $import $desc</p>";
  // Costruisci il corpo del messaggio da inviare 
  $msg = "This is a multi-part message in MIME format.\n\n"; 
  $msg .= "--$mail_boundary\n"; 
  $msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n"; 
  $msg .= "Content-Transfer-Encoding: 8bit\n\n"; 
  $msg .= "Questa è una e-Mail di test inviata dal servizio Hosting di Aruba.it per la verifica del corretto funzionamento di PHP mail()function. Aruba.it";
   // aggiungi il messaggio in formato text 
   $msg .= "\n--$mail_boundary\n"; 
   $msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\n"; 
   $msg .= "Content-Transfer-Encoding: 8bit\n\n"; 
   $msg .= "Questa è una e-Mail di test inviata dal servizio Hosting di Aruba.it per la verifica del corretto funzionamento di PHP mail()function. Aruba.it";
    // aggiungi il messaggio in formato HTML 
    // Boundary di terminazione multipart/alternative 
    $msg .= "\n--$mail_boundary--\n"; 
    // Imposta il Return-Path (funziona solo su hosting Windows) 
    ini_set("sendmail_from", $sender); 
    // Invia il messaggio, il quinto parametro "-f$sender" imposta il Return-Path su hosting Linux 
    if (mail($to, $subject, $msg, $headers, "-f$sender")) { 
      echo "Mail inviata correttamente!<br><br>Questo di seguito è il codice sorgente usato per l'invio della mail:<br><br>"; 
      highlight_file($_SERVER["SCRIPT_FILENAME"]); 
      unlink($_SERVER["SCRIPT_FILENAME"]); 
    } 
    else { 
      echo "<br><br>Recapito e-Mail fallito!"; 
    } 



