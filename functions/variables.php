<?php 


		$PlaceName 		= trim(htmlentities(strip_tags($_GET['place_name'])));		#	ადგილის ნომრები
		$StartTime 		= trim(htmlentities(strip_tags($_GET['start_time'])));		#	დაწყების დრო
		$EndTime   		= trim(htmlentities(strip_tags($_GET['end_time'])));		#	დამთავრების დრო
		$Joystick   	= trim(htmlentities(strip_tags($_GET['joystick'])));		#	'ჯოისტიკების' რაოდენობა
		$ActionSlash   	= trim(htmlentities(strip_tags($_GET['action_slash'])));	#	'სლაშის' აქცია
		$SellingSlash 	= trim(htmlentities(strip_tags($_GET['selling_slash'])));	#	'სლაშის' ყიდვა ერთი ცალი 1.5 ლარი
		$SellingWater 	= trim(htmlentities(strip_tags($_GET['selling_water'])));	#	წყლის ყიდვა 0.5(ლ) 0.5 თეთრი (50 თეთრი)
		$Comment 		= trim(htmlentities(strip_tags($_GET['comment'])));			#	კომენტარი



		$OneHours 				= 60; 			#	ერთი საათი
		$SecondsInOneHour		= 3600;			# 	წამების რაოდენობა ერთ საათში
		$Money 					= 4;			# 	1 საათი = 4 ლარი
		$MoneyInMinutes 		= 15;			# 	15 წუთი = 1 ლარი
		$SlashPrice				= 1.5;			#	ერთი 'სლაშის' ფასი 1.5 ლარი
		$WaterPrice				= 0.5;			#	ერთი წყლის ფასი 0.5 ლარი
		$ThreeJoystickMoney 	= 1.5;			# 	3 'ჯოისტიკის' შემთხვევაში მრავლდება 1.5-ზე
		$FourJoystickMoney 		= 2;  			# 	4 'ჯოისტიკის' შემთხვევაში მრავლდება 2-ზე

		$StartTime 	= strtotime($StartTime);	#	Timestamp Format
		$EndTime 	= strtotime($EndTime);		#	Timestamp Format

		$ExpiredTime = $EndTime - time();		#	სათამაშო დროის თუ ნაკლები იქნება მიმდინარე დროზე დაბრუნდება შეტობინება "დრო ამოიწურა"


?>