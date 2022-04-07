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
$resp->fetchAll();


#show
echo($conn->show(1));

#insert
try{
    var_dump($conn->insert('donatori',array('Manuel','della Gala','200','test')));
}
catch(PDOException $e){
    var_dump($e);
}

#update 
$conn->update('donatori',array('nome'=>'Gigi'),1);

#delete from
#$conn->delete('donatori',8);


