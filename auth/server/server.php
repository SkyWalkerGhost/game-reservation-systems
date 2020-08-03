<?php

    class ADMINISTRATOR {

        private $email;
        private $password;
        private $Table;

        private $db_connect;


        public function __construct($db_connect) 

        {
            $this->db_connect = $db_connect;
        }


        public function getAdministratorSession() {


            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                if(isset($_POST['__auth'])) {

                    $this->Password = trim(strip_tags(htmlentities(filter_var($_POST['_2cMdaZcfeXafeDas']), FILTER_SANITIZE_STRIPPED)));

                    $this->Table  = "login"; // this is admins table name


                    try {


                        $sql = "SELECT * FROM `$this->Table` WHERE `pass` = :pass LIMIT 1 ";

                        $stmt = $this->db_connect -> prepare($sql);

                        $stmt->execute(array('pass' => $this->Password));
                        $Count = $stmt -> rowCount();

                    if($Count > 0 ) {

                         while($DataRow = $stmt -> fetch(PDO::FETCH_BOTH)) :

                                $this->AdministratorPassword    =   $DataRow["pass"];

                                $_SESSION["pass"] = $this->Password;  
                                    header("Location: ../index.php");


                            endwhile;

                        } else {

                            $this->Errors = "ანგარიში დაიბლოკა, შესვლა შეუძლებელია !";
                        }

                }   catch(PDOException $e) {

                    die("Connection Failed : " . 
                        $e->getMessage() . '<br> <b> in File: </b>' . 
                        $e->getFile() . ' <br> <b> in Line: </b> ' . 
                        $e->getLine());
                }




            }
        }
    }
}

?>