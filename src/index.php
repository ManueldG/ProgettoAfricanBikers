<?php 

require './../vendor/autoload.php';
require './AfricanBikers/Archive/ImportXls.php';

use Exception;

use PHPMailer\PHPMailer\OAuth;

use PHPMailer\PHPMailer\PHPMailer;
use AfricanBikers\Archive\ImportXls;
use PHPMailer\PHPMailer\SMTP as SMTP;


use League\OAuth2\Client\Provider\Google;
//Alias the League Google OAuth2 provider class
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

/**
 * This example shows how to send via Google's Gmail servers using XOAUTH2 authentication
 * using the league/oauth2-client to provide the OAuth2 token.
 * To use a different OAuth2 library create a wrapper class that implements OAuthTokenProvider and
 * pass that wrapper class to PHPMailer::setOAuth().
 */

//Import PHPMailer classes into the global namespace


//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');


//Create a new PHPMailer instance
$mail = new PHPMailer();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
//SMTP::DEBUG_OFF = off (for production use)
//SMTP::DEBUG_CLIENT = client messages
//SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

//Set the SMTP port number:
// - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
// - 587 for SMTP+STARTTLS
$mail->Port = 465;

//Set the encryption mechanism to use:
// - SMTPS (implicit TLS on port 465) or
// - STARTTLS (explicit TLS on port 587)
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Set AuthType to use XOAUTH2
$mail->AuthType = 'XOAUTH2';

//Start Option 1: Use league/oauth2-client as OAuth2 token provider
//Fill in authentication details here
//Either the gmail account owner, or the user that gave consent
$email = 'manuel.dellagala@gmail.com';
$clientId = 'RANDOMCHARS-----duv1n2.apps.googleusercontent.com';
$clientSecret = 'RANDOMCHARS-----lGyjPcRtvP';

//Obtained by configuring and running get_oauth_token.php
//after setting up an app in Google Developer Console.
$refreshToken = 'RANDOMCHARS-----DWxgOvPT003r-yFUV49TQYag7_Aod7y0';

//Create a new OAuth2 provider instance
$provider = new Google(
    [
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
    ]
);

//Pass the OAuth provider instance to PHPMailer
$mail->setOAuth(
    new OAuth(
        [
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => $email,
        ]
    )
);
//End Option 1

//Option 2: Another OAuth library as OAuth2 token provider
//Set up the other oauth library as per its documentation
//Then create the wrapper class that implementations OAuthTokenProvider
 //$oauthTokenProvider = new MyOAuthTokenProvider(/* Email, ClientId, ClientSecret, etc. */);

//Pass the implementation of OAuthTokenProvider to PHPMailer
 //$mail->setOAuth($oauthTokenProvider);
//End Option 2

//Set who the message is to be sent from
//For gmail, this generally needs to be the same as the user you logged in as
$mail->setFrom($email, 'First Last');

//Set who the message is to be sent to
$mail->addAddress('manuel.dellagala@gmail.com', 'John Doe');

//Set the subject line
$mail->Subject = 'PHPMailer GMail XOAUTH2 SMTP test';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->CharSet = PHPMailer::CHARSET_UTF8;
$mail->msgHTML(file_get_contents('content.html'), __DIR__);

//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
 //$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}