<?php 


	function FilterFields($PlaceName, $StartTime, $EndTime)

	{
		if(empty($PlaceName))

		{
			$x = "მიუთითეთ ადგილის ნომერი";
		} 

		else if(empty($StartTime))

		{
			$x = "მიუთითეთ დაწყების დრო";
		}

		else if(empty($EndTime))

		{
			$x = "მიუთითეთ დამთავრების დრო";
		}


		return $x;
	}





?>