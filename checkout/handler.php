<?php
session_start();

include_once('../common/dbConnect.php');
include_once('../common/dbFunctions.php');
include_once('../common/regEx.php');
include_once('../common/functions.php');

/*if($_POST['add']) {
	$cart = unserialize($_SESSION['cart']);
	$product = $products[$_POST['id']];
	$cart->add_item($product['id'],$_POST['qty'],$product['price'],$product['name']);
	$_SESSION['cart'] = serialize($cart);
}*/

//$_SESSION['customerId'] = 12;

if($_POST['remove'] == "Remove") {
	$cart = unserialize($_SESSION['cart']);
	$rid = intval($_POST['id']);
	$cart->del_item($rid);
	$_SESSION['cart'] = serialize($cart);
}
if($_POST['send'] == '1'){
	$cart = unserialize($_SESSION['cart']);
	confirmOrder($DBH,$cart->get_contents());
	unset($_POST['send']);
	$_SESSION['cart'] = serialize($cart);
}
if($_POST['unset'] == "unset"){
	$cart = unserialize($_SESSION['cart']);
	$cart->empty_cart();
	unset($_POST['unset']);
	$_SESSION['cart'] = serialize($cart);
}


redirect("checkout.php");


?>