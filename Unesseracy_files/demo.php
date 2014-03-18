<?php
//Cart Demo

// You must included cart.php BEFORE you start the session. 
include "cart.php";
session_start();      // start the session


$cart =& $_SESSION['cart']; // point $cart to session cart.
if(!is_object($cart)) $cart = new Cart(); // if $cart ( $_SESSION['cart'] ) isn't an object, make a new cart

// end of header stuff

?>
<html><head><title>Cart Demo</title></head>
<body><h3>Cart Demo</h3>

<?php

// Usually you would get your products from a database but we'll pretend.. 

$products = array();
$products[1] = array("id"=>1,"name"=>"Harry Potter VI","price"=>2.00);
$products[2] = array("id"=>2,"name"=>"PHP programming","price"=>4.80);
$products[3] = array("id"=>3,"name"=>"Bible","price"=>12.95);


// check to see if any items are being added
if($_POST['add']) {
	$product = $products[$_POST['id']];
	$cart->add_item($product['id'],$_POST['qty'],$product['price'],$product['name']);
}
if($_POST['remove']) {
	$rid = intval($_POST['id']);
	$cart->del_item($rid);

}

// spit some forms
// You can have many different types of forms, such as many quantity boxes
// and an "add to cart" button at the bottom which adds all items
// but for the purposes of this demo we will handle one item at a time. 
echo "<table>";
foreach($products as $p) {
	echo "<tr><td><form method='post' action='demo.php'>";
	echo "<input type='hidden' name='id' value='".$p['id']."'/>";
	echo "".$p['name'].' $'.number_format($p['price'],2)." ";
	echo "<input type='text' name='qty' size='5' value='1'><input type='submit' value='Add to cart' name='add'>";
	echo "</form></td></tr>";
}
echo "</table>";


echo "<h2>Items in cart</h2>";

if($cart->itemcount > 0) {
	foreach($cart->get_contents() as $item) {
		echo "<br />Item:<br/>";
		echo "Code/ID :".$item['id']."<br/>";
		echo "Quantity:".$item['qty']."<br/>";
		echo "Price   :$".number_format($item['price'],2)."<br/>";
		echo "Info    :".$item['info']."<br />";
		echo "Subtotal :$".number_format($item['subtotal'],2)."<br />";
		echo "<form method=post><input type='hidden' name='id' value='".$item['id']."'/><input type='submit' name='remove' value='Remove'/></form>";
	}
	echo "---------------------<br>";
	echo "total: $".number_format($cart->total,2);
} else {
	echo "No items in cart";
}

?>
