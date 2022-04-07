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
     * createTable
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


    /**
     * insert
     * @param string $table table where insert data
     * @param array $arrData value to insert
     * @return bool true if successful, false if not
     */
    public function insert(string $table, array $arrData):bool{

        $request = $this->conn->prepare("INSERT INTO $table (id, nome, cognome, importo, descrizione) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($arrData as $key => &$value) {  
            $request->bindParam( ($key+1), $value);   
            echo (($key+1)." => ".$value."<br>");
        }
        

        return $request->execute();
    }

    /**
     * update
     * @param string $table table where insert data
     * @param array $arrData value to update
     * @return bool true if successful, false if not
     */
    public function update(string $table, array $arrData, int $id):bool{
        
        #UPDATE `donatori` SET `nome` = 'Manuel' WHERE `donatori`.`id` = 1; 
        //$request = $this->conn->prepare("UPDATE `$table` SET(id, nome, cognome, importo, descrizione) VALUES (NULL, , ?, ?, ?)");
          
        $sql = "UPDATE `$table` SET ";
        $request = $this->conn->prepare($sql);    

        foreach ($arrData as $key => &$value) {  
            
            $sql.= "`" . $key . "` = :" . $key;
            
        }

        $sql.= " WHERE `id` = :id";

        foreach ($arrData as $key => &$value) {  
            
            $request->bindParam( ":$key", $value,PDO::PARAM_STR); 
        }        

        $request->bindParam( ':id', $id,PDO::PARAM_INT); 
        
        return $request->execute();
    }

    /**
     * delete 
     * DELETE FROM `movies` WHERE `movie_id`  IN (20,21);
     * @param int $id
     * @return bool true if successful, false if not
     */
    public function delete(string $table, int $id):bool{

        $sql = "DELETE FROM $table WHERE `id` = :id;";
        $request = $this->conn->prepare($sql);
        $request->bindParam(':id',$id);
        
        return $request->execute();
        ;
    }

}

