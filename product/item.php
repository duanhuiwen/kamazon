<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kamazon Bookstore</title>
<link rel="stylesheet" type="text/css" href="../css/page.css" />


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
            	<a href="../frontpage/main.php"><img src="../images/small-logo.png" class="logo" /></a>
            </div><!-- endLogo -->
            
            <div id="navbar">
                 <ul>
                    <li><a href="../frontpage/main.php">Sign in</a></li>
                    <li><a href="../register/register.php" class="nav">Register</a></li>
                    <li><a href="../product/products.php" class="nav">Books</a></li>
                    <li><a href="../checkout/checkout.php" class="nav">Check out</a></li>
                 </ul>
            </div><!-- endNavbar -->
            
            <div id="cart">
            	<a href="#" class="cart"><span><img src="../images/cart.png" /></span> <?php echo(getCartCount()); ?></a>      
            </div><!-- endCart --> 
        </div> <!-- endHeader -->
    </div><!-- endHeaderWrapper -->
    
    <div id="bodyWrapper">
        <div id="body">
        
        	<div id="welcome">
            	<img src="../images/welcome.png" />
            </div>
            
            <div id="mainWrapper">
            <span><img src="../images/pageblock-header.png" /></span>
            <div id="main">
            	<div id="sidebar">
                	<h2>Subjects</h2>
                    <ul class="subjects">
						<li><a href="category.php?CategoryId=0">New Books</a></li>
                    	<li><a href="category.php?CategoryId=1">Romance</a></li>
                        <li><a href="category.php?CategoryId=2">Fiction</a></li>
                        <li><a href="category.php?CategoryId=3">Fantasy</a></li>  										
                        <li><a href="category.php?CategoryId=5">Horror</a></li>
                        <li><a href="category.php?CategoryId=6">Teenager</a></li>
                    
                    </ul>
                </div>
                
                <div id="content">
                	<div id="breadcrumb">
                	<a href="../frontpage/main.php">Home</a> > <a href="products.php">Books</a> > 
					<!--dynamic fetch smaller text title-->
					<a>
					<?php
					fetchTitle($DBH,$ProductISBN);
					?>
					
					</a>
					<!--dynamic fetch title end-->
                    </div>
                    
                    <div id="introduction">
                    	<div id="image">
							<!--dynamic fetch book pic -->
							
							<?php
							echo '<img src="../images/books_pics/'.fetchPic($DBH,$ProductISBN).'.jpg" alt="cover" width="300" height="420" />';
							
							?>
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
                <span><img src="../images/pageblock-footer.png" /></span>
                
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
