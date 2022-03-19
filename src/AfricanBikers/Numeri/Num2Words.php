<?php namespace AfricanBikers\Numeri;

/*
	Convertitore di numeri interi in corrispettivi letterali.
	Esempio:	123 => centoventitrè
	Born:	10 Giugno 2012
	Licenza: GNU General Public License (versione 3 o successive)
	Autore: Valerio Bozzolan - Reyboz.it
*/


 class Num2Words{

    function __construct(){

    }

    /*
	Convertitore di numeri interi in corrispettivi letterali.
	Esempio:	123 => centoventitrè
	Born:	10 Giugno 2012
	Licenza: GNU General Public License (versione 3 o successive)
	Autore: Valerio Bozzolan - Reyboz.it
*/
public static function spell_my_int($num, $centOOttanta=false) {
	$num	= (int) $num;
	$mono	= array("", "uno", "due", "tre", "quattro", "cinque", "sei", "sette", "otto", "nove");
	$duplo	= array("dieci", "undici", "dodici", "{$mono[3]}dici", "quattordici", "quindici", "sedici", "dicias{$mono[7]}", "dici{$mono[8]}", "dician{$mono[9]}");
	$deca	= array("", $duplo[0], "venti", "{$mono[3]}nta", "quaranta", "cinquanta", "sessanta", "settanta", "ottanta", "novanta");
	$cento	= array("cent", "cento");
	$mili	= array(
		0 => array("", "mille", "milione", "miliardo", "bilione", "biliardo"),
		1 => array("", "mila", "milioni", "miliardi", "bilioni", "biliardi")
	);
	$max	= pow(10, count($mili[0]) * 3) - 1;
	if( !is_numeric($num) ) {
		return "Non &egrave; un numero!";
	} elseif ( $num < 0 ) {
		return "Numero negativo!";
	} elseif ( $num > $max ) {
		return "Limite superato!";
	} elseif( $num == 0 ) {
		return "zero";
	}
	$result	= "";
	$sezione	= 0;
	$num	= (string) $num;
	switch( strlen($num) % 3 ) {
		case 1:	$num	= "00$num";
			break;
		case 2:	$num	= "0$num";
	}
	$numlen	= strlen($num);
	while( ($sezione + 1) * 3 <= $numlen ) {
		$cifra	= substr($num, (($numlen - 1) - (($sezione + 1) * 3)) + 1, 3);
		$numero	= (int) $cifra;
		$cifra[0]	= (int) $cifra[0];
		$cifra[1]	= (int) $cifra[1];
		$cifra[2]	= (int) $cifra[2];
		if( $numero <> 0 ) { 
			$prime2cifre	= (int) ($cifra[1] . $cifra[2]);
			if( $prime2cifre < 10 ) {
				$text[2]	= $mono[$cifra[2]];
				$text[1]	= "";
			} elseif( $prime2cifre < 20 ) {
				$text[2]	= "";
				$text[1]	= $duplo[$prime2cifre - 10];
			} else {
				//	ventitre => ventitrè
				if( $sezione == 0 && $cifra[2] == 3 ) {
					$text[2]	= "tr&egrave;";
				} else {
					$text[2]	= $mono[$cifra[2]];
				}
				//	novantaotto => novantotto
				if( $cifra[2] == 1 || $cifra[2] == 8 ) {
					$text[1]	= substr($deca[$cifra[1]], 0, -1);
				} else {
					$text[1]	= $deca[$cifra[1]];
				}
			}
			if( $cifra[0] == 0 ) {
				$text[0]	= "";
			} else {
				//	centoottanta => centottanta
				if( !$centOOttanta && $cifra[1] == 8 || ($cifra[1] == 0 && $cifra[2] == 8) ) {
					$IDcent	= 0;
				} else {
					$IDcent	= 1;
				}
				if( $cifra[0] <> 1 ) {
					$text[0]	= $mono[$cifra[0]] . $cento[$IDcent];
				} else {
					$text[0]	= $cento[$IDcent];
				}
			}
			//	unomille	=> mille
			//	miliardo	=> unmiliardo
			if( $numero == 1 && $sezione <> 0 ) {
				if( $sezione >= 2 ) {
					$result	= "un" . $mili[0][$sezione] . $result;
				} else {
					$result	= $mili[0][$sezione] . $result;
				}
			} else {
				$result	= $text[0] . $text[1] . $text[2] . $mili[1][$sezione] . $result;
			}
		}
		$sezione++;
	}
	return $result;

 }

}
    
    
    