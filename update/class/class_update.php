<?php 

    class UPDATE {

        public $Email;
        public $time;

        private $IdentityID;
        private $db_connect;

        public function __construct($db_connect) 

        {

            $this->db_connect = $db_connect;
        }

        public function UpdateData($PlaceName, $StartTime, $EndTime, $AmountPerHours, $AmountJoyStickPerHours, $TotalAmount, $ActionSlash, $SellingSlash, $BuySlash, $SellingWater, $BuyWater, $Comment, $Name, $UserID, $ID)


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


            $this->ID                   = $ID;


            try {

                $sql = "UPDATE game 
                        SET 
                                place                       = :place,
                                start_time                  = :start_time,
                                end_time                    = :end_time,
                                money                       = :money,
                                amount_in_total             = :amount_in_total,
                                total_money                 = :total_money,
                                action_slash                = :action_slash,
                                slash_number                = :slash_number,
                                selling_slash               = :selling_slash,
                                water_number                = :water_number,
                                selling_water               = :selling_water,
                                payment_status              = :payment_status,
                                game_status                 = :game_status,
                                users_name                  = :users_name,
                                users_id                    = :users_id,
                                comment                     = :comment
                                WHERE   id                  = :id";

            $stmt = $this->db_connect -> prepare($sql);

            if($stmt -> execute([

                                'place'                     => $this->PlaceName,
                                'start_time'                => $this->StartTime,
                                'end_time'                  => $this->EndTime,
                                'money'                     => $this->AmountPerHours,
                                'amount_in_total'           => $this->AmountJoyStickPrice,
                                'total_money'               => $this->TotalAmount,
                                'action_slash'              => $this->ActionSlash,
                                'slash_number'              => $this->SlashNumber,  
                                'selling_slash'             => $this->BuySlash,  
                                'water_number'              => $this->WaterNumber,  
                                'selling_water'             => $this->BuyWater,  
                                'payment_status'            => $this->Status,  
                                'game_status'               => $this->GamePlayingStatus,  
                                'users_name'                => $this->UserName, 
                                'users_id'                  => $this->UsersID,  
                                'comment'                   => $this->Comment,
                                'id'                        => $this->ID  

                            ])) {
                                    
                $this->message =  "განახლებულია";
                    header("refresh: 3; ../table.php");
            }

        }   catch(PDOException $e) {
                die(" Connection Failed : " . $e->getMessage() . '<br> <b> in File: </b>' . $e->getFile() . ' <br> <b> in Line: </b> ' . $e->getLine());
        }
    }
}



?>