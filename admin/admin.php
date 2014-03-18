<?php
session_start();

include_once("../common/dbConnect.php");
include_once("../common/dbFunctions.php");
include_once("../common/functions.php");
include_once("../phpClasses/Html.class.php");



//if user's not admin, redirect him out

if($_SESSION['admin'] != true){
	redirect("../frontpage/main.php");
}


$html = new html("Admin", array("../css/page.css", "../css/form.css"), true);

$html->buildTop();

$html->tag("div",  //headerWrapper
	$html->gTag("div", //header
		
		$html->gTag("div", //logo
			$html->gTag("a","<img class='logo' src='../images/small-logo.png' />" ,array("href"=>"../frontpage/main.php"))
		, array("id"=>"logo")) . // notice dot. Appending different gTags under header
		
		
		$html->gTag("div", //navbar
			$html->gBuildList(array(0=>"<a href='../frontpage/main.php'>Sign in</a>",
									1=>"<a href='../product/products.php' class='nav'>Products</a>",
									2=>"<a href='../register/register.php' class='nav'>Register</a>",
									3=>"<a href='../checkout/checkout.php' class='nav'>Checkout</a>"),			
									"ul",	
									array())
		,array("id"=>"navbar")) . // notice dot. Appending different gTags under header
		
		//id=cart
		$html->gTag("div",
			$html->gTag("a"," <img src='../images/cart.png' /> " . getCartCount() ,
			array("href"=>"../checkout/checkout.php", "class"=>"cart")) .
			$html->gTag("div", "" , array())
		,array("id"=>"cart"))
	
	, array("id"=>"header"))
, array("id"=>"headerWrapper"));

$html->tag("div", //bodyWrapper
	$html->gTag("div",  //body
	
	$html->gTag("div", 
			$html->gTag("img", "", array("src"=>"../images/welcome.png"))
		, array("id"=>"welcome")) .
		
		$html->gTag("div", //mainWrapper 
			$html->gTag("div", //mainContact
				$html->gTag("div", //content
					$html->gTag("span",  $html->gTag("img", "", array("src"=>"../images/form-topbg.png")), array()) .
					$html->gTag("div", //contact
						$html->gTag("form", 
						 	$html->gTag("h3", "Create an Account", array()).
						 	$html->gBuildList(array(
						 		'<label for="name">ISBN:</label>
	                            <input type="text" id="name" name="isbn" placeholder="Enter ISBN" />','
						 		<label for="name">Name:</label>
	                            <input type="text" id="name" name="name" placeholder="Enter book name" />','
	                            <label for="name">Description:</label>
	                            <input type="text" id="name" name="description" placeholder="Enter book description" />', '
	                            <label for="name">Category:</label>
	                            <input type="text" id="name" name="category" placeholder="Enter book category" />','
	                            <label for="name">Price:</label>
	                            <input type="text" id="name" name="price" placeholder="Enter price" />','
	                            <label for="name">File:</label>
	                            <input type="text" id="name" name="file" placeholder="Enter picture file address" />')).
						 		$html->gTag("input", "", array("id"=>"cartBtn", "type"=>"submit", "value"=>"Add"))
					 		,array("action"=>"addBookToDb.php", "method"=>"post")) .
					 		
					 		$html->gTag("div", 
								$html->gTag("div", $_SESSION['adminSend'] ,array("id"=>"adminSend")) .
								$html->gTag("form",
									$html->gTag("input",  ""  ,array("name"=>"getOrders", "value"=>1, "type"=>"hidden")) .
									$html->gTag("input", "fetch",array("type"=>"submit"))
								,array("action"=>"fetchOrders.php", "method"=>"get"))
							,array("id"=>"ordersDiv"))
							
					, array("id"=>"contact")) .
					$html->gTag("span", 
						$html->gTag("img", "", array("src"=>"../images/form-footerbg.png"))
					,array())
				, array("id"=>"content"))
			,array("id"=>"mainContact"))
		,array("id"=>"mainWrapper")) 
	
	
	/*
	$html->gTag("form",
		$html->gTag("input", "Isbn", array("type"=>"text","name"=>"isbn" )) .
		$html->gTag("br", "") .
		$html->gTag("input", "Name", array("type"=>"text","name"=>"name" )) .
		$html->gTag("br", "") .
		$html->gTag("input", "Description", array("type"=>"text","name"=>"description" )) .
		$html->gTag("br", "") .
		$html->gTag("input", "Category", array("type"=>"text","name"=>"category" )) .
		$html->gTag("br", "") .
		$html->gTag("input", "Price", array("type"=>"text","name"=>"price" )) .
		$html->gTag("br", "") .
		$html->gTag("input", "File", array("type"=>"text","name"=>"file" )) .
		$html->gTag("br", "") .
		$html->gTag("input", "", array("type"=>"submit", "value"=>"Add")) .
		$html->gTag("div", $_SESSION['error'], array())	
	,array("action"=>"addBookToDb.php", "method"=>"post", "id"=>"bookform")) .
	*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	,array("id"=>"body"))
,array("id"=>"bodyWrapper"));

$html->tag("div",
	$html->gTag("div", 
		"<p>&copy; ". date("Y") ." Kamazon Online Bookstore</p>"
	,array("id"=>"footer"))
,array("id"=>"footerWrapper"));

$html->buildBottom();

echo($html->getPage());

//to avoid problems with pagerefreshing
unset($_SESSION['adminSend']);

?>
