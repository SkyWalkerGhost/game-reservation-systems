<?php 
	
	session_start();


	ini_set('display_errors', 1);
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


    require_once "server/server.php";

	$Administrator = new ADMINISTRATOR($db_connect);
	$Administrator->getAdministratorSession();
	$Administrator->Errors;
?>

<!DOCTYPE html>
<html>
<head>
	<title> ავტორიზაცია </title>

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


		#center{
			position: absolute;
			left: 50%;
			top: 45%;
			transform: translate(-50%, -50%);
		}

    </style>


</head>
<body>


	<div class="container">
		<div class="row justify-content-center border border-success rounded p-5" id="center">
			<form accept="<?=$_SERVER['REQUEST_URI'];?>" method="POST" class="text-center">
				<div class="row">

					<div class="col-md-12">
						<div class="form-group">
							<label> პაროლი 1: 1234 </label>
							<br>
							<label> პაროლი 2: 4321 </label>
							<input type="password" name="_2cMdaZcfeXafeDas" placeholder="პაროლი" class="form-control">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<button type="submit" name="__auth" class="btn btn-success form-control-lg">
								შესვლა
							</button>
						</div>
					</div>


				</div>
			</form>
		</div>

	</div>


</body>
</html>