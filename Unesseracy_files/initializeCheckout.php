<?php

session_start();


include_once('../common/dbConnect.php');
include_once('../common/dbFunctions.php');
include_once('../common/regEx.php');
include_once('../common/functions.php');
include_once('../shopping_cart/cart.php');
include_once('../phpClasses/Html.class.php');

$_SESSION['cart'] = new Cart();

$_SESSION['cart']->add_item(111, 1, 10, "Harry potter book");
$_SESSION['cart']->add_item(2222, 1, 10, "Harry potter book");
$_SESSION['cart']->add_item(3333, 1, 10, "Harry potter book");
$_SESSION['cart']->add_item(4444, 1, 10, "Harry potter book");
$_SESSION['cart']->add_item(5555, 1, 10, "Harry potter book");
$_SESSION['cart'] = serialize($_SESSION['cart']);

redirect("checkout.php");


?>