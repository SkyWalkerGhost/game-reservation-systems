<?php 

    class Database_Connection {

        protected $server  = "localhost";
        protected $user    = "root";
        protected $password;
        protected $dbname  = "db_game";
        protected $charset = "utf8";
        public $DB_PDO_Connect;


        public function getConnect() {

            $this->DB_PDO_Connect = null;
        
        try {

                $dsn = "mysql:host=".$this->server.";dbname=".$this->dbname.";charset=".$this->charset;
                $pdo  = new PDO($dsn, $this->user, $this->password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch (PDOException $e) {
                    die("Connection Error : " . $e->getMessage()) ;
            }

        }
        
    }




?>