<?php namespace AfricanBikers\Archive;

use PDO;
/**
 *  @param String $driver type of DB
 */

class ImportXls extends PDO{

    private $driver = '';
    private $host = '';
    private $port = '';
    private $user = '';
    private $pass = '';
    private $link = NULL;

    function __construct($driver,$host,$port,$user,$pass){

        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
        
    }

    public function connect(){
        $conn = new PDO("$this->driver:$this->host;port=$this->port",$this->user,$this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;

    }

    public function question($query){

        $this   ->connect()
                ->exec($query);

    }
    







}

