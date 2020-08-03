<?php 
	

	session_start();

    if(!isset($_SESSION["pass"])) {  

        header("Location: auth/login.php");  
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

    require_once "db/db.php";       # კონფიგურაციის ფაილი, ბაზასთან დაკავშირება

    $pdo_config = new Database_Connection();
    $db_connect = $pdo_config->getConnect();


    require_once "functions/app.init.php";

    $GameDataClass = new GAME_TABLE($db_connect);
    $GameData = $GameDataClass->getGameTableData();


    require_once "auth/server/session.php";

    // ადმინისტრატორის სახელი
    $AdminClass   = new Admin($db_connect);
    $AdminClass->getAdminSession($AdministratorEmail);
   	$Name 	= $AdminClass->Name;
   	$UserID = $AdminClass->UserID;

	if(isset($_GET['add'])) 

	{


		require_once "functions/variables.php";		# ცვლადებისა და სხვადასხვა მნიშვნელობების გამოძახება
		require_once "functions/functions.php";		#	ფუნქციების ფაილის გამოძახება
		require_once "valid/filter.php";		#	ფუნქციების ფაილის გამოძახება

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
			require_once "functions/init.add.php";

			$NewSeatingAreaClass = new AddNewPlace($db_connect);
    		$NewSeatingAreaClass->NewPlace($PlaceName, $StartTime, $EndTime, $AmountPerHours, $AmountJoyStickPerHours, $TotalAmount, $ActionSlash, $SellingSlash, $BuySlash, $SellingWater, $BuyWater, $Comment, $Name, $UserID);
		}

	}


?>

<!DOCTYPE html>
<html>
<head>
	<title> GAME </title>
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
			<?php require_once("header/header.php"); ?>
		</header>

		<div class="container-fluid">



			<div class="col-md-12">
                <div class="fixed-bottom">
                  <div class="justify-content-center align-items-center">
                    <?php  if(isset($NewSeatingAreaClass->success_message)) : ?>
                    <div class="alert alert-danger text-center" role="alert" 
                      style="width: 350px; border: none; background: #343a40; left: 50%; transform: translate(-50%, -50%);  border-radius: 50px 50px 50px 50px; ">
                        <span class="text-white"> <i class="icon-check"></i> <?=$NewSeatingAreaClass->success_message;?> </span>
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






			<form class="mt-5 text-center" action="<?=$_SERVER['REQUEST_URI'];?>" method="GET" ng-controller="myCtrl">
				<div class="form-row">


					<div class="col-md-3">
						<label for="validationCustom01"> ადგილის ნომერი </label>
						<select name="place_name" class="form-control" ng-change="SeatingArea()"  ng-model="seating_area">
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
							<input type="text" name="start_time" class="form-control" placeholder="დაწყების დრო"  ng-model="start_time">
						</div>
					</div>



					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> დამთავრების დრო </label>
							<input type="text" name="end_time" class="form-control" placeholder="დამთავრების დრო"  ng-model="end_time">
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
							<input type="number" name="action_slash" class="form-control" placeholder="აქცია 'სლაში'">
						</div>
					</div>



					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> "სლაშის" შეძენა </label>
							<input type="number" name="selling_slash" class="form-control" placeholder="'სლაშის' შეძენა" ng-change="CalculateSlash()"  ng-model="selling_slash" aria-describedby="basic-addon2">
						</div>
					</div>


					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> წყალი (0.5ლ) </label>
							<input type="number" name="selling_water" class="form-control" placeholder="წყალი" ng-change="CalculateWater()"  ng-model="selling_water">
						</div>
					</div>


					<div class="col-md-3">
						<div class="form-group">
							<label for="validationCustom01"> კომენტარი </label>
							<textarea type="number" name="comment" class="btn-outline-success bg-white form-control" rows="1"> </textarea>
						</div>
					</div>


					<div class="col-md-12 mb-5"></div>

					
					<div class="col-md-2">
						<div class="form-group">
							<label for="validationCustom01"> ადგილის ნომერი </label>
							<input type="text" class="btn-info form-control" placeholder="ადგილის ნომერი" disabled="disabled" value="{{SeatingAreaNumber}}">
						</div>
					</div>


					<div class="col-md-2">
						<div class="form-group">
							<label for="validationCustom01"> შეძენილი 'სლაში' </label>
							<input type="text" class="btn-info form-control" placeholder="შეძენილი 'სლაში'" disabled="disabled" value="{{Slash}}">
						</div>
					</div>


					<div class="col-md-2">
						<div class="form-group">
							<label for="validationCustom01"> შეძენილი წყალი </label>
							<input type="text" class="btn-info form-control" placeholder="შეძენილი წყალი" disabled="disabled" value="{{Water}}">
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
							<button type="submit" name="add" class="btn btn-success btn-lg btn-block"> 
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

	<script type="text/javascript">
		
		var app = angular.module('app', []);
	  	app.controller('myCtrl', function($scope) 

		  {
		    $scope.selling_slash;	// 'სლაშის' ყიდვა
		    $scope.selling_water;	//	წყლის ყიდვა
		    $scope.seating_area;	//	ადგილის ნომრები
		    $scope.start_time		//	დაწყების დრო
		    $scope.end_time;		//	დამთავრების დრო
		    $scope.full_time;		//	სათამაშო დრო


		    $scope.slashPrice = 1.5;	// ერთი ჭიქა 'სლაშის' ღირებულება
		    $scope.WaterPrice = 0.5;	// ერთი ბოთლი წყლის ღირებულება

		    $scope.SeatingArea = function()

		    {
		    	$scope.SeatingAreaNumber = "მაგიდა: " + ' ' + $scope.seating_area;
		    }


		    $scope.CalculateSlash = function() 

		    {
		      $scope.Slash = "რაო. " + $scope.selling_slash + ' ' + ' ' + "თანხა: " + $scope.slashPrice *  $scope.selling_slash + "₾";
		    }


		    $scope.CalculateWater = function() 

		    {
		      $scope.Water = "რაო. " + $scope.selling_water + ' ' + ' ' + "თანხა: " + $scope.WaterPrice *  $scope.selling_water + "₾";
		    }



		  });


	</script>

</html>



