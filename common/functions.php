<?php

/*function __autoload($className){
	require_once('../phpClasses/' . $className . '.class.php');
}
*/
include_once("../common/dbConnect.php");
include_once("../common/dbFunctions.php");
include_once("../common/functions.php");
include_once("../phpClasses/Html.class.php");
include_once("../shopping_cart/cart.php");
include_once("../common/regEx.php");
//This works in 5.2.3
//First function turns SSL on if it is off.
//Second function detects if SSL is on, if it is, turns it off.

//==== Redirect... Try PHP header redirect, then Java redirect, then try http redirect.:
function redirect($url){
	if (!headers_sent()){    //If headers not sent yet... then do php redirect
		header('Location: '.$url); exit;
	}else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
		echo '<script type="text/javascript">';
		echo 'window.location.href="'.$url.'";';
		echo '</script>';
		echo '<noscript>';
		echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
		echo '</noscript>'; exit;
	}
}//==== End -- Redirect

//==== Turn on HTTPS - Detect if HTTPS, if not on, then turn on HTTPS:
function SSLon(){
	if($_SERVER['HTTPS'] != 'on'){
		$url = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		redirect($url);
	}
}//==== End -- Turn On HTTPS

//==== Turn Off HTTPS -- Detect if HTTPS, if so, then turn off HTTPS:
function SSLoff(){
	if($_SERVER['HTTPS'] == 'on'){
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		redirect($url);
	}
}//==== End -- Turn Off HTTPS

//uses regular expressions to check email and password, sets session variable
//$inout decides if user is logging in(true) or out(false),
function logInOut($mail, $psw, $DBH, $inOut){
	$userEmail = $mail;
	$userPassword = $psw;
	if($inOut){
		if(isset($userEmail)){
			if(isset($userPassword)){
				if(preg_match('/'.$emailExp.'/',$userEmail)){
					if(preg_match('/'.$pwdExp.'/',$userPassword)){
						if(check_user($userEmail, $userPassword, $DBH)){
							//sets session as valid, initializes cart and serializes it
							// gets username and checks if user is admin
							$_SESSION['valid'] = true;
							$cart = new Cart();
							$_SESSION['cart'] = serialize($cart);
							
							$STH = $DBH->query("SELECT Firstname, CustomerId FROM customers WHERE Email='$userEmail'");
							$STH->setFetchMode(PDO::FETCH_NUM);
							$name = $STH->fetch();
							
							// name and customerId are used throughout the site
							$_SESSION['name'] = $name[0];
							$_SESSION['customerId'] = $name[1]; 
							
							//
							if($userEmail == "kalaveijo@gmail.com"){
								$_SESSION['admin'] = true;
							}

							
						}else{
							$_SESSION['valid'] = false;
						}
					}
				}
			}
		}
	}else{
		$_SESSION['valid'] = false;
	}
}

/* not in use anymore, see new loginHandler()
// Creates login screen. Needs HTML object where to push info
function loginHandler($html){
$formid = array("id"=>"login");
//attributes $action, $method, $formattributes
$html->startForm("../common/loginCheck.php", "post", $formid);

if(!$_SESSION['valid']){
//making 2 input lines and submit button
$email = array("type"=>"text" , "name"=>"email");
$html->tag("input", "Email", $email);
$password = array("type"=>"password" , "name"=>"password");
$html->tag("input", "Password", $password);
$submit = array("type"=>"submit" , "value"=>"login");
$html->tag("input", "", $submit);
}else{
	$hidden = array("type"=>"hidden" , "name"=>"logout");
	$html->tag("input", "", $hidden);
	$logout = array("type"=>"submit" , "value"=>"logout");
	$html->tag("input", "", $logout);
}
$html->endForm();


}
*/

function loginHandler($html){
	 $temp;
	
	 //checks if user should be given login screen or logoutscreen
	 if(!$_SESSION['valid']){
		$temp .= $html->gTag("form",
		 	$html->gTag("input", "", array("type"=>"text", "name"=>"email", "placeholder"=>"Email")) .
		 	$html->gTag("input", "", array("type"=>"password", "name"=>"password", "placeholder"=>"Password")) .
		 	$html->gTag("input", "", array("type"=>"submit", "value"=>"Login", "id"=>"cartBtn"))
		 ,array("method"=>"post", "action"=>"../common/loginCheck.php", "id"=>"login"));
	 }else{
	 	$temp .= $html->gTag("form",
	 	$html->gTag("div", $_SESSION['name'], array("id"=>"username")) .
	 	$html->gTag("input", "", array("type"=>"hidden", "name"=>"logout")) .
	 	$html->gTag("input", "", array("type"=>"submit", "value"=>"Logout"))
	 	
	 	,array("method"=>"post", "action"=>"../common/loginCheck.php", "id"=>"login"));
	 	
	 }
	 return $temp;
}

