<?php
class DBconn{
    //db information
    private $DB_HOST = 'localhost';
    private $DB_USER = 'root';
    private $DB_PASS = 'root';
    private $DB_NAME = 'oop_php_webshop';
     
    protected function connect(){
        try{
            $dsn = 'mysql:host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME;
            $pdo = new PDO($dsn, $this->DB_USER, $this->DB_PASS);
            
            //setting default fetch mode
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            //setting errors for exceptions for try/catch
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
            //$pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
            return $pdo;
        }
        catch(PDOException $error){
            echo 'Connection error: ' . $error->getMessage();
        }
        finally{
            //$pdo = null;
        }
    }
}