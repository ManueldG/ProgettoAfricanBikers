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
class ImportXls {

    protected $conn;

    protected static $instance;

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

    public function getConn(){

        return $this->conn;

    }
    
        
    /**
     * __construct
     *
     * @param  string $file configration file
     *
     * @return void
     */

/*
     protected function __construct($dns, $username, $pass){       
       
        $this->link = new PDO($dns, $username, $pass);   
         
    }

    public static function getInstance($dns, $username, $pass):object{

        if (!self::$instance) {
            self::$instance = new static($dns, $username, $pass);
        } 

         return self::$instance;

    }

    public static function getConn($file = 'settings.ini'):object{

        if (!$settings = parse_ini_file($file, TRUE)) 
            throw new PDOException('Unable to open ' . $file . '.');
       
        $dns = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['schema'];        
       
        return self($dns,$settings['database']['username'],$settings['database']['password'])::$conn;
       
    }

*/

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

        $this->link
            ->prepare("SELECT *;")
            ->execute();           

    }

    public static function show(int $id):void{

        try{
        self::getConn('settings.ini');
        }
        catch(PDOException $e){
            var_dump($e);
        }

        $query = self::$conn->prepare("SELECT * FROM donatori WHERE id = :id");
        var_dump($query);
        $query->bindParam(':id',$id);
        $query->execute();

        $res = $query->fetchAll();

        var_dump($res);
    }

}

