<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Kamazon Bookstore</title>

<link media="screen" type="text/css" href="../HTML+CSS/style.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="../HTML+CSS/css/navbar.css" />

<link rel="stylesheet" type="text/css" href="../HTML+CSS/css/bookslide.css" />

<script type='text/javascript' src='http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js'></script>

<!-- script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js" type="text/javascript"></script -->



 <script>$(function() {



    var $el, leftPos, newWidth,

        $mainNav = $("#navbarList");



    $mainNav.append("<li id='magic-line'></li>");

    var $magicLine = $("#magic-line");



    $magicLine

        .width($(".currentPage").width())

        .css("left", $(".currentPage a").position().left)

        .data("origLeft", $magicLine.position().left)

        .data("origWidth", $magicLine.width());



    $("#navbarList li a").hover(function() {

        $el = $(this);

        leftPos = $el.position().left;

        newWidth = $el.parent().width();

        $magicLine.stop().animate({

            left: leftPos,

            width: newWidth

        });

    }, function() {

        $magicLine.stop().animate({

            left: $magicLine.data("origLeft"),

            width: $magicLine.data("origWidth")

        });

    });

});</script>



    <script type="text/javascript">

        var imgs = [

        '../HTML+CSS/images/banner1.png',

        '../HTML+CSS/images/banner2.png'];

        var cnt = imgs.length;



        $(function() {

            setInterval(Slider, 6000);

        });



        function Slider() {

        $('#imageSlide').fadeOut("slow", function() {

           $(this).attr('src', imgs[(imgs.length++) % cnt]).fadeIn("slow");

        });

        }

</script>





<script> 

 $(function(){

    //Get our elements for faster access and set overlay width

    var div = $('div.bookSlide'),

                 ul = $('ul.bookSlide'),

                 // unordered list's left margin

                 ulPadding = 15;



    //Get menu width

    var divWidth = div.width();



    //Remove scrollbars

    div.css({overflow: 'hidden'});



    //Find last image container

    var lastLi = ul.find('li:last-child');



    //When user move mouse over menu

    div.mousemove(function(e){



      //As images are loaded ul width increases,

      //so we recalculate it each time

      var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;



      var left = (e.pageX - div.offset().left) * (ulWidth-divWidth) / divWidth;

      div.scrollLeft(left);

    });

});</script>

   

</head>



<body>


<div id="wrapper">

    <div id="headerWrapper">

        <div id="header">

            <div id="logo">

            	<a href="index.html"><img src="../HTML+CSS/logo.png" class="logo" /></a>

                <p class="logo">your online bookstore & intimate resources</p>

            </div><!-- endLogo -->

            

            <div class="navbar">

                 <ul class="group" id="navbarList">

                    <li class="currentPage"><a href="#">Home</a></li>

                    <li><a href="index.html" class="nav">New Books</a></li>

                    <li><a href="index.html" class="nav">Log in</a></li>

                    <li><a href="index.html" class="nav">Register</a></li>

                    <li><a href="index.html" class="nav">Contact us</a></li>

                

                 </ul>

            </div><!-- endNavbar -->

            

            <div id="cart">

            	<a href="#" class="cart"><img src="../HTML+CSS/cart.png" /> 0 item(s)</a>

                <div id="searchBar">

                        	<form action="#">

                        	<input type="text" value="search books..." />

                            <input type="submit" value="Go" />

                            </form>

                        </div>

                  

            </div><!-- endCart -->



            

        </div> <!-- endHeader -->

    </div><!-- endHeaderWrapper -->
	<div id="bodyWrapper">

	<div>
		<table>
	<?php
	//session_start();
require_once('../common/functions.php');
require_once('../common/dbConnect.php');
require_once('../common/dbFunctions.php');
require_once('../phpClasses/Html.class.php');

		 listAllProducts($DBH)


	?>
		</table>
	</div>
	

	</div>  
	
</div>

    </body>
</html>