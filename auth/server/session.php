<?php 

    class Admin {

        private $a_name;
        private $AdministratorEmail;
    
        
        private $table                  = "login";       // admin's table


        private $db_connect;    // connect to database

        public function __construct($db_connect) {

                $this->db_connect = $db_connect;

        }


        public function getAdminSession($AdministratorEmail) {

            $this->AdminEmail = $AdministratorEmail;

            $sql = "SELECT * FROM `$this->table`  WHERE pass = :pass LIMIT 1 ";

            $statement = $this->db_connect->prepare($sql);

            $statement->execute(array('pass' => $this->AdminEmail));
            $count = $statement->rowCount();

        if($count == 0) {
                
                header("location: ../login.php"); 

            } else {


                while($Row = $statement -> fetch(PDO::FETCH_BOTH)) :
            
                    $this->Name             = $Row['name'];
                    $this->UserID           = $Row['user_id'];
                    
                    
                endwhile;
            
        }

        return null;
    }
}



?>