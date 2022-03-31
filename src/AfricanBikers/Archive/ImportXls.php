<?php namespace AfricanBikers\Archive;


use PDO;
use PDOStatement;
use PDOException;


/**
 * ImportXls
 * @author Manuel della Gala
 * 
 * 
 */
class ImportXls extends PDO {

    private $link = NULL;
    private $query = '';
    public $conn = NULL;
    
        
    /**
     * __construct
     *
     * @param  string $file configutation file
     *
     * @return void
     */
     function __construct($file = 'settings.ini'){
        
        if (!$settings = parse_ini_file($file, TRUE)) 
            throw new PDOException('Unable to open ' . $file . '.');
       
        $dns = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['schema'];
       
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);   
                
    }

    /**
     * @param string $table
     * @param array $data
     * @return void
     */
    
    public function createTable(string $table, array $data):void{
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


    /**
     * @param string $query 
     * @return obj $conn
     */
    public function question(string $query):object{

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

