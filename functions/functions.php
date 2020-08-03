<?php 


		// სათამაშო დროის გაგება წამებში
		function RemainingTime($start, $end) 

		{	
				# 	დამთავრების დროს გამოვაკლოთ დაწყების დრო, ვღებულობთ წამების რაოდენობას
				$RemainingTime = $end - $start;

			return $RemainingTime;

		}





		// სათამაშო წუთების გაგება
		function RemainingMinutes($RemainingTime, $OneHours)

		{
				# 	წამების რაოდენობა გავყოთ ერთი საათის რაოდენობაზე მაგ: 3600 / 60, ვღებულობთ დარჩენილი წუთების რაოდენობას
				$NumberofMinutes = $RemainingTime / $OneHours;

			return $NumberofMinutes;
		}





		// სათამაშო საათების გაგება
		function RemainingHours($RemainingTime, $SecondsInOneHour)

		{
				# წამების რაოდენობას ვყოფთ ერთი საათის წამების რაოდენობაზე, ვღებულობთ საათების რაოდენობას
				$RemainingHours = $RemainingTime / $SecondsInOneHour;

			return $RemainingHours;
		}





		// რამდენის გადახდა უწევს საათების მიხედვით
		function AmountPerHours($PlaceName, $NumberofMinutes, $MoneyInMinutes)

		{	
			
				# 	ვგებულობთ რამდენის გადახდა უწევს ნათამაშები წუთების რაოდენობის მიხედვით
				#	მიღებული შედეგი მრგვალდება მეტობით უახლოეს მთელ რიცხვამდე

				for($i = 1; $i <= 10; $i++)
				{
					if($PlaceName == $i)

					{	
						#	სტანდარტულ შემთხვევაში ერთი საათის ღირებულება არის 4 ლარი
						$AmountPerHours = round(($NumberofMinutes / $MoneyInMinutes), 2) . ' ₾';
					
					}	else if($PlaceName == "VIP" || $PlaceName == "VIP2")

					{	
						#	VIP შემთხვევაში ერთი საათის ღირებულება არის 8 ლარი
						$AmountPerHours = ($NumberofMinutes / $MoneyInMinutes);
						$AmountPerHours = round($AmountPerHours * 2, 2) . ' ₾';
					}
				}


			return $AmountPerHours;
		}





		// რამდენის გადახდა მოუწევს ერთ საათში, ორ საათში და ა.შ. წუთებს ვყოფთ ერთი ლარის წუთების რაოდენობაზე
		// ვანგარიშობთ 'ჯოისტიკების' რაოდენობის მიხედვით თახნსი დამატებას
		// 2 'ჯოისტიკი' ფასი 4 ლარი
		// 3 'ჯოისტიკი' მრავლდება 1.5(ლ)-ზე
		// 4 'ჯოისტიკი' მრავლდება 2(ლ)-ზე
		function AmountJoyStickPerHours($PlaceName, $NumberofMinutes, $MoneyInMinutes, $Joystick, $ThreeJoystickMoney, $FourJoystickMoney)

		{	
			for($i = 1; $i <= 10; $i++)
			
			{
				if($PlaceName == $i && $Joystick == 2)

				{
						# 	ვგებულობთ რამდენის გადახდა უწევს ნათამაშები წუთების რაოდენობის მიხედვით
						#	მიღებული შედეგი მრგვალდება მეტობით უახლოეს მთელ რიცხვამდე
						$TotalAmount = round(($NumberofMinutes / $MoneyInMinutes), 2) . ' ₾';

				}	else if($PlaceName == $i && $Joystick == 3)

				{	
					#	ვანგარიშობთ 3 'ჯოისტიკის' ფასს
					$ThreePrice = ($NumberofMinutes / $MoneyInMinutes);
					$TotalAmount = round($ThreePrice * $ThreeJoystickMoney, 2) . ' ₾';
				

				} else if($PlaceName == $i && $Joystick == 4)

				{
					#	ვანგარიშობთ 4 'ჯოისტიკის' ფასს
					$FourPrice = ($NumberofMinutes / $MoneyInMinutes);
					$TotalAmount = round($FourPrice * $FourJoystickMoney, 2) . ' ₾';
				

				}	else if($PlaceName == "VIP" && $Joystick == 2)

				{
					#	ვანგარიშობთ VIP-ში 2 'ჯოისტიკის' ფასს
					#	VIP ერთი საათის ფასი 8 ლარი
					$VipPrice = ($NumberofMinutes / $MoneyInMinutes);
					$TotalAmount = round($VipPrice * 2, 2) . ' ₾';


				}	else if($PlaceName == "VIP" || $PlaceName == "VIP2" && $Joystick == 3 && $Joystick == 4)

				{
					#	ვანგარიშობთ VIP-ში 2 'ჯოისტიკის' ფასს
					$Three_FourVipPrice = ($NumberofMinutes / $MoneyInMinutes);
					$FullPrice = $Three_FourVipPrice * 2;
					$TotalAmount = round($FullPrice * $ThreeJoystickMoney, 2) . ' ₾';
				}
			}

				return $TotalAmount;
		}









		//	მაგიდების ნომრები და მათი მიხედვით ფასების განსაზღვრება 
		function SeatingArea($PlaceName)

		{		
				# თუ დასაჯდომი ადგილები იქნება 1-დან 10-ის ჩათვლით ფასაი განისაზღვროს 4 ლარით
				# თუ დასაჯდომი ადგილები იქნება VIP ან VIP2 ადგილი ფასი განისაზღვროს 8 ლარით
				
				for($i = 1; $i <= 10; $i++)
				{
					if($PlaceName == $i)

					{
						$PlacePrice = 4;
					
					}	else if($PlaceName == "VIP" || $PlaceName == "VIP2")

					{
						$PlacePrice = 8;
					}
				}

			return $PlacePrice;
		}



		#	შეძენილი 'სლაშის თანხა'
		function SellingSlash($slash, $SlashPrice)

		{	
				#	ერთი 'სლაში' = 1.5ლ
				$buy_slash  =  round($slash * $SlashPrice, 2) . ' ₾';

			return $buy_slash;
		}





		#	შეძენილი წყლის თანხა'
		function SellingWater($water, $WaterPrice)

		{	
				#	ერთი ბოთლი წყალი = 0.5ლ
				$buy_slash  =  round($water * $WaterPrice, 2) . ' ₾';

			return $buy_slash;
		}





		#	დავითვალოთ თანხა ჯამურად საათები რაოდენობა, 'ჯოისტიკების' რაოდენობა, 'სლაშის' რაოდენობა, წყლის რაოდენობა.
		function TotalAmount($AmountJoyStickPerHours, $BuySlash, $BuyWater)

		{		
				#	ყველა თანხის შეკრება და მთლიანად ჩვენება
				$TotalPrice = round($AmountJoyStickPerHours +  $BuySlash + $BuyWater, 2) . ' ₾';

			return $TotalPrice;
		}

		

?>







