<?php
session_start();
//including html object and securing exchange
include_once("../phpClasses/Html.class.php");
include_once("../common/functions.php");


//constructing html object
$htmlLogin = new Html("Login", "null", true);
// turn on https
SSLon();

// needs html object as parameter
function loginHandler($html){
$formid = array("id"=>"form");
//attributes $action, $method, $formattributes
$html->startForm("loginCheck.php", "post", $formid);

if(!$_SESSION['valid']){
//making 2 input lines and submit button
$email = array("type"=>"text" , "name"=>"email");
$html->tag("input", "Email", $email);
$password = array("type"=>"password" , "name"=>"password");
$html->tag("input", "Password", $password);
$submit = array("type"=>"submit" , "value"=>"login");
$html->tag("input", "", $submit);
}else{
	$hidden = array("type"=>"hidden" , "name"=>"logout");
	$html->tag("input", "", $hidden);
	$logout = array("type"=>"submit" , "value"=>"logout");
	$html->tag("input", "", $logout);
}
$html->endForm();
}
//debugging purposes, on final product comment these

if($_SESSION['valid']){
	echo("logged in");
}else{
	echo("logged out");
}

?>