<?php namespace AfricanBikers\Pdf;

use TCPDF;

use AfricanBikers\Numeri\Num2Words;

use PhpOffice\PhpSpreadsheet\Shared\Date;




require_once './../vendor/tecnickcom/tcpdf/config/tcpdf_config.php';
require_once './../vendor/tecnickcom/tcpdf/tcpdf.php';

/**
 * @author Manuel della Gala <manuel.dellagala@gmail.com>
 * 
 * 
 * 
 */
class Config extends TCPDF{

    function __construct($orientation, $unit, $format, $unicode, $encoding, $pdfa)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $pdfa);
        // set document information
    }

	/**
	 * 
	 */
	public function Header():void {
		// Logo
		$image_file = K_PATH_IMAGES.'logo.jpg';
		$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font

		
		
		// Title
		$this->SetFont('cid0jp', 'B', 10);
		$this->Cell(0, 10, "Friends and Bikers O.N.L.U.S. C.F.95213610637", 0, 2, 'R', 0, '', 0, false, 'A', 'T');
		$this->SetFont('helvetica', '', 10);
		$this->Cell(0, 10, "Via Campegna n.85 – 80124 Napoli", 0, 2, 'R', 0, '', 0, false, 'M', 'M');
		$this->SetFont('helvetica', 'regularB', 10);
		$this->Cell(0, 10, "www.friendsandbikers.org", 0, 2, 'R', 0, 'www.friendsandbikers.org', 0, false, 'M', 'M');
		$this->writeHTMLCell(0, 0, 10, '', "<hr>", 0, 1, 0, true, 'C', false);
		
	}

	public function Footer():void {
        // Position at 15 mm from bottom
        $this->SetY(-20);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
		$this->writeHTMLCell(0, 1, '', '', "<hr >", 0, 1, 0, true, 'L', false);
		
        $this->Cell(0, 10, 'Friends & Bikers Onlus / Attestazione di erogazione liberale', 0, false, 'L', 0, '', 0, false, 'T', 'M');

        $this->Cell(0, 10, '['.$this->getAliasNumPage().'/'.$this->getAliasNbPages().']', 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

	public static function Body(obj $spreadsheet):string{

		for($i = 'B'; $i < 'U' ; $i++)      
      		$cellValue[] = $spreadsheet->getActiveSheet()->getCell($i.$_POST["riga"])->getCalculatedValue();

		$amount = $spreadsheet->getActiveSheet()->getCell('S'.$_POST["riga"])->getCalculatedValue();  
		$amountWords = Num2Words::spell_my_int($amount);
		$float = (strlen((round($amount,2, PHP_ROUND_HALF_UP)-$amount)*100) == 1) ? ("0".(round($amount,2, PHP_ROUND_HALF_UP)-$amount)*100) : ((round($amount,2, PHP_ROUND_HALF_UP)-$amount)*100)   ;

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
				font-size: 14px;
			}

			body{
				padding: 0 50px;
			}

			.logo img {
				width: 100px;
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
			

			.field{
				
				border-right: 1px solid black;					
				
			}

			.space{
				
				border-left: 1px solid black;	
				width: 10px;				
				
			}


			.value>span{
				
				margin: 0 20px;					
				
			}

			.value{

				margin-left: 20px;						

			}

			.clear-fix::after{
				content:"";
				clear:both;
				display: table;

			}


			.table-donation{
				margin: 200px auto;
			}
			
			.privacy{
				margin: 40px auto;
				font-size: 10px;
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
					<div>da:

					</div>
					
					<table >
						<tr>
							<td class="field">
								<span>Nominativo</span> 
							</td>
							<td class="space"></td>
							<td class="value">
								<span>$cellValue[1]</span>
							</td>
						</tr>
						<tr>
							<td class="field">Indirizzo</td>
							<td class="space"></td>
							<td class="value">$address</td>
						</tr>
						<tr>
							<td class="field">Cap, Comune e Provincia</td>
							<td class="space"></td>
							<td class="value">$city</td>
						</tr>
						<tr>
							<td class="field">C.F. / P.I.</td>
							<td class="space"></td>
							<td class="value">$CF</td>
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
				
				<p>Si rammenta che è condizione di deducibilità o detraibilità delle donazioni l’erogazione delle stesse tramite banca, posta o altro sistema tracciabile previsto dalle norme.</p>

				<p>La nostra associazione emette la presente ricevuta che riporta gli estremi dei versamenti effettuati. Questo viene concepito come un servizio di garanzia fondamentale e necessario al fine di instaurare, con i propri donatori, un rapporto improntato alla correttezza e alla trasparenza.</p>

				<p> Per usufruire delle detrazioni previste dalla legge relativamente alle erogazioni liberali è necessario però conservare la ricevuta postale o bancaria della donazione effettuata, sola certificazione avente valore legale in quanto dimostrante la tracciabilità del movimento; per la donazione tramite bonifico bancario, carta di credito, carta prepag ata, paypal o assegno è sufficiente una copia dell’estratto conto che certifichi l’avvenuta donazione).</p>
				
				
				<!--fine pagina-->

				<p class="table-donation" margin="200 0">Tabella riepilogativa delle erogazioni ricevute:</p>

				
				
				<table>
						<tr>
							<th>
								Data:
							</th>
							<th>
								Importo:
							</th>
							<th>
								Modalità:
							</th>
							<th>
								Destinazione:
							</th>
						</tr>
						<tr>
							
							<td class="value">
								<span>$date</span>
							</td>
							<td class="value">$amount</td>
							<td class="value">$type</td>
							<td class="value">$cellValue[2]</td>
						</tr>
						
					</table>

					<table>
						<tr align="middle">
							<td valign="middle" align="center">
								<div></div>
								<div></div>
								
								<img align="middle" class="img" width="100px"  src="./img/recycle.jpg">
							</td>
							<td valign="middle" align="center">
								<div> </div>
								<img class="img" width="100px"  src="./img/thanks.jpg">
							</td>
							<td valign="middle" align="center">
								<div class="img">
									<div></div>
									<div >Francesco Maglione</div> 
									<div>Presidente e Legale Rappresentante</div>
									<img width="200px"  src="./img/sign.jpg">
								</div>
							</td>
						</tr>
					</table>

					
				<div class="privacy">La presente ricevuta è esente da imposta di bollo ex art.82 comma 5 del D.Lgs.117/2017
				
					<hr>
					
					<p>
						INFORMATIVA SULLA PRIVACY AI SENSI DEL D.LGS 196/2003 ART. 13
						
						E DELL’ART.13 GDPR 679/16 “REGOLAMENTO EUROPEO SULLA PROTEZIONE DEI DATI PERSONALI”
						
						Le comunichiamo che il titolare del trattamento dei suoi dati personali è Francesco Maglione (Legale Rappresentante Friends and Bikers Onlus). I suoi dati verranno trattati con la massima riservatezza attraverso l’utilizzo di strumenti elettronici e cartacei e non potranno essere ceduti a terzi o utilizzati per finalità diverse da quelle istituzionali. In qualsiasi momento Lei potrà esercitare i suoi diritti ed in particolare in qualunque momento di: ottenere la conferma dell'esistenza o meno dei medesimi dati e di conoscerne il contenuto e l'origine, verificarne l'esattezza o chiederne l'integrazione o l'aggiornamento, oppure la rettificazione (art. 7 del d.lgs. n. 196/2003). Ai sensi del medesimo articolo si ha il diritto di chiedere la cancellazione, la trasformazione in forma anonima o il blocco dei dati trattati in violazione di legge, nonché di opporsi in ogni caso, per motivi legittimi, al loro trattamento.
						
						
						Le richieste vanno rivolte a Friends and Bikers Onlus - Via Campegna 85 – 80124 Napoli.
					<p>

				</div>
				
				
				
			</body>
		</html>


		HTML;

		return $html;

	}
	

}


