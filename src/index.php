<?php 

require './../vendor/autoload.php';
//require './AfricanBikers/autoload.php';
 

use Exception;


use AfricanBikers\Pdf\Config;
use AfricanBikers\Numeri\Num2Words;
use AfricanBikers\Archive\ImportXls; 


use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\IOFactory as IOFactory;


error_reporting(E_ALL);

//conversione numeri in lettere
//echo(10);
//echo Num2Words::spell_my_int(10);


$xls = ($_FILES["file"]["tmp_name"]);

$reader = IOFactory::createReader('Xls');
$reader->setReadDataOnly(TRUE);
$spreadsheet = $reader->load($xls);


//$worksheet = $spreadsheet->getActiveSheet()->getCell('S9')->getCalculatedValue();
//echo($worksheet);
    for($i = 'B'; $i < 'U' ; $i++)      
      $cellValue[] = $spreadsheet->getActiveSheet()->getCell($i.$_POST["riga"])->getCalculatedValue();

    $amount = $spreadsheet->getActiveSheet()->getCell('S'.$_POST["riga"])->getCalculatedValue();  
    $amountWords = Num2Words::spell_my_int($amount);
    $float = (round($amount,2, PHP_ROUND_HALF_UP)-$amount)*100;

    $numberBill = $spreadsheet->getActiveSheet()->getCell('E'.$_POST["riga"])->getCalculatedValue();  

    $date = $spreadsheet->getActiveSheet()->getCell('B'.$_POST["riga"])->getCalculatedValue();  
    $date = Date::excelToDateTimeObject($date)->format('d/m/y');

    $CF = $spreadsheet->getActiveSheet()->getCell('V'.$_POST["riga"])->getCalculatedValue();  

    $address = $spreadsheet->getActiveSheet()->getCell('X'.$_POST["riga"])->getCalculatedValue();
    
    $city = $spreadsheet->getActiveSheet()->getCell('Y'.$_POST["riga"])->getCalculatedValue();
    $city .= " ";
    $city .= $spreadsheet->getActiveSheet()->getCell('Z'.$_POST["riga"])->getCalculatedValue();
      
    $type = $spreadsheet->getActiveSheet()->getCell('AA'.$_POST["riga"])->getCalculatedValue();
    

$html = <<<HTML

