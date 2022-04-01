<?php

require './../vendor/autoload.php';

use AfricanBikers\Archive\ImportXls;

try {

    $conn =  ImportXls::getInstance('./settings.ini');
    
} 

catch (PDOException $th) {

    echo ('Error: '.$th->getMessage());

}

#index
$link = $conn->getConn();

$resp = $link->query('SELECT * FROM donatori');

var_dump($resp->fetchAll());

#show

var_dump($conn->show(1));
var_dump($conn->insert('donatori',array(1=>'Manuel','della Gala','200','donazione')));