// needs html and DBH objects, returns html code 
/* Not in use anymore
function fetchNewBooks($dbh){
	$return;
	$sql = "SELECT * FROM products WHERE CategoryId=0";
	$STH = $dbh->query($sql);
	$STH->setFetchMode(PDO::FETCH_NUM);
	$i = 0;
	
	while($row = $STH->fetch()){
	if($i < 9){
	
	
		if($i == 0 || $i == 3 || $i == 6){
			$return .= '<ul class="newBookCol">';
		}
		
		$return .= '<li class="item"><a href="item.php?ProductISBN='.$row[0].'"  title=""><img src="../images/'. rand(1, 5) . '.jpg"/></a>
                                        <div id="bookDetails">
                                                <h3><a item.php?ProductISBN='.$row[0].'">'. $row[1] .'</a></h3>
                                                <span class="author">'. $row[2] .'</span>
                                                
                                        </div>
                                        <div id="priceBox">
                                                <span class="priceLabel">Price : '. $row[4] .'e</span>
                                        </div></li>';
		
		if($i == 2 || $i == 5 || $i == 8){
			$return .= '</ul>';
		}
	}
	$i++;
	}
	
	
	return $return;
}*/

//fetches 9 entries from database and formats them under <UL>, needs $DBH as parameter
function fetchNewBooks($dbh){
	$fetchHolder = array();
	$return;
	$sql = "SELECT * FROM products WHERE CategoryId=0";
	$STH = $dbh->query($sql);
	$STH->setFetchMode(PDO::FETCH_NUM);
	$i = 0;
	
	//fetching rows into array to make multidimensional array
	while($row = $STH->fetch()){
		$fetchHolder[$i] = $row;
		$i++;
	}
	rsort($fetchHolder);
	$i = 0;
	while($i < 9){

	
	
		if($i == 0 || $i == 3 || $i == 6){
			$return .= '<ul class="newBookCol">';
		}
		
		$return .= '<li class="item"><a href="../product/item.php?ProductISBN='.$fetchHolder[$i][0].'"  title=""><img src="../images/books_pics/'. $fetchHolder[$i][5]. '.jpg" width="80" height="102"/></a>
                                        <div id="bookDetails">
                                                <h3><a href="../product/item.php?ProductISBN='.$fetchHolder[$i][0].'">'. $fetchHolder[$i][1] .'</a></h3>
                                                <span class="author">'. $fetchHolder[$i][2] .'</span>
                                                
                                        </div>
                                        <div id="priceBox">
                                                <span class="priceLabel">Price : '. $fetchHolder[$i][4] .'e</span>
                                        </div></li>';
		
		if($i == 2 || $i == 5 || $i == 8){
			$return .= '</ul>';
		}
	
	$i++;
	}
	
	
	return $return;
}
/* Not in use anymore
function fetchComingBooks($dbh){
	$return;
	$sql = "SELECT * FROM products WHERE CategoryId=4";
	$STH = $dbh->query($sql);
	$STH->setFetchMode(PDO::FETCH_NUM);
	$i = 0;
	
	while($row = $STH->fetch()){
	if($i < 9){
	
	
		if($i == 0){
			$return .= '<ul class="bookSlide">';
		}
		
		$return .= '<li class="item"><a href="view.php?ProductISBN='.$row[0].'" title=""><img src="../images/'. rand(1, 5) . '.jpg"/></a>
                                        <div id="bookDetails">
                                                <h3><a href="view.php?ProductISBN='.$row[0].'">'. $row[1] .'</a></h3>
                                                <span class="author">'. $row[2] .'</span>
                                                
                                        </div>
                                        <div id="priceBox">
                                                <span class="priceLabel">Price : '. $row[4] .'e</span>
                                        </div></li>';
		
		if($i == 8){
			$return .= '</ul>';
		}
	}
	$i++;
	}
	
	
	return $return;
}*/
//fetches 9 entries from database and formats them under <UL>, needs $DBH as parameter
function fetchComingBooks($dbh){
	$fetchHolder = array();
	$return = "<h2>Coming soon</h2>";
	$sql = "SELECT * FROM products WHERE CategoryId=4";
	$STH = $dbh->query($sql);
	$STH->setFetchMode(PDO::FETCH_NUM);
	$j = 0;
	
	while($row = $STH->fetch()){
		$fetchHolder[$j] = $row;
		$j++;
	}
	rsort($fetchHolder);
	$i = 0;
	while($i < $j){
	
	
		if($i == 0){
			$return .= '<ul class="bookSlide">';
		}
		
		$return .= '<li class="item"><a href="../product/item.php?ProductISBN='.$fetchHolder[$i][0].'" title=""><img src="../images/books_pics/'. $fetchHolder[$i][5]. '.jpg" width="80" height="102"/></a>
                                        <div id="bookDetails">
                                                <h3><a href="../product/item.php?ProductISBN='.$fetchHolder[$i][0].'">'. $fetchHolder[$i][1] .'</a></h3>
                                                <span class="author">'. $fetchHolder[$i][2] .'</span>
                                                
                                        </div>
                                        <div id="priceBox">
                                                <span class="priceLabel">Price : '. $fetchHolder[$i][4] .'e</span>
                                        </div></li>';
		
		if($i == 8){
			$return .= '</ul>';
		}
	$i++;
	}
	return $return;
	}
	
	
	



