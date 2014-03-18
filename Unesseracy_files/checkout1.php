<?php
// checkout page for website, contains delivery info and personal info form
session_start();


include_once('../common/dbConnect.php');
include_once('../common/dbFunctions.php');
include_once('../common/regEx.php');
include_once('../common/functions.php');
include_once('../shopping_cart/cart.php');
include_once('../phpClasses/Html.class.php');

/*
if (!(isset($_SESSION['valid']) && $_SESSION['valid'] != '')) {
	//header ("Location: login.php");
	redirect("../frontpage/main.php");
}
*/
if ($_SESSION['valid'] != null){
$html = new html("Admin", array("../css/page.css", "../css/form.css"), true);

$html->buildTop();

$html->tag("div",  //headerWrapper
	$html->gTag("div", //header
		
		$html->gTag("div", //logo
			$html->gTag("a","<img class='logo' src='../images/small-logo.png' />",array("href"=>"../frontpage/main.php"))
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
			$html->gTag("a"," <img src='../images/cart.png' />", array("href"=>"#", "class"=>"cart")) .
			$html->gTag("div", loginHandler($html), array("id"=>"temp")).
			$html->gTag("div", "" , array())
		,array("id"=>"cart"))
	
	, array("id"=>"header"))
, array("id"=>"headerWrapper"));
//end of head
$html->tag("div", //bodywrapper
	$html->gTag("div", //body
	$html->gTag("div",
	$html->gTag("div", //mainWrapper 
			$html->gTag("img", "", array("src"=>"../images/thankyou.png"))
		, array("id"=>"welcome")) .
		$html->gTag("div", //leftcontent
			
			$html->gTag("div", //checkout
				$html->gTag("div", "<h1>Items in cart</h1>" . items($html, $DBH)
					
				,array("class"=>"checkout"))
				
				,array("id"=>"itemInCart")) 
			
			/* Will be acquired dynamically */
			/*$html->gTag("div", //comingSoon
			
				$html->gTag("div",
					fetchComingBooks($DBH)
				,array("class"=>"bookSlide"))
			
			,array("id"=>"comingSoon"))*/
			
		,array("id"=>"leftContent")) .
		
		$html->gTag("div",  //rightContent
		
			$html->gTag("div", '
			<span><img src="../images/rec-top.png" width="262" height="15"/></span>
			<div id="rec"><h2>Recommendation</h2>
			<ul class="recommend">
			<li><a href="#" class="recommend">New Releases</a></li>
			<li><a href="#" class="recommend">Top 100 Best Seller of 2011</a></li>
			<li><a href="#" class="recommend">Best Books of the month 11/2011</a></li>
			<li><a href="#" class="recommend">Kamazon Recommendation</a></li>
			</ul>
			</div>
			<span ><img src="../images/rec-foot.png" width="262" height="15"/></span>'
			,array("id"=>"wrapperRecommend")) .
			
			$html->gTag("div",'
					<h2>Subjects</h2>
                    <ul class="subjects">
                    	<li><a href="#">Romance</a></li>
                        <li><a href="#">Fiction</a></li>
                        <li><a href="#">Fantasy</a></li>
                        <li><a href="#">Education</a></li>
                        <li><a href="#">Technology</a></li>
                        <li><a href="#">Medical</a></li>
                        <li><a href="#">Horror</a></li>
                        <li><a href="#">Science</a></li>
                        <li><a href="#">Teenager</a></li>
                    </ul>
			',array("id"=>"subjects"))
		
		
		,array("id"=>"rightContent"))
		,array("id"=>"mainWrapper")) 
	,array("id"=>"body"))
, array("id"=>"bodyWrapper"));

$html->tag("div",
	$html->gTag("div", 
		"<p>&copy; ". date("Y") ." Kamazon Online Bookstore</p>"
	,array("id"=>"footer"))
,array("id"=>"footerWrapper"));

$bottomArray = array("id"=>"bottom");
$html->tag("div", "", $bottomArray);

$html->buildBottom();

echo($html->getPage());
}else{
	//echo "<script>alert('login please')</script>";
	redirect("../frontpage/main.php");
	
}



?>