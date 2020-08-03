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



    require_once "auth/server/session.php";

    // ადმინისტრატორის სახელი
    $AdminClass   = new Admin($db_connect);
    $AdminClass->getAdminSession($AdministratorEmail);



    require_once "functions/app.init.php";

    $GameDataClass = new GAME_TABLE($db_connect);
    $HistoryData = $GameDataClass->getHistory();
    $GameDataClass->AmountInTotal();



?>

<!DOCTYPE html>
<html>
<head>
	<title> ისტორია </title>
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

			<div class="col-md-12 mt-3">
				<span class="float-right"> ყველა დაჯავშნილი ადგილის ისტორია </span>
			</div>


			<div class="table-responsive">
				
				<table class="table table-dark mt-3">
				  <thead class="text-center">
				    <tr>
				      <th scope="col"> თანხა </th>
				      <th scope="col"> ჯამურად </th>
				      <th scope="col"> თანხა სულ: </th>
				      <th scope="col"> აქცია 'სლაში' </th>
				      <th scope="col"> გაყიდული 'სლაში' </th>
				      <th scope="col"> წყლის რაოდენობა </th>
				      <th scope="col"> წყლის თანხა </th>
						
				    </tr>
				  </thead>



				  <tbody class="text-center">
		

				    <tr>


				      	<td> 	
				      		<span class="btn btn-outline-info w-100" title="საათების მიხედვით გამომუშავებული"> 
				      			<?=$GameDataClass->TotalMoney;?>
				      			<sup> ₾ </sup> 
				      		</span> 
				      	</td>


				      	<td> 
				      		<span class="btn btn-outline-info w-100" title="'ჯოისტიკების' მიხედვით გამომუშავებული თანხა"> 
				      			<?=$GameDataClass->AmountInTotal;?> 
				      			<sup> ₾ </sup> 
				      		</span> 
				      	</td>


				      	<td> 
				      		<span class="btn btn-outline-info w-100" title="საათების, 'ჯოისტიკების' გაყიდული 'სლაშების' და წყლის მთლიანი გამომუშავებული თანხა"> <?=$GameDataClass->FullMoney;?> 
				      		<sup> ₾ </sup> 
				      		</span> 
				      	</td>
				      	

				      	<td> 
				      		<span class="btn btn-outline-info w-100" title="აქციის 'სლაშების' რაოდენობა"> 
				      			<?=$GameDataClass->ActionSlash;?> 
				      			<sup> ც </sup> 
				      		</span> 
				      	</td>
				      	

				      	<td> 
				      		<span class="btn btn-outline-info w-100" title="გაყიდული 'სლაშების' მთლიანი თანხა"> 
				      			<?=$GameDataClass->SellingSlash;?> 
				      			<sup> ₾ </sup> 
				      		</span> 
				      	</td>
				      	

				      	<td> 
				      		<span class="btn btn-outline-info w-100" title="გაყიდული წყლის რაოდენობა"> 
				      			<?=$GameDataClass->WaterNumber;?> 
				      			<sup> ც </sup> 
				      		</span> 
				      	</td>
				      	

				      	<td> 
				      		<span class="btn btn-outline-info w-100" title="გაყიდული წყლის მთლიანი თანხა"> 
				      			<?=$GameDataClass->SellingWater;?> 
				      			<sup> ₾ </sup> 
				      		</span> 
				      	</td>



				    </tr>
					

				  </tbody>
				</table>

				<div class="col-md-12 text-center">
					<span> <?=$GameDataClass->Message;?> </span>
				</div>

			</div>	




			<div class="table-responsive">
				
				<table class="table table-dark mt-3">
				  <thead class="text-center">
				    <tr>
				      <th scope="col"> ადგილი </th>
				      <th scope="col"> დაწყება </th>
				      <th scope="col"> დამთავრება </th>
				      <th scope="col"> დრო </th>
				      <th scope="col"> თანხა </th>
				      <th scope="col"> ჯამურად </th>
				      <th scope="col"> აქ. 'სლაში' </th>
				      <th scope="col"> ყიდვა </th>
				      <th scope="col"> რაო. </th>
				      <th scope="col"> წყ. </th>
				      <th scope="col"> რაო. </th>
				      <th scope="col"> ჯამში </th>
				      <th scope="col"> გადახდა </th>
				      <th scope="col"> ადმინი </th>
						
				    </tr>
				  </thead>



				  <tbody class="text-center">
				  	<?php foreach ($HistoryData AS $history_row) : ?>

					<?php 


						$FullTime = $history_row['end_time'];
						$ExpTime = strtotime($FullTime);
						$ExpiredTime = $ExpTime - time();
						
						date_default_timezone_set('Asia/Tbilisi');
						
						$seconds = strtotime($FullTime) - time();
						$hours = floor($seconds / 3600);	// დარჩენილი საათების გაგება
						$seconds %= 3600;

						$minutes = floor($seconds / 60);	// დარჩენილი წუთების გაგება
						$seconds %= 60;

						$PlayingFullTime = 	$hours . ' :' .  $minutes    . ':'   . $seconds;
					?>


				    <tr>
				      		<td> 
								<a href="update/update.php" class="btn btn-outline-info w-100" title="შექმნის თარიღი :<?=mb_substr($history_row['time'], 0, 19);?>"> 
									<?=$history_row['place'];?>  
								</a>
				      		</td>


				      		<td> 
				      			<span class="btn btn-outline-warning w-100"> 
				      				<?=mb_substr($history_row['start_time'], 10, 6);?> 
				      			</span> 
				      		</td>

				      		<td> 
				      			<span class="btn btn-outline-warning w-100"> 
				      				<?=mb_substr($history_row['end_time'], 10, 6);?> 
				      			</span> 
				      		</td>


					      	<td> 
					      		<?php if($ExpiredTime < 0 ) : ?>
					      		<span class="btn btn-outline-danger btn-sm w-100 p-2"> დრო ამოიწურა </span>
					      			<?php else : ?>
					      		<span class="btn btn-outline-success btn-sm w-100 p-2"> <i class="icon-clock-o"></i> <?=$PlayingFullTime;?> </span> 
					      		<?php endif; ?>
					      	</td>


					     	<td> <?=$history_row['money'];?> </td>


					     	<td> 
					     		<?=$history_row['amount_in_total'];?>
					  		</td>


					      	<td> 
					      		<span title="აქცია 'სლაში' : <?=$history_row['action_slash'];?>"> 
					      			<?=$history_row['action_slash'];?> 
					      			<sub> ც </sub> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span title="შეძენილი 'სლაშის' თანხა: [ <?=$history_row['selling_slash'];?> ]"> 
					      			<?=$history_row['selling_slash'];?> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span title="შეძენილი 'სლაშის' რაოდენობა: [ <?=$history_row['slash_number'];?> ]"> 
					      				<?=$history_row['slash_number'];?>  
					      				<sub> ც </sub> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span title="შეძენილი წყლის თანხა: [ <?=$history_row['selling_water'];?> ]"> 
					      			<?=$history_row['selling_water'];?> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span title="შეძენილი წყლის რაოდენობა : [ <?=$history_row['water_number'];?> ]"> 
					      				<?=$history_row['water_number'];?>
					      				<sub> ც </sub> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span title="ჯამში გადაიხადა : [ <?=$history_row['total_money'];?> ]"> 
					      				<?=$history_row['total_money'];?>
					      		</span> 
					      	</td>


					      	<td> 
					      		<span class="btn btn-outline-success"> 
					      				<?=$history_row['payment_status'];?> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span class="btn btn-outline-danger"> 
					      				<i class="icon-user-circle"></i>
					      				<?=$history_row['users_name'];?> 
					      		</span> 
					      	</td>
	
				    </tr>
					<?php endforeach;?>

				  </tbody>
				</table>

				<div class="col-md-12 text-center">
					<span> <?=$GameDataClass->Message;?> </span>
				</div>

			</div>	



		</div>


</body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


</html>



