<?php

session_start();
include_once("../common/dbConnect.php");
include_once("../common/dbFunctions.php");
include_once("../common/functions.php");
include_once("../phpClasses/Html.class.php");

$html = new html("register", array("../css/register.css", "../css/form.css"), true);

$html->buildTop();

$html->tag("div",  //headerWrapper
	$html->gTag("div", //header
		
		$html->gTag("div", //logo
			$html->gTag("a","<img class='logo' src='../images/small-logo.png' /> ",array("href"=>"../frontpage/main.php"))
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
			$html->gTag("a"," <img src='../images/cart.png' /> " . getCartCount(),
			array("href"=>"#", "class"=>"cart")) .
			$html->gTag("div", "" , array())
		,array("id"=>"cart"))
	
	, array("id"=>"header"))
, array("id"=>"headerWrapper"));

$html->tag("div", //bodyWrapper
	$html->gTag("div", //body
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
						 		'<label for="name"> First Name:</label>
	                            <input type="text" id="name" name="firstname" placeholder="Enter your first name" />','
						 		<label for="name">Last Name</label>
	                            <input type="text" id="name" name="lastname" placeholder="Enter your last name" />','
	                            <label for="name">Street Address</label>
	                            <input type="text" id="name" name="address" placeholder="Enter your street address" />', '
	                            <label for="name">City</label>
	                            <input type="text" id="name" name="city" placeholder="Enter your city" />','
	                            <label for="name">Zip</label>
	                            <input type="text" id="name" name="zip" placeholder="Enter your ZIP code" />','
	                            <label for="name">Email</label>
	                            <input type="text" id="name" name="email1" placeholder="Enter your email address" />','
	                            <label for="name">Confirm Email</label>
	                            <input type="text" id="name" name="email2" placeholder="Confirm your email address" />','
	                            <label for="email">Password</label>
	                            <input type="password" id="email" name="password1" placeholder="Enter your password" />','
	                            <label for="email">Confirm Password</label>
	                            <input type="password" id="email" name="password2" placeholder="Confirm your password" />')).
						 		$html->gTag("input", "", array("id"=>"cartBtn", "type"=>"submit", "value"=>"Sign up"))
					 		,array("action"=>"registerCheck2.php", "method"=>"post"))
					, array("id"=>"contact")) .
					$html->gTag("span", 
						$html->gTag("img", "", array("src"=>"../images/form-footerbg.png"))
					,array())
				, array("id"=>"content"))
			,array("id"=>"mainContact"))
		,array("id"=>"mainWrapper")) 
		/*
		$html->gTag("form", //form
			$html->gTag("input", "Firstname", array("type"=>"text", "name"=>"firstname")) .
			$html->gTag("br", "") .
			$html->gTag("input", "Lastname", array("type"=>"text", "name"=>"lastname")) .
			$html->gTag("br", "") .
			$html->gTag("input", "Streetaddress", array("type"=>"text", "name"=>"address")) .
			$html->gTag("br", "") .
			$html->gTag("input", "City", array("type"=>"text", "name"=>"city")) .
			$html->gTag("br", "") .
			$html->gTag("input", "Zip", array("type"=>"text", "name"=>"zip")) .
			$html->gTag("br", "") .
			$html->gTag("input", "Email", array("type"=>"text", "name"=>"email1")) .
			$html->gTag("br", "") .
			$html->gTag("input", "Re-enter Email", array("type"=>"text", "name"=>"email2")) .
			$html->gTag("br", "") .
			$html->gTag("input", "Password", array("type"=>"password", "name"=>"password1")) .
			$html->gTag("br", "") .
			$html->gTag("input", "Re-Enter Password", array("type"=>"password", "name"=>"password2")) .
			$html->gTag("br" ,"") .
			$html->gTag("input", "", array("type"=>"submit", "value"=>"Register"))
		
		,array("method"=>"post", "action"=>"registerCheck2.php", "id"=>"registerForm", "style"=>"float:left;"))
		*/
	
	,array("id"=>"body"))
,array("id"=>"bodyWrapper"));



$html->tag("div",
	$html->gTag("div", 
		"<p>&copy; ". date("Y") ." Kamazon Online Bookstore</p>"
	,array("id"=>"footer"))
,array("id"=>"footerWrapper"));

$bottomArray = array("id"=>"bottom");
$html->tag("div", "", $bottomArray);

$html->buildBottom();

echo($html->getPage());
if(isset($_SESSION['error'])){
	echo $_SESSION['error'];
	unset($_SESSION['error']);
}


?>
