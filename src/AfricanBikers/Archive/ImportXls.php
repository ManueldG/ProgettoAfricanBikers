<?php namespace AfricanBikers\Archive;


use PDO;


/**
 * ImportXls
 * @author Manuel della Gala
 * 
 */
class ImportXls extends PDO {

    // TODO mettere in config
    private $driver = 'mysql';
    private $host = 'localhost';
    private $port = '3306';
    private $user = 'root';
    private $pass = 'root';
    // TODO end

    private $link = NULL;
    private $query = '';
    public $conn = NULL;
    
        
    /**
     * __construct
     *
     * @param  string $driver
     * @param  string $host
     * @param  int $port
     * @param  string $user
     * @param  string $pass
     * @return void
     */
    function __construct(){

        $conn = new PDO("$this->driver:$this->host;port=$this->port",$this->user,$this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn = $conn;
                
    }

    
    public function createTable(string $table,$data){
        $sql = "CREATE TABLE IF NOT EXISTS $table(
            id BIGINT NOT NULL AUTO_INCREMENT ,";

        foreach($data as $key=>$value){
            
            $sql .= " $key $value,";

        }
        //CREATE TABLE `africanbikers`.`xxx` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `nome` VARCHAR(10) NULL , `cognome` VARCHAR(10) NULL , `importo` FLOAT NULL , PRIMARY KEY (`id`)); 
        $sql .= " PRIMARY KEY (`id`));";
        echo($sql);
        $this->conn->query($sql);

        /*
         * CREATE TABLE `africanbikers`.`xxx` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `nome` VARCHAR(10) NULL , `cognome` VARCHAR(10) NULL , `importo` FLOAT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; 
         */
            
            
    }

    public function question($query){

        $this->conn->query($query); 

        //$this->query ='';

        return $this->conn;
                                     

    }

    public function where(String $argA, String $argB, String $comparison="="):object{
        
        $this->query.=" WHERE $argA $comparison $argB ";

        return $this;                                     

    }

    public function insert(string $table, array $arrData){

        $sqlFirst = "INSERT INTO donatori(";
        $sqlSecond = "VALUE(";
        foreach($arrData as $key => $value){

            $sqlFirst .= " $key,";
            $sqlSecond .= "'$value',";

        }

        $sqlFirst = substr($sqlFirst, 0, -1);  
        $sqlSecond = substr($sqlSecond, 0, -1);      
        
        
            echo ("* $sqlFirst) $sqlSecond);*");
            $this->question(" $sqlFirst) $sqlSecond);");
    }



    public function all(){

        $this->conn
            ->prepare("SELECT *;")
            ->execute();           

    }

    







}