//ProductISBN 	ProductName 	ProductDescription 	CategoryId 	ProductPrice 	ProductPicture 	UnitsInStock 	UnitesOnOrder
function addBookToDB($DBH, $isbn, $name, $description, $categoryId, $price, $picturefile = "none"){
	$STH = $DBH->exec("INSERT INTO products (ProductISBN, ProductName, ProductDescription, CategoryId, ProductPrice, ProductPicture)
						VALUES ('$isbn', '$name', '$description', $categoryId, '$price', '$picturefile')");
}

//returns multidimensional array with customers orders
function fetchOrdersByUser($email, $DBH){
	$returnArray = Array();
	$i = 0;
	$STH = $DBH->query("SELECT customers.Firstname, customers.Lastname, orders.Date, ordered_products.ProductISBN, ordered_products.QuantityOrdered
						FROM customers
						INNER JOIN orders
						ON customers.CustomerId=orders.CustomerId
						INNER JOIN ordered_products
						ON orders.OrderId = ordered_products.OrderId
						WHERE customers.Email='$email'");
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $STH->fetch()){
		$returnArray[$i] = $row;
		$i++;
	}
	return $returnArray;
}
//gets the latest orderId used in database and adds 1 to it, then inserts cart content into the database.needs $MA and $DBH as parameters
function confirmOrder($DBH, $MA){
$cart = unserialize($_SESSION['cart']);	
$STH = $DBH->query("SELECT OrderId from orders");
$STH->setFetchMode(PDO::FETCH_NUM);
$i = array();
$e = 0;
while($row = $STH->fetch()){
	$i[$e] = $row;
	$e++;
	}
$temp = count($i) +1;


$cartContents = $cart->get_contents();

for($i=0; $i<count($MA); $i++){
$statement = 'INSERT INTO ordered_products 
			(OrderId, ProductISBN, QuantityOrdered) 
				values("'.$temp.'","'.$MA[$i]['id'].'","'.$MA[$i]['qty'].'")';

$STH = $DBH->exec($statement);
}

$statement = 'INSERT INTO orders 
			(OrderId, CustomerId, Date) 
				values("'.$temp.'","'.$_SESSION['customerId'].'","'.date(Y.m.d).'")';
$STH = $DBH->exec($statement);

$cart->empty_cart();
$_SESSION['cart'] = serialize($cart);

}


function listCheckOutBooks($DBH){


$temp;
$cart = unserialize($_SESSION['cart']);
if($cart->itemcount > 0) {
					foreach($cart->get_contents() as $item)
					{
						
				
					$category ; 
					$temp .=
					'<tr>
						<td class="itemName"> 
							<a href="../product/add.php?ProductISBN='.$item['id'].'">
							<img src="../images/books_pics/'.fetchPic($DBH,$item['id']).'.jpg" width="40px" height="60px"/>
							</a>
							<br/><br/>
							<strong>'.$item['info'].'</strong><td class="itemCode">'.$item['id'].'
						</td>
						<td class="itemQuantity">'.$item['qty'].'</td>
						<td class="itemPrice"> '.$item['price'].' &euro;</td>
						<td class="itemCate"> '.$item['info'].' </td>
						<td class="itemSubtotal"> '.$item['subtotal'].'&euro;</td>
						<td class="itemRemove">
							<form method="post" action="handler.php">
							<input type="hidden" name="id" value='.$item['id'].'/>
							<input type="submit" name="remove" value="Remove"/>
							</form>
						</td>
					</tr>'; 
							
					}
					
					} else {
					$temp .='<tr>
						<td class="itemName"> 
							<strong>No items in cart</strong>
						</td>
						<td class="itemQuantity"></td>
						<td class="itemPrice"></td>
						<td class="itemCate"></td>
						<td class="itemSubtotal"></td>
						<td class="itemRemove"></td>
					</tr>'; 
					}
					$temp .= '<tr>
					<td></td><td></td><td></td><td></td><td><p>TOTAL</p></td><td>'.number_format($cart->total,2).' &euro;</td>
					<td class="itemRemove">
					<form method="post" action="handler.php">
					<input type="hidden" name="unset" value="unset"/>
					<input type="submit" name="empty Cart" value="Empty Cart"/>
					</form>
					</td>
					</tr>';
					
					return $temp;
					
$_SESSION['cart'] = serialize($cart);

}


//fetch all the books from db , list them on the product.php
function listAllBooks($dbh){
	$return;
	$sql = "SELECT * FROM products ";
	$STH = $dbh->query($sql);
	$STH->setFetchMode(PDO::FETCH_NUM);
	$i = 0;

	while($row = $STH->fetch()){


	
		if($i%3 == 0){
			$return .= '<ul class="newBookCol">';
		}
		
		$return .= '<li class="item"><a href="item.php?ProductISBN='.$row[0].'"  title=""><img src="../images/books_pics/'. $row[5]. '.jpg"  width="80" height="102"/></a>
                                        <div id="bookDetails">
                                                <h3><a  href="item.php?ProductISBN='.$row[0].'">'. $row[1] .'</a></h3>
                                                <span class="author">'. $row[2] .'</span>
                                                
                                        </div>
                                        <div id="priceBox">
                                                <span class="priceLabel">Price : '. $row[4] .'e</span>
                                        </div></li>';
		
		if(($i-2)%3 == 0){
			$return .= '</ul>';
		}
	
	$i++;
	}
	
	
	
	return $return;
	
}



//returns contents from cart and confirms orders, needs $html and $DBH as parameters.
function items($html, $DBH)
{
$temp;
$cart = unserialize($_SESSION['cart']);
if($cart->itemcount > 0) {
					
					$temp ='<p>Your order will be processed immediatley upon approval.
					At that time, an email confirmation will be sent to the email address you provided.
					Should you have any questions, please contact us at support@kamazon.com. Thank you! </p>
					<form method="post" action="handler.php">
					<input type="hidden" name="send" value="1"/>
					<input type="hidden" name="unset" value="unset"/>
					<input type="submit" name="send order" value="Confirm Order"/>
					</form>
					</a>';
					
					return	$temp;
$_SESSION['cart'] = serialize($cart);
}
}


function fetchBookDescription($dbh,$ProductISBN){

	$return = "<p>";
	$row = selectBookByISBN($dbh,$ProductISBN);
	$return .= $row[2]. "</p>";
	echo $return ;
	//echo "<script>alert('Information updated')</script>";
}

function fetchTitle($dbh,$ProductISBN){
	
	$row = selectBookByISBN($dbh,$ProductISBN);
	echo $row[1];

}

function fetchISBN($dbh,$ProductISBN){
	
	$row = selectBookByISBN($dbh,$ProductISBN);
	
	echo $row[0];

}

function fetchPrice($dbh,$ProductISBN){
	
	$row = selectBookByISBN($dbh,$ProductISBN);
	echo $row[4];

}
function fetchPic($dbh,$ProductISBN){
	$row = selectBookByISBN($dbh,$ProductISBN);
	return $row[5];
}

function selectBookByISBN($dbh,$ProductISBN){
	$sql = "SELECT * FROM products WHERE ProductISBN = $ProductISBN ";
	$STH = $dbh->query($sql);
	$STH->setFetchMode(PDO::FETCH_NUM);
	$row = $STH->fetch();
	return $row;
}

function fetchCategoryName($CategoryId){
	switch($CategoryId){
		case 0:
			return "New Books";
		case 1:
			return "Romance";
			
		case 2:
			return "Fiction";
			
		case 3:
			return "Fantasy";
			
		case 5:
			return "Horror";
		case 6:
			return "Teenager";
	}
}

//returns html code of all items in one certain category, needs $DBH and required categoryId
function fetchBookByCategory($dbh,$CategoryId){
						
	$sql = "SELECT * FROM products WHERE CategoryId = $CategoryId ";
	$STH = $dbh->query($sql);
	$STH->setFetchMode(PDO::FETCH_NUM);
	while($row = $STH->fetch()){
	echo 				'<li>
                            <div class="image" id="medium">
                                <a  href="item.php?ProductISBN='.$row[0].'"><img src="../images/books_pics/'.$row[5].'.jpg" alt="cover" width="150" height="200" /></a>
                            </div>
                            
                            <div id="intro-text">
                                <a href="item.php?ProductISBN='.$row[0].'"><h3>'.$row[1].'</h3></a>
                                
                                <p>ISBN: '.$row[0].'</p>
                                <h5>Price: '.$row[4].'&euro; </h5>   
                                
                            </div>
                        </li>';          
	
	}
              

}

//checks if cart exists, then gets itemcount and returns it
function getCartCount(){
	$return = '';
	 if(isset($_SESSION['cart'])){
	 	$cart = unserialize($_SESSION['cart']);
	 	$return = "(" . $cart->itemcount . ")";
	 	$_SESSION['cart'] = serialize($cart);
	 }
	 return $return;
}





?>
