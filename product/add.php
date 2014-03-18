<?php
include_once("../common/dbConnect.php");
include_once("../common/dbFunctions.php");
include_once("../common/functions.php");
include_once("../phpClasses/Html.class.php");
include_once("../shopping_cart/cart.php");

session_start();

$ProductISBN = $_GET['ProductISBN'];
if($_SESSION['valid']!= null){
	
	
	echo "<script>alert(". $ProductISBN.")</script>";	
	//$sql = "SELECT * FROM products WHERE ProductISBN = $ProductISBN;";
	if(!isset($_SESSION['cart'])){
		$cart = new Cart();
	}else{
		$cart = unserialize($_SESSION['cart']);
	}	

	
	$sql =  "SELECT * FROM products WHERE ProductISBN = $ProductISBN;";
	$STH = @$DBH->query($sql);
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	$row = $STH->fetch();
	$ProductPrice = $row['ProductPrice'];
	$ProductName = $row['ProductName'];
	$ProductQty = 1;
	$cart->add_item($ProductISBN,1,$ProductPrice,$ProductName); 
	


	$_SESSION['cart'] = serialize($cart);
	echo "<script>alert('added to cart')</script>";	
}else{
	echo "<script>alert('login please')</script>";
	

}
//sleep(20);
//redirect("item.php?ProductISBN=".$ProductISBN );
echo '<script>window.location="item.php?ProductISBN='.$ProductISBN.'"</script>';


?>