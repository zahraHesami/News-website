<?php

namespace database;



use PDO;
use PDOException;

class DataBase {
    private $connection;
    private $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ,PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8');

    private $dbHost = DB_HOST;
    private $dbName = DB_NAME;

    private $userName = DB_USERNAME;

    private  $password =DB_PASSWORd;
     function __construct()
     {
         try {
             $this->connection = new PDO ("mysql:host=$this->dbHost;dbname=$this->dbName", $this->userName, $this->password, $this->options);
              
         }
         catch (PDOException $e) {
             echo $e->getMessage();
             exit;
         }
     }
     public function select($sql, $values = null)
    {
        try{
            $stmt = $this->connection->prepare($sql);
            if($values === null)
            {
                $stmt->execute();
            }
            else
            {
                $stmt->execute($values);
            }
            $result = $stmt;
            return $result;
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }

    }
     
       public function insert($tableName,$fields,$values)
       {
           try {
               $stmt = $this->connection->prepare("INSERT INTO ". $tableName ."(".implode(', ',$fields)." ,created_at)
                VALUES ( :".implode(', :',$fields) ." ,NOW() );");
               $stmt->execute(array_combine($fields,$values));
              return true;

           }
           catch (PDOException $e) {
               echo $e->getMessage();
               return false;
           }

       }
       function update($tableName,$id,$fields,$values)
       {
        $sql = "UPDATE " . $tableName . " SET";
        foreach(array_combine($fields, $values) as $field => $value)
        {
            if($value)
            {
                $sql .= " `" . $field . "` = ? ,";
            }
            else{
                $sql .= " `" . $field . "` = NULL ,";

            }
        }

        $sql .= " updated_at = now()";
        $sql .= " WHERE id = ?";
        try{
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_merge(array_filter(array_values($values)), [$id]));
            return true;
        }

        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
       }

    public function delete($tableName, $id)
    {
        $sql = "DELETE FROM " . $tableName . " WHERE id = ? ;";
        try{
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            return true;
        }

        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
       public function createTable($sql)
       {
           try
           {
               $this->connection->exec($sql);
               return true;

           }
           catch (PDOException $e)
           {
               echo $e->getMessage();
               return false;
           }
       }

}