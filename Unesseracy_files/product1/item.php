<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kamazon Bookstore</title>
<link rel="stylesheet" type="text/css" href="item_page/page.css" />


</head>

<body>
						<?php
						session_start();

						include_once("../common/dbConnect.php");
						include_once("../common/dbFunctions.php");
						include_once("../common/functions.php");
						include_once("../phpClasses/Html.class.php");
						$ProductISBN = $_GET['ProductISBN'];
						?>
<div id="wrapper">
    <div id="headerWrapper">
        <div id="header">
            <div id="logo">
            	<a href="main.php"><img src="item_page/images/small-logo.png" class="logo" /></a>
            </div><!-- endLogo -->
            
            <div id="navbar">
                 <ul>
                    <li><a href="signIn.hmtl">Sign in</a></li>
                    <li><a href="register.php" class="nav">Register</a></li>
                    <li><a href="products.php" class="nav">Books</a></li>
                    <li><a href="checkout.php" class="nav">Check out</a></li>
                 </ul>
            </div><!-- endNavbar -->
            
            <div id="cart">
            	<a href="#" class="cart"><span><img src="item_page/images/cart.png" /></span> 0 item(s)</a>      
            </div><!-- endCart --> 
        </div> <!-- endHeader -->
    </div><!-- endHeaderWrapper -->
    
    <div id="bodyWrapper">
        <div id="body">
        
        	<div id="welcome">
            	<img src="item_page/images/welcome.png" />
            </div>
            
            <div id="mainWrapper">
            <span><img src="item_page/images/pageblock-header.png" /></span>
            <div id="main">
            	<div id="sidebar">
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
                    	<li><a href="#">Children</a></li>
                        <li><a href="#">Travel</a></li>
                        <li><a href="#">Art</a></li>
                        <li><a href="#">Law</a></li>
                        <li><a href="#">Comic</a></li>
                        <li><a href="#">Politics</a></li>
                        <li><a href="#">Biography</a></li>
                        <li><a href="#">Business</a></li>
                        <li><a href="#">History</a></li>
                    
                    </ul>
                </div>
                
                <div id="content">
                	<div id="breadcrumb">
                	<a href="main.php">Home</a> > <a href="products.php">Books</a> > 
					<!--dynamic fetch smaller text title-->
					<a href="item5.php">
					<?php
					fetchTitle($DBH,$ProductISBN);
					?>
					
					</a>
					<!--dynamic fetch title end-->
                    </div>
                    
                    <div id="introduction">
                    	<div id="image">
							<!--dynamic fetch book pic -->
                        	<img src="item_page/cover1.jpg" alt="cover" width="300" height="420" />
							<!--dynamic fetch book pic end-->
                        </div>
                        
                        <div id="intro-text">
						<!--dynamic fetch book info -->
						<h5>
						<?php
						fetchTitle($DBH,$ProductISBN );
						?>
						</h5>
                        	
                        <p>						
						<?php
						//fetchAuthor($DBH);
						?>
						</p>
                        <p>
						ISBN: 
						
						<?php
						fetchISBN($DBH,$ProductISBN);
						?>
						</p>
                        <h5>
						Price: 
						<?php
						fetchPrice($DBH,$ProductISBN);
						?> 
						&euro; 
						</h5>
						<!--dynamic fetch book info -->
							<!--dynamic generate add to cart button -->
							<?php
							//$isbn = $_GET['ProductISBN'];
							
							echo '<a id="cartBtn" href="add.php?ProductISBN='.$ProductISBN.'" title="Add to Cart" >Add to Cart</a>';
							?>
                            <!--dynamic generate add to cart button  end-->
                            
                            
                        </div>
                    </div><!-- endIntroduction -->
                    
                    <div id="overview">
                    	<h3>Overview</h3>
						<!--dynamic generate book description -->
                        
						<?php
						

						
						fetchBookDescription($DBH,$ProductISBN);
						?>
						
						<!--dynamic generate book description end-->
                    </div><!--endOverview-->

                </div><!--endContent-->
                </div><!--endMain-->
                <span><img src="item_page/images/pageblock-footer.png" /></span>
                
            </div><!--endMainWrapper-->
        </div><!-- endBody -->
    </div><!-- endBodyWrapper -->
    
    <div id="footerWrapper">
        <div id="footer">
        	<p>&copy; 2011 Kamazon Online Bookstore</p>
        </div><!-- endFooter -->
    </div><!-- endFooterWrapper -->

</div><!-- endWrapper -->
</body>
</html>
