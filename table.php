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
    $GameData = $GameDataClass->getGameTableData();
    $GameDataClass->getEarnedAmount();


    function Redirect()

    {
    	header("refresh: 300; table.php");
    }

    Redirect();


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


		thead{
			cursor: pointer;
		}

		.btn-outline-success:focus {
			box-shadow: 1px solid #28a745 !important;
		}

		.dataTables_wrapper{
			margin-top: 50px;
		}


		.dataTables_filter {
			float: right;
		}

		.dataTables_paginate{
			float: right;
			margin-top: 20px;
		}

		.dataTables_info{
			margin-top: 20px;
		}

    </style>


</head>


<body ng-app="app">


		<header>
			<?php require_once("header/header.php"); ?>
		</header>


		<div class="container-fluid">

			<div class="col-md-12 mt-4"> 
					<span class="btn btn-outline-dark float-right"> 
							გამომუშავებული თანხა: <?=$GameDataClass->TotalMoney;?> 
							(₾)
					</span>
			</div>	


			<div class="table-responsive">

			<table class="table table-dark table-xs mb-0 zero-configuration">

                    <thead class="text-center">
					    <tr>
					      <th scope="col"> ადგილი </th>
					      <th scope="col"> დაწყება </th>
					      <th scope="col"> დამთავრება </th>
					      <th scope="col"> დრო </th>
					      <th scope="col"> <i class="icon-money" title="თანხა საათების მიხედვით"></i> </th>
					      <th scope="col"> <i class="icon-dollar" title="თანხა 'ჯოისტიკების' მიხედვით"></i> </th>
					      <th scope="col"> <i class="icon-bullhorn" title="აქცოა 'სლაშ'"></i> </th>
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
				  	<?php foreach ($GameData AS $game_row) : ?>

					<?php 


						$FullTime = $game_row['end_time'];
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
								<a href="update/update.php?ID=<?=$game_row['id'];?>" class="btn btn-outline-info w-100" title="შექმნის თარიღი :<?=mb_substr($game_row['time'], 0, 19);?>"> 
									<?=$game_row['place'];?>  
								</a>
				      		</td>


				      		<td> 
				      			<span class="btn btn-outline-warning w-100"> 
				      				<?=mb_substr($game_row['start_time'], 10, 6);?> 
				      			</span> 
				      		</td>

				      		<td> 
				      			<span class="btn btn-outline-warning w-100"> 
				      				<?=mb_substr($game_row['end_time'], 10, 6);?> 
				      			</span> 
				      		</td>


					      	<td> 
					      		<?php if($PlayingFullTime < 0 ) : ?>
					      		<span class="btn btn-outline-danger btn-sm w-100 p-2"> დასრულდა </span>
					      			<?php else : ?>
					      		<span class="btn btn-outline-success btn-sm w-100 p-2"> <i class="icon-clock-o"></i> <?=$PlayingFullTime;?> </span> 
					      		<?php endif; ?>
					      	</td>


					     	<td> <?=$game_row['money'];?> </td>


					     	<td> 
					     		<?=$game_row['amount_in_total'];?>
					  		</td>


					      	<td> 
					      		<span title="აქცია 'სლაში' : <?=$game_row['action_slash'];?>"> 
					      			<?=$game_row['action_slash'];?> 
					      			<sub> ც </sub> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span title="შეძენილი 'სლაშის' თანხა: [ <?=$game_row['selling_slash'];?> ]"> 
					      			<?=$game_row['selling_slash'];?> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span title="შეძენილი 'სლაშის' რაოდენობა: [ <?=$game_row['slash_number'];?> ]"> 
					      				<?=$game_row['slash_number'];?>  
					      				<sub> ც </sub> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span title="შეძენილი წყლის თანხა: [ <?=$game_row['selling_water'];?> ]"> 
					      			<?=$game_row['selling_water'];?> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span title="შეძენილი წყლის რაოდენობა : [ <?=$game_row['water_number'];?> ]"> 
					      				<?=$game_row['water_number'];?>
					      				<sub> ც </sub> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span title="ჯამში გადაიხადა : [ <?=$game_row['total_money'];?> ]"> 
					      				<?=$game_row['total_money'];?>
					      		</span> 
					      	</td>


					      	<td> 
					      		<span class="btn btn-outline-success"> 
					      				<?=$game_row['payment_status'];?> 
					      		</span> 
					      	</td>


					      	<td> 
					      		<span class="btn btn-danger btn-sm p-2"> 
					      				<i class="icon-user-circle"></i>
					      				<?=$game_row['users_name'];?> 
					      		</span> 
					      	</td>
	
				    </tr>
					<?php endforeach;?>

				  </tbody>

            </table>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<script src="plugins/tables/js/jquery.dataTables.min.js"></script>
<script src="plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
<script src="plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

</html>



