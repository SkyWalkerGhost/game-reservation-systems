<?php 
	

	session_start();

    if(!isset($_SESSION["pass"])) {  

        header("Location: ../auth/login.php");  
    }

    $AdministratorEmail = $_SESSION["pass"];



	ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
    ini_set ('log_errors', 0);
    ini_set ('display_startup_errors', 0);
    ini_set ('error_reporting', E_ALL);
    // Report simple running errors
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    // Report all errors except E_NOTICE
    error_reporting(E_ALL & ~E_NOTICE);

    require_once "../db/db.php";       # კონფიგურაციის ფაილი, ბაზასთან დაკავშირება

    $pdo_config = new Database_Connection();
    $db_connect = $pdo_config->getConnect();


    require_once "../functions/app.init.php";

    $GameDataClass = new GAME_TABLE($db_connect);
    $GameData = $GameDataClass->getGameTableData();


    require_once "../auth/server/session.php";

    // ადმინისტრატორის სახელი
    $AdminClass   = new Admin($db_connect);
    $AdminClass->getAdminSession($AdministratorEmail);
   	$Name 	= $AdminClass->Name;
   	$UserID = $AdminClass->UserID;


   	$ID = (int)$_GET['ID'];
   	require_once "func/read_func.php";

   	$ReadData   = new ReadJobs($db_connect);
    $ReadData->getReadSingleJobs($ID);

	if(isset($_POST['add'])) 

	{



		$PlaceName 		= trim(htmlentities(strip_tags($_POST['place_name'])));		#	ადგილის ნომრები
		$StartTime 		= trim(htmlentities(strip_tags($_POST['start_time'])));		#	დაწყების დრო
		$EndTime   		= trim(htmlentities(strip_tags($_POST['end_time'])));		#	დამთავრების დრო
		$Joystick   	= trim(htmlentities(strip_tags($_POST['joystick'])));		#	'ჯოისტიკების' რაოდენობა
		$ActionSlash   	= trim(htmlentities(strip_tags($_POST['action_slash'])));	#	'სლაშის' აქცია
		$SellingSlash 	= trim(htmlentities(strip_tags($_POST['selling_slash'])));	#	'სლაშის' ყიდვა ერთი ცალი 1.5 ლარი
		$SellingWater 	= trim(htmlentities(strip_tags($_POST['selling_water'])));	#	წყლის ყიდვა 0.5(ლ) 0.5 თეთრი (50 თეთრი)
		$Comment 		= trim(htmlentities(strip_tags($_POST['comment'])));			#	კომენტარი


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


		require_once "../functions/functions.php";		#	ფუნქციების ფაილის გამოძახება
		require_once "../valid/filter.php";		#	ფუნქციების ფაილის გამოძახება

		$Err = FilterFields($PlaceName, $StartTime, $EndTime);

		$RemainingTime 				= RemainingTime($StartTime, $EndTime);
		$NumberofMinutes 			= RemainingMinutes($RemainingTime, $OneHours);
		$RemainingHours 			= RemainingHours($RemainingTime, $SecondsInOneHour);
		$AmountPerHours 			= AmountPerHours($PlaceName, $NumberofMinutes, $MoneyInMinutes);
		$AmountJoyStickPerHours 	= AmountJoyStickPerHours($PlaceName, $NumberofMinutes, $MoneyInMinutes, $Joystick, $ThreeJoystickMoney, $FourJoystickMoney);
		$BuySlash 					= SellingSlash($SellingSlash, $SlashPrice);
		$BuyWater 					= SellingWater($SellingWater, $WaterPrice);
		$TotalAmount 				= TotalAmount($AmountJoyStickPerHours, $BuySlash, $BuyWater);


		if(mb_strlen($PlaceName) !=0 && mb_strlen($StartTime) !=0 && mb_strlen($EndTime) !=0 ) 

		{
			require_once "class/class_update.php";

			$UpdateClass = new UPDATE($db_connect);
    		$UpdateClass->UpdateData($PlaceName, $StartTime, $EndTime, $AmountPerHours, $AmountJoyStickPerHours, $TotalAmount, $ActionSlash, $SellingSlash, $BuySlash, $SellingWater, $BuyWater, $Comment, $Name, $UserID, $ID);
		}

	}


?>

<!DOCTYPE html>
<html>
<head>
	<title> განახლება </title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- Font Awesome Icons CDN -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Angular JS Link -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>   


    <!-- Animate Text CSS -->
    <link rel="stylesheet" href="css/animate_text.css">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="fonts/line-icons/style.css">


    <style type="text/css">
    	

		@font-face 
	    {
	      font-family: bpg_mtavruli_normal;
	      src: url(../fonts/bpg_nino_mtavruli_bold.ttf);
	    }
	  

	    body,h1,h2,div,span,p,i,a 
	    {
	      font-family: bpg_mtavruli_normal !important;
	    }
    	
    	::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  			text-align: center;
  			color: white !important;
		}

		:-ms-input-placeholder { /* Internet Explorer 10-11 */
		  color: red;
		}

		::-ms-input-placeholder { /* Microsoft Edge */
		  color: red;
		}

		input{
			text-align: center;
		}

		textarea {
			color: black !important;
		}

		.btn-outline-success:focus {
			box-shadow: 1px solid #28a745 !important;
		}

    </style>


