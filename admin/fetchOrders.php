<?php
session_start();

include_once('../common/dbConnect.php');
include_once('../common/dbFunctions.php');
include_once('../common/regEx.php');
include_once('../common/functions.php');


//returns list of current days orders
function fetchTodaysOrders($DBH){
	$orderHolder = array();
	$returnString;
	$STH = $DBH->query("SELECT *
						FROM orders
						WHERE Date='".date(Y.m.d)."'");
	$STH->setFetchMode(PDO::FETCH_NUM);
	$i = 0;
	while($row = $STH->fetch()){
		$orderHolder[$i] = $row;
		$i++;
	}
	$returnString .= "<ul>";
	
	for($e = 0; $e < $i; $e++){
		$returnString .= "<li><form action='fetchOrders.php', method='get'>
							<input type='hidden' name='customerOrder' value='1'></hidden>
							<input type='hidden' name='customerId' value='". $orderHolder[$e][1] . "' />
							<input type='hidden' name='orderId' value='". $orderHolder[$e][0] . "' />
							<input type='submit' value='" . $orderHolder[$e][1] . "'/></form></li>";
	}
	
	$returnString .= "</ul>";
	
	return $returnString;
}

function fetchCustomersOrders($DBH, $customerId = 1, $orderId = 1){
	$orderHolder = array();
	$returnString;
	$STH = $DBH->query("SELECT customers.Firstname, customers.Lastname, orders.Date, ordered_products.ProductISBN, ordered_products.QuantityOrdered, customers.Address, customers.City, customers.Zip
						FROM customers
						INNER JOIN orders
						ON customers.CustomerId=orders.CustomerId
						INNER JOIN ordered_products
						ON orders.OrderId = ordered_products.OrderId
						WHERE customers.CustomerId='". $customerId ."' AND
						orders.OrderId = '". $orderId ."'");
	$STH->setFetchMode(PDO::FETCH_NUM);
	$i = 0;
	while($row = $STH->fetch()){
		$orderHolder[$i] = $row;
		$i++;
	}//678
	$returnString .= "<div>Name: ". $orderHolder[0][0] . " ".  $orderHolder[0][1] . ", Address: " . $orderHolder[0][5] . ", City: " .  $orderHolder[0][6] . ", Zip: ".  $orderHolder[0][7] . "</div>";
	$returnString .= "<ul>";
	
	for($e = 0; $e < $i; $e++){
		$returnString .= "<li>ISBN: ". $orderHolder[$e][3] .",  Quantity: " .  $orderHolder[$e][4] ."</li>";
	}
	
	$returnString .= "</ul>";
	return $returnString;
}

echo($_GET['getOrders'] . " " . $_GET['customerOrder']);

if($_GET['getOrders'] == 1){
	
	$_SESSION['adminSend'] = fetchTodaysOrders($DBH);
	unset($_GET['getOrders']);
	//redirect("admin.php");
}
if($_GET['customerOrder'] == 1){
	
	$_SESSION['adminSend'] = fetchCustomersOrders($DBH, $_GET['customerId'], $_GET['orderId']);
	unset($_GET['customerOrder']);
}



redirect("admin.php");

?>