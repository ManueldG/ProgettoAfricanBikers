<?php

require './../vendor/autoload.php';

use AfricanBikers\Archive\ImportXls;



try {
    $conn = new  ImportXls('./settings.ini');
} 
catch (PDOException $th) {
    echo ('Error: '.$th->getMessage());
}

#index
//foreach ($conn->query('SELECT * FROM `donatori`',PDO::FETCH_ASSOC) as $row) {
    //var_dump($row);
//}
echo("\n");

#show

$id = 2;

$query = $conn->prepare("SELECT * FROM donatori WHERE id = :id");
$query->bindParam(':id',$id);
$query->execute();

$res = $query->fetchAll();

var_dump($res);