</head>


<body ng-app="app">


		<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-5 p-3">
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>
			  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
			    <a class="navbar-brand" href="../index.php"> EAGGAME.GE </a>
			    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			      

			      <li class="nav-item active">
			        <a class="nav-link" href="../index.php"> მთავარი <span class="sr-only">(current)</span></a>
			      </li>
			      
			      <li class="nav-item">
			        <a class="nav-link" href="../table.php"> ცხრილი </a>
			      </li>


			      <li class="nav-item">
			        <a class="nav-link" href="../history.php"> ისტორია </a>
			      </li>


			    </ul>

			    <div class="inline my-2 my-lg-0">
			      <span class="text-white mr-3"> <i class="icon-user-circle"></i> <?=$AdminClass->Name;?> </span>
			      <a href="../auth/logout.php" class="text-white"> <i class="icon-sign-out"></i> გასვლა </a>
				</div>

			  </div>
			</nav>

		</header>

		<div class="container-fluid">



			<div class="col-md-12">
                <div class="fixed-bottom">
                  <div class="justify-content-center align-items-center">
                    <?php  if(isset($UpdateClass->message)) : ?>
                    <div class="alert alert-danger text-center" role="alert" 
                      style="width: 350px; border: none; background: #343a40; left: 50%; transform: translate(-50%, -50%);  border-radius: 50px 50px 50px 50px; ">
                        <span class="text-white"> <i class="icon-check"></i> <?=$UpdateClass->message;?> </span>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="fixed-bottom">
                  <div class="justify-content-center align-items-center">
                    <?php  if(isset($Err)) : ?>
                    <div class="alert alert-danger text-center" role="alert" 
                      style="width: 350px; border: none; background: #343a40; left: 50%; transform: translate(-50%, -50%);  border-radius: 50px 50px 50px 50px; ">
                        <span class="text-white"> <i class="icon-info-circle"></i> <?=$Err;?> </span>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
            </div>






			<form class="mt-5 text-center" action="<?=$_SERVER['REQUEST_URI'];?>" method="POST">
				<div class="form-row">


					<div class="col-md-3">
						<label for="validationCustom01"> ადგილის ნომერი </label>
						<select name="place_name" class="form-control">
								<optgroup label="სტანდარტული ადგილები">
									<option value="1"> 1 </option>
									<option value="2"> 2 </option>
									<option value="3"> 3 </option>
									<option value="4"> 4 </option>
									<option value="5"> 5 </option>
									<option value="6"> 6 </option>
									<option value="7"> 7 </option>
									<option value="8"> 8 </option>
									<option value="9"> 9 </option>
									<option value="10"> 10 </option>
								</optgroup>

								<optgroup label="VIP ადგილები">
									<option value="VIP"> VIP </option>
									<option value="VIP"> VIP2 </option>
								</optgroup>
						</select>
					</div>



					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> დაწყების დრო </label>
							<input type="text" name="start_time" class="form-control" placeholder="დაწყების დრო">
						</div>
					</div>



					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> დამთავრების დრო </label>
							<input type="text" name="end_time" class="form-control" placeholder="დამთავრების დრო">
						</div>
					</div>



					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> "ჯოისტიკი" </label>
							<select name="joystick" class="form-control">
								<option value="2"> 2 </option>
								<option value="3"> 3 </option>
								<option value="4"> 4 </option>
							</select>
						</div>
					</div>


					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> აქცია "სლაში" </label>
							<input type="number" name="action_slash" class="form-control" placeholder="აქცია 'სლაში'" value="<?=$ReadData->action_slash;?>">
						</div>
					</div>


					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> "სლაში" ყიდვა </label>
							<input type="number" name="selling_slash" class="form-control" placeholder="'სლაში' ყიდვა" value="<?=$ReadData->slash_number;?>">
						</div>
					</div>



					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> წყლის რაოდენობა </label>
							<input type="text" name="selling_water" class="form-control" placeholder="წყლის რაოდენობა" value="<?=$ReadData->water_number;?>">
						</div>
					</div>


					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> კომენტარი </label>
							<textarea type="number" name="comment" class="btn-outline-success bg-white form-control" rows="1">
								<?=$ReadData->comment;?>
							 </textarea>
						</div>
					</div>


					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> თანხა </label>
							<input type="text" class="btn-danger text-white form-control" placeholder="თანხა" value="<?=$AmountPerHours;?>" disabled="disabled">
						</div>
					</div>


					<div class="col-md-3 mb-5">
						<div class="form-group">
							<label for="validationCustom01"> თანხა ჯამურად </label>
							<input class="btn-danger text-white form-control" placeholder="თანხა ჯამურად" value="<?=$TotalAmount;?>" disabled="disabled">
						</div>
					</div>


					<div class="col-md-12">
						<div class="form-group">
							<button type="submit" name="add" class="btn btn-info btn-lg btn-block"> 
								დამატება 
							</button>
						</div>
					</div>


				</div>
			</form>


		</div>




</body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>



</html>



