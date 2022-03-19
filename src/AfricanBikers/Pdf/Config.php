<?php namespace AfricanBikers\Pdf;

use TCPDF;


require_once './../vendor/tecnickcom/tcpdf/config/tcpdf_config.php';
require_once './../vendor/tecnickcom/tcpdf/tcpdf.php';

class Config extends TCPDF{

    function __construct($orientation, $unit, $format, $unicode, $encoding, $pdfa)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $pdfa);
        // set document information
    }

	public function Header() {
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
		$this->writeHTMLCell(0, 0, 10, '', "<hr >", 0, 1, 0, true, 'C', false);
		
	}

	public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
		$this->writeHTMLCell(0, 1, '', '', "<hr >", 0, 1, 0, true, 'L', false);
		
        $this->Cell(0, 10, 'Friends & Bikers Onlus / Attestazione di erogazione liberale', 0, false, 'L', 0, '', 0, false, 'T', 'M');

        $this->Cell(0, 10, '['.$this->getAliasNumPage().'/'.$this->getAliasNbPages().']', 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }


}


