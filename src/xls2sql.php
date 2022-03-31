<?php

require './../vendor/autoload.php';

use AfricanBikers\Archive\ImportXls;

try {

    $conn =  ImportXls::getInstance('./settings.ini');
    
} 

catch (PDOException $th) {

    echo ('Error: '.$th->getMessage());

}

$link = $conn->getConn();

$resp = $link->query('SELECT * FROM donatori');

var_dump($resp->fetchAll());



#index
//foreach ($conn->query('SELECT * FROM `donatori`',PDO::FETCH_ASSOC) as $row) {
    //var_dump($row);
//}
echo("\n");

#show

//ImportXls::show(1);


