<?php 

    class AddNewPlace {


        private $db_connect;

        public function __construct($db_connect) 
        {

            $this->db_connect = $db_connect;

        }


        public function NewPlace($PlaceName, $StartTime, $EndTime, $AmountPerHours, $AmountJoyStickPerHours, $TotalAmount, $ActionSlash, $SellingSlash, $BuySlash, $SellingWater, $BuyWater, $Comment, $Name, $UserID)

        {

            $this->PlaceName            = $PlaceName;
            $this->StartTime            = Date("Y-m-d H:i:s", $StartTime);
            $this->EndTime              = Date("Y-m-d H:i:s", $EndTime);

            $this->AmountPerHours       = $AmountPerHours;
            $this->TotalAmount          = $TotalAmount;
            $this->ActionSlash          = $ActionSlash;
            $this->AmountJoyStickPrice  = $AmountJoyStickPerHours;

            $this->SlashNumber          = $SellingSlash;
            $this->BuySlash             = $BuySlash;
            $this->WaterNumber          = $SellingWater;
            $this->BuyWater             = $BuyWater;

            $this->Comment              = $Comment;
            $this->Status               = "გადახდილია";

            $this->GamePlayingStatus    = "აქტიური";

            $this->UserName             = $Name;
            $this->UsersID              = $UserID;

            $this->game                 = "game"; // Table Name

            #  ბაზაში არსებული სახელები
            $FieldsName = array('place',  'start_time',  'end_time', 'money', 'amount_in_total', 'total_money', 'action_slash', 'slash_number', 'selling_slash', 'water_number', 'selling_water', 'payment_status', 'game_status', 'comment', 'users_name', 'users_id');

            # მონაცემთა ბაზაში გადასაცემი მნიშვნელობების სახელები
            $Value      = array(':place', ':start_time', ':end_time', ':money', ':amount_in_total', ':total_money', ':action_slash', ':slash_number', ':selling_slash', ':water_number', ':selling_water', ':payment_status', ':game_status', ':comment', ':users_name', ':users_id');

            # ამატებს მძიმეებს სახელებს შორის 
            $this->TableNames = implode(', ', $FieldsName);
            $this->ValueNames = implode(', ', $Value);

            
        try {

                $sql = "INSERT INTO `$this->game`($this->TableNames) VALUES ($this->ValueNames)";

                // Connect to Database
                $stmt = $this->db_connect->prepare($sql);

                // Param Variables
                $stmt->bindParam(':place',              $this->PlaceName,           PDO::PARAM_STR);
                $stmt->bindParam(':start_time',         $this->StartTime,           PDO::PARAM_STR);
                $stmt->bindParam(':end_time',           $this->EndTime,             PDO::PARAM_STR);

                $stmt->bindParam(':money',              $this->AmountPerHours,      PDO::PARAM_STR);
                $stmt->bindParam(':amount_in_total',    $this->AmountJoyStickPrice, PDO::PARAM_STR);
                $stmt->bindParam(':total_money',        $this->TotalAmount,         PDO::PARAM_STR);
                $stmt->bindParam(':action_slash',       $this->ActionSlash,         PDO::PARAM_STR);

                $stmt->bindParam(':slash_number',       $this->SlashNumber,         PDO::PARAM_STR);
                $stmt->bindParam(':selling_slash',      $this->BuySlash,            PDO::PARAM_STR);
                $stmt->bindParam(':water_number',       $this->WaterNumber,         PDO::PARAM_STR);
                $stmt->bindParam(':selling_water',      $this->BuyWater,            PDO::PARAM_STR);

                $stmt->bindParam(':payment_status',     $this->Status,              PDO::PARAM_STR);
                $stmt->bindParam(':game_status',        $this->GamePlayingStatus,   PDO::PARAM_STR);
                $stmt->bindParam(':comment',            $this->Comment,             PDO::PARAM_STR);


                $stmt->bindParam(':users_name',         $this->UserName,            PDO::PARAM_STR);
                $stmt->bindParam(':users_id',           $this->UsersID,             PDO::PARAM_STR);
 

                if($stmt->execute()) {

                    $this->success_message =  " დამატებულია ";
                        header("refresh: 3; table.php#Successfully-added-new-seating-place");
                }


            

            }   catch(PDOException $e) {
                    die("Connection Failed : " . 
                        
                        $e->getMessage() . '<br> <b> in File: </b>' . 
                        $e->getFile() . ' <br> <b> in Line: </b> ' . 
                        $e->getLine());
            }

    }





}




?>