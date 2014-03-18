<?php

session_start();

include_once('../common/dbConnect.php');
include_once('../common/dbFunctions.php');
include_once('../common/regEx.php');
include_once('../common/functions.php');


SSLon();
$userEmail = $_POST['email'];
$userPassword = $_POST['password'];
$inOut = true;

//checks if user has pressed logout
if($_SESSION['valid']){
	$inOut = false;
}

//from functions.php
logInOut($userEmail, $userPassword , $DBH, $inOut);
redirect("loginForm.php");
?>