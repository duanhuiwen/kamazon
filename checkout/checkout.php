<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kamazon Bookstore</title>
<link rel="stylesheet" type="text/css" href="../css/page.css" />
<link rel="stylesheet" type="text/css" href="../css/form.css" />


</head>

<body>
<?php
session_start();
include_once("../common/dbConnect.php");
include_once("../common/dbFunctions.php");
include_once("../common/functions.php");
include_once("../phpClasses/Html.class.php");
include_once("../shopping_cart/cart.php");
include_once("../common/regEx.php");




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
            	<img src="../images/thankyou.png" />
            </div>
            
            <div id="mainWrapper">
            <span><img src="../images/pageblock-header.png" /></span>
            <div id="main">
                
                <div id="contentCheckout">
                	<div class="checkout">
                    <h2 >Shopping Cart</h2>
<table id="lineItems">
	<thead>
    	<tr class="cartItemsHeader">
        	<th class="itemNameHeader"> Book </th>
            <th class="itemCodeHeader" > Code</th>
            <th class="itemQuantityHeader"> Quantity</th>
            <th class="itemPriceHeader"> Price </th>
            <th class="itemInfoHeader"> Info</th>
            <th class="itemSubtotalHeader"> Total </th>
            <th class="itemRemoveHeader"> Edit </th>
        </tr>
    </thead>
    <tbody>
	<!-- php dynamic part-->
	<?php
		
		if($_SESSION['valid']!= null){
			if(isset($_SESSION['cart'])){
					echo listCheckOutBooks($DBH);
			}
		}
	
	?>

    <!--end php dynamic part-->        
        
    </tbody>
</table>



                    </div><!--endCheckout-->
					<div id="confirm">
					<?php
		
					if($_SESSION['valid']!= null){
					if(isset($_SESSION['cart'])){
					echo items($html, $DBH);
					}
					}
	
					?>

					</div>
                    
                    

                </div><!--endContentCheckout-->
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
