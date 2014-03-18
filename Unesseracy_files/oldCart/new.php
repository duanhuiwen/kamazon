 <html>
 <head>
 <title>New Record</title>
 </head>
 <body>
 <?php 
 // creates the new record form
 function renderForm($product, $price, $description, $category, $error)
 {
 // if there are any errors, display them
 if ($error != '')
 {
 echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
 }
 ?> 
 
 <form action="" method="post">
 <div>
 <strong>Product: *</strong> <input type="text" name="product" value="<?php echo $product; ?>" /><br/>
 <strong>Price: *</strong> <input type="text" name="price" value="<?php echo $price; ?>" /><br/>
 <strong>Description: *</strong> <input type="text" name="description" value="<?php echo $description; ?>" /><br/>
 <strong>Category: *</strong> <input type="text" name="category" value="<?php echo $category; ?>" /><br/>
 <p>* required</p>
 <input type="submit" name="submit" value="Submit">
 </div>
 </form> 
 </body>
 </html>
 <?php 
 }
  // connect to the database
 require_once('../common/dbConnect.php');
 
 // check if the form has been submitted then saves it to the database
 if (isset($_POST['submit']))
 { 
 // get form data, making sure it is valid
 $product = mysql_real_escape_string(htmlspecialchars($_POST['product']));
 $price = mysql_real_escape_string(htmlspecialchars($_POST['price']));
 $description = mysql_real_escape_string(htmlspecialchars($_POST['description']));
 $category = mysql_real_escape_string(htmlspecialchars($_POST['category']));
 
 // check to make sure all fields are entered
 if ($product == '' || $price == '' || $description == '' || $category == '')
 {
 // generate error message
 $error = 'ERROR: Please fill in all required fields!';
 
 // if one field is blank, display the form again
 renderForm($product, $price, $description, $category, $error);
 }
 else
 {
 // save the data to the database
 mysql_query("INSERT lab3 SET product='$product', price='$price', description='$description', category='$category'")
 or die(mysql_error()); 
 
 // once saved, redirect back to the view page
 header("Location: view.php"); 
 }
 }
 else
 // if the form hasn't been submitted, display the form
 {
 renderForm('','','','','');
 }
?> 