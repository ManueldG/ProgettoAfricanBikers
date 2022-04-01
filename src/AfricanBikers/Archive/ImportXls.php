<?php namespace AfricanBikers\Archive;

use PDO;
use PDOStatement;
use PDOException;

/**
 * ImportXls
 * @author Manuel della Gala 
 * 
 */
class ImportXls {

    protected $conn;
    protected static $instance;

    /** 
     * 
     * @param string $file
     * @return object $instance
     */    
    public static function getInstance(string $file){

        if (!self::$instance)
            self::$instance = new static($file);
        return self::$instance;

    }

    protected function __construct(string $file){

        if (!$settings = parse_ini_file($file, TRUE)) 
            throw new PDOException('Unable to open ' . $file . '.');

        $dns = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['schema'];  
        
        $this->conn = new PDO($dns, $settings['database']['username'], $settings['database']['password']);

    }



    /**
     * getConn() 
     * @return $conn
     */
    public function getConn(){

        return $this->conn;

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


    public function insert(string $table, array $arrData){

        $request = $this->conn->prepare('INSERT INTO $table VALUES (NULL, ?, ?, ?, ?)');

        foreach ($arrData as $key => $value) {  
            $request->bindParam($key, $value);   
        }

        $request->execute();

    }



    public function all(){

        $this->link
            ->prepare("SELECT *;")
            ->execute();           

    }

    public function show(int $id):array{

        $query = $this->conn->prepare("SELECT * FROM donatori WHERE id = :id");
        
        $query->bindParam(':id',$id);
        $query->execute();

        $res = $query->fetchAll();

        return $res;
    }

}

