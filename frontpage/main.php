<?php
// Main page for website, contains promotional info and links to
session_start();

include_once("../common/dbConnect.php");
include_once("../common/dbFunctions.php");
include_once("../common/functions.php");
include_once("../phpClasses/Html.class.php");

$html = new html("Main", array("../css/style.css", "../css/navbar.css"), true, true);

$html->buildTop();


$html->tag("div", 
	$html->gTag("div",
		
		//id=logo
		$html->gTag("div", 
			$html->gTag("a","<img class='logo' src='../images/logo.png' /> ",array("href"=>"main.php"))
		, array("id"=>"logo")) . // notice dot. Appending different gTags under header
		
		//id=navBar
		$html->gTag("div",
			$html->gBuildList(array(0=>"<a href='../frontpage/main.php'>Home</a>",
									1=>"<a href='../product/products.php' class='nav'>Products</a>",
									2=>"<a href='../register/register.php' class='nav'>Register</a>",
									3=>"<a href='../checkout/checkout.php' class='nav'>Checkout</a>"),			
									"ul",	
									array("class"=>"group", "id"=>"navbarList"))
		,array("class"=>"navBar")) . // notice dot. Appending different gTags under header
		
		//id=cart
		$html->gTag("div",
			$html->gTag("a"," <img src='../images/cart.png' />" . getCartCount(),
			array("href"=>"#", "class"=>"cart")) .
			$html->gTag("div", loginHandler($html) , array("id"=>"temp"))
		,array("id"=>"cart")) . // notice dot. Appending different gTags under header
		
		$html->gTag("div",
			"<div id='slogan'><img id='imageSlide' alt='' src='' /></div> "
		,array("id"=>"banner"))
	
	, array("id"=>"header"))
, array("id"=>"headerWrapper"));

//end of head

$html->tag("div", //bodywrapper
	$html->gTag("div", //body
		$html->gTag("div", //leftcontent
			
			$html->gTag("div", //newBooks
			
				/*This part will be downloaded dynamically*/
				$html->gTag("div", "<h2>NewBooks</h2>"  . fetchNewBooks($DBH) //newBookCol
				,array("class"=>"newBookCol"))
				
			,array("id"=>"newBooks")) .
			
			/* Will be acquired dynamically */
			$html->gTag("div", //comingSoon
			
				$html->gTag("div",
					fetchComingBooks($DBH)
				,array("class"=>"bookSlide"))
			
			,array("id"=>"comingSoon"))
			
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
                    	<li><a href="../product/category.php?CategoryId=0">New Books</a></li>
                    	<li><a href="../product/category.php?CategoryId=1">Romance</a></li>
                        <li><a href="../product/category.php?CategoryId=2">Fiction</a></li>
                        <li><a href="../product/category.php?CategoryId=3">Fantasy</a></li>                     
                        <li><a href="../product/category.php?CategoryId=5">Horror</a></li>
                        <li><a href="../product/category.php?CategoryId=6">Teenager</a></li>
                    </ul>
			',array("id"=>"subjects"))
		
		
		,array("id"=>"rightContent"))
		
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
?>