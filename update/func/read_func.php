<?php 

	class ReadJobs {

		
		public $table				= "game";			// main table 

		private $db_connect;


		public function __construct($db_connect) {
			$this->db_connect = $db_connect;
		}


		public function getReadSingleJobs($ID) {

				$this->id 				= 	$ID;


		if(is_numeric($this->id) && !empty($this->id) && !is_array($this->id)) {


			try {

				// search url in main table
	    		$sql = "SELECT * FROM `$this->table` WHERE id = :id ";

	    		$stmt = $this->db_connect -> prepare($sql);

	    		$stmt->execute(array('id' => $this->id));
	    		
	    		while($read_jobs = $stmt -> fetch(PDO::FETCH_BOTH)) :

	    				$this->id 						= 	$read_jobs['id'];
	    				$this->place 					= 	$read_jobs['place'];
	    				$this->start_time 				= 	$read_jobs['start_time'];
	    				$this->end_time					= 	$read_jobs['end_time'];
	    				$this->money 					= 	$read_jobs['money'];
	    				$this->amount_in_total			= 	$read_jobs['amount_in_total'];
	    				$this->total_money				= 	$read_jobs['total_money'];
	    				$this->action_slash				= 	$read_jobs['action_slash'];
	    				$this->slash_number				= 	$read_jobs['slash_number'];
	    				$this->selling_slash			= 	$read_jobs['selling_slash'];
	    				$this->water_number				= 	$read_jobs['water_number'];
	    				$this->selling_water			= 	$read_jobs['selling_water'];
	    				$this->payment_status			= 	$read_jobs['payment_status'];
	    				$this->game_status 				= 	$read_jobs['game_status'];
	    				$this->comment 					= 	$read_jobs['comment'];
			
	    		endwhile;


			}  catch(PDOException $e) {
          
		          	die(" Connection Failed : " . 
		            
			            $e->getMessage() . '<br> <b> in File: </b>' . 
			            $e->getFile() . ' <br> <b> in Line: </b> ' . 
			            $e->getLine());
    		}

			

		} 
	}
}



?>