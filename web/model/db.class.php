<?php
class DB {
    private static $instance = null;
    private $registry;
    private $connexion = null;

    public static function getInstance($arg) {
        if (!self::$instance instanceof self) {
            self::$instance = new self($arg);
        }
        return self::$instance;
    }

    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
    
    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }
    
    private function __construct($registry) {
        $this->registry = $registry;
        try
        {
            $this->connexion = new PDO(DB_TYPE.":host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
        }catch(PDOException $e)
        {
            print "Error new PDO: ".$e->getMessage()."<br/>";
            die();
        }
    }
  }