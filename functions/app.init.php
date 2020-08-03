

<?php

  # 
  class GAME_TABLE 

  {


    private $db_connect;


    public function __construct($db_connect) 

    {
        $this->db_connect = $db_connect;
        $this->game = 'game';
    }


    public function getGameTableData() 

    {


        try {

                $sql = "SELECT * FROM `$this->game` ORDER BY end_time DESC LIMIT 20 ";

                $statement      = $this->db_connect->query($sql);
                $Count   = $statement->rowCount();

                if($Count > 0) 

                {

                	while ($DataRow = $statement -> fetch(PDO::FETCH_BOTH))

                	{  
                		$DataArray[]  = $DataRow;
                	}

                	return $DataArray;

                } else 

                {
                    $this->Message = "<i class='icon-info'></i> მონაცემები არ არის";
                }

        }  catch(PDOException $e) {
          
          die(" <font color='red'> <b> Connection Failed </b> </font> : " . 
            
            $e->getMessage() . '<br> <b> in File: </b>' . 
            $e->getFile() . ' <br> <b> in Line: </b> ' . 
            $e->getLine());
        }

            

        
    }



    public function getEarnedAmount()

    {
                

                $sql = "SELECT total_money, SUM(`total_money`) AS AllMoney FROM `$this->game` ";

                $statement      = $this->db_connect->query($sql);
                $Count   = $statement->rowCount();

                if($Count > 0) 

                {

                    while ($DataRow = $statement -> fetch(PDO::FETCH_BOTH))

                    {  
                        $this->TotalMoney = $DataRow['AllMoney'];
                        $DataArray[]  = $DataRow;
                    }

                    return $DataArray;

                } else 

                {
                    $this->Message = "<i class='icon-info'></i> მონაცემები არ არის";
                }
    }





    public function getHistory() 

    {

        try {

                $sql = "SELECT * FROM `$this->game` ORDER BY end_time DESC LIMIT 300 ";

                $statement      = $this->db_connect->query($sql);
                $Count   = $statement->rowCount();

                if($Count > 0) 

                {

                    while ($DataRow = $statement -> fetch(PDO::FETCH_BOTH))

                    {  
                        $DataArray[]  = $DataRow;
                    }

                    return $DataArray;

                } else 

                {
                    $this->Message = "<i class='icon-info'></i> მონაცემები არ არის";
                }

        }  catch(PDOException $e) {
          
          die(" <font color='red'> <b> Connection Failed </b> </font> : " . 
            
            $e->getMessage() . '<br> <b> in File: </b>' . 
            $e->getFile() . ' <br> <b> in Line: </b> ' . 
            $e->getLine());
        }
        
    }






    public function AmountInTotal()

    {
                
                $sql = "SELECT 
                                SUM(`money`)            AS AllMoney, 
                                SUM(`amount_in_total`)  AS AmountInTotal, 
                                SUM(`total_money`)      AS FullMoney,
                                SUM(`action_slash`)     AS ActionSlash,
                                SUM(`selling_slash`)    AS SellingSlash, 
                                SUM(`water_number`)     AS WaterNumber, 
                                SUM(`selling_water`)    AS SellingWater 
                                
                        FROM `$this->game` ";

                $statement      = $this->db_connect->query($sql);
                $Count   = $statement->rowCount();

                if($Count > 0) 

                {

                    while ($DataRow = $statement -> fetch(PDO::FETCH_BOTH))

                    {  
                        $this->TotalMoney       = round($DataRow['AllMoney']        ,   2);
                        $this->AmountInTotal    = round($DataRow['AmountInTotal']   ,   2);
                        $this->FullMoney        = round($DataRow['FullMoney']       ,   2);
                        $this->ActionSlash      = round($DataRow['ActionSlash']     ,   2);
                        $this->SellingSlash     = round($DataRow['SellingSlash']    ,   2);
                        $this->WaterNumber      = round($DataRow['WaterNumber']     ,   2);
                        $this->SellingWater     = round($DataRow['SellingWater']    ,   2);
                    }


                } else 

                {
                    $this->Message = "<i class='icon-info'></i> მონაცემები არ არის";
                }
    }








    public function GeneratedByAdministrators($UserID)

    {
                $this->ID = $UserID;

                $sql = "SELECT 
                                SUM(`money`)            AS AllMoney, 
                                SUM(`amount_in_total`)  AS AmountInTotal, 
                                SUM(`total_money`)      AS FullMoney,
                                SUM(`action_slash`)     AS ActionSlash,
                                SUM(`selling_slash`)    AS SellingSlash, 
                                SUM(`water_number`)     AS WaterNumber, 
                                SUM(`selling_water`)    AS SellingWater 
                                
                        FROM `$this->game`
                        WHERE `users_id` = :users_id ";

                $statement      = $this->db_connect->prepare($sql);
                $statement->execute(array('users_id' => $this->ID));
                $Count   = $statement->rowCount();

                if($Count > 0) 

                {

                    while ($DataRow = $statement -> fetch(PDO::FETCH_BOTH))

                    {  
                        $this->TotalMoney       = round($DataRow['AllMoney']        ,   2);
                        $this->AmountInTotal    = round($DataRow['AmountInTotal']   ,   2);
                        $this->FullMoney        = round($DataRow['FullMoney']       ,   2);
                        $this->ActionSlash      = round($DataRow['ActionSlash']     ,   2);
                        $this->SellingSlash     = round($DataRow['SellingSlash']    ,   2);
                        $this->WaterNumber      = round($DataRow['WaterNumber']     ,   2);
                        $this->SellingWater     = round($DataRow['SellingWater']    ,   2);
                    }


                } else 

                {
                    $this->Message = "<i class='icon-info'></i> მონაცემები არ არის";
                }
    }



  }

?>