<!DOCTYPE html>
<html lang="en">
<head>
<style>

    *{
        font-family:Arial, Helvetica, sans-serif;
    }

    body{
        padding: 0 50px;
    }

	.logo img {
		width: 100px;
		margin-left: 20px;
	}

    .header {
        display:flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .text-header{
        text-align: right;
        letter-spacing: .5px;
        line-height: 1.5em;
        font-size: 20px;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        margin-right: 20px;
    }
    .line{
        margin: 0 20px;
    }

    .blu{
        color: #365f91;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        font-size: 24px;
        font-weight: 600;
    }
    .intester{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin: 20px ;
        font-size: 25px;
        font-weight: 600;
    }

    .description{
        font-size: 15px;
        margin: 0 20px;
        font-weight: 600;
    }

    .cost{
        text-align: center;
        font-size: 28px;
        font-weight: 600;
    }

    .userdata-table{
        margin-left: 40px;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    
    .userdata{

        display: flex;
        flex-direction: row;        
        
        width: max-content;

        margin-left: 40px;
        padding-right: 20px;        
        
    }

    .field{
        margin: 0 20px;
        
        padding-right: 20px;
        line-height: 30px;
    }

    .value{

        line-height: 30px;
        flex-basis: auto;

    }

    

    .paydata>.field>div,.value>div {

        margin: 0;
        line-height: 30px;
        
        padding: 0 25px;

    }

    .paydata>.field,.value {

        margin:0;
        padding-right: 0;

    }

    footer{
        display: flex;
        justify-content:space-between;
    }

</style>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
</head>
<body>
    <h1>$amountWords</h1>
    <div class="intester">

        <div class="blu">Anno Fiscale 2022</div>
        <div class="recu">Ricevuta n. $numberBill </div>
        
    </div>

    <div class="description">
        L&rsquo;Associazione Friends And Bikers O.N.L.U.S., nella persona
            del suo legale rappresentante dichiara di aver ricevuto quale
            erogazione liberale per l&rsquo;anno fiscale 2022 la somma di
    </div>
	
	<div class="cost">Euro $amount&euro; ($amountWords/$float)</div>
    
    <div class="userdata-table">
        <div>da:</div>
        
        <table>
      <tr>
        <td>Nominativo</td>
        <td>$cellValue[1]</td>
      </tr>
      <tr>
        <td>Indirizzo</td>
        <td>$address</td>
      </tr>
      <tr>
        <td>Cap, Comune e Provincia</td>
        <td>$city</td>
      </tr>
      <tr>
        <td>C.F. / P.I.</td>
        <td>$CF</td>
      </tr>
      
    </table>

    </div>


    <div class="description">
        a sostegno delle proprie attivit&agrave;
        statutarie secondo le modalit&agrave; e le destinazioni d&rsquo;uso
        riportate nella seguente tabella riepilogativa.
    </div>

    <hr>

    <p>L’Associazione Friends and Bikers onlus è un ente non commerciale ed è iscritta all’Anagrafe delle Onlus (Organizzazione non lucrativa di utilità sociale) ai sensi del D.Lgs 460/97. Per le persone fisiche, l’erogazione liberale è detraibile al 30% fino a € 30.000 (art.83 comma 1 del D.Lgs. 117/2017) o in alternativa è deducibile nel limite del 10% del reddito complessivo dichiarato (art.83 comma 2 del D.Lgs. 117/2017). Per gli enti e le società, l’erogazione liberale è deducibile nel limite del 10% del reddito complessivo dichiarato (art.83 comma 2 del D.Lgs. 117/2017).</p>
    
	<p>Si rammenta che è condizione di deducibilità o detraibilità delle donazioni l’erogazione delle stesse tramite banca, posta o altro sistema tracciabile previsto dalle norme.</per>

    <p>La nostra associazione emette la presente ricevuta che riporta gli estremi dei versamenti effettuati. Questo viene concepito come un servizio di garanzia fondamentale e necessario al fine di instaurare, con i propri donatori, un rapporto improntato alla correttezza e alla trasparenza.</p>

    <p> Per usufruire delle detrazioni previste dalla legge relativamente alle erogazioni liberali è necessario però conservare la ricevuta postale o bancaria della donazione effettuata, sola certificazione avente valore legale in quanto dimostrante la tracciabilità del movimento; per la donazione tramite bonifico bancario, carta di credito, carta prepag ata, paypal o assegno è sufficiente una copia dell’estratto conto che certifichi l’avvenuta donazione).</p>
    <hr>
    
    <!--fine pagina-->

    <p>Tabella riepilogativa delle erogazioni ricevute:</p>

    <div class="userdata-table">
                
        <div class="userdata paydata">
            <div class="field">
                <div>Data</div>
                <div>Importo</div>
                <div>Modalità</div>
                <div>Destinazione</div>
            </div>
            <div class="value">
                <div>$date</div>
                <div>$amount</div>
                <div>$type</div>
                <div>$cellValue[2]</div>
            </div>
        </div>
    </div>

      
        
    
    
    
    Francesco Maglione Presidente e Legale Rappresentante



    La presente ricevuta è esente da imposta di bollo ex art.82 comma 5 del D.Lgs.117/2017
    
    
    
    INFORMATIVA SULLA PRIVACY AI SENSI DEL D.LGS 196/2003 ART. 13
    
    E DELL’ART.13 GDPR 679/16 “REGOLAMENTO EUROPEO SULLA PROTEZIONE DEI DATI PERSONALI”
    
    Le comunichiamo che il titolare del trattamento dei suoi dati personali è Francesco Maglione (Legale Rappresentante Friends and Bikers Onlus). I suoi dati verranno trattati con la massima riservatezza attraverso l’utilizzo di strumenti elettronici e cartacei e non potranno essere ceduti a terzi o utilizzati per finalità diverse da quelle istituzionali. In qualsiasi momento Lei potrà esercitare i suoi diritti ed in particolare in qualunque momento di: ottenere la conferma dell'esistenza o meno dei medesimi dati e di conoscerne il contenuto e l'origine, verificarne l'esattezza o chiederne l'integrazione o l'aggiornamento, oppure la rettificazione (art. 7 del d.lgs. n. 196/2003). Ai sensi del medesimo articolo si ha il diritto di chiedere la cancellazione, la trasformazione in forma anonima o il blocco dei dati trattati in violazione di legge, nonché di opporsi in ogni caso, per motivi legittimi, al loro trattamento.
    
    
    Le richieste vanno rivolte a Friends and Bikers Onlus - Via Campegna 85 – 80124 Napoli.
    
    
    
</body>
</html>


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
//include './AfricanBikers/Pdf/Config.php';
$pdf = new Config(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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

$pdf->Output('example_001.pdf', 'I');