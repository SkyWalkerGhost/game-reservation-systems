<?php

session_start();  
unset($_SESSION["pass"]);  
header("Location: login.php");  



?>