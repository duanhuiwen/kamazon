<?php
 // creates the edit record form
 function renderForm($id, $product, $price, $description, $category, $error)
 {
 ?>
 <html>
 <head>
 <title>Edit Record</title>
 </head>
 <body>
 <?php 
 // if there are any errors, display them
 if ($error != '')
 {
 echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
 }
 ?> 
 
 <form action="" method="post">
 <input type="hidden" name="id" value="<?php echo $id; ?>"/>
 <div>
 <p><strong>ID:</strong> <?php echo $id; ?></p>
 <strong>Product: *</strong> <input type="text" name="product" value="<?php echo $product; ?>"/><br/>
 <strong>Price: *</strong> <input type="text" name="price" value="<?php echo $price; ?>"/><br/>
 <strong>Description: *</strong> <input type="text" name="description" value="<?php echo $description; ?>" /><br/>
 <strong>Category: *</strong> <input type="text" name="category" value="<?php echo $category; ?>" /><br/>
 
 <p>* Required</p>
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
 // confirm that the 'id' value is a valid integer
 if (is_numeric($_POST['id']))
 {
 // get form data
 $id = $_POST['id'];
 $product = mysql_real_escape_string(htmlspecialchars($_POST['product']));
 $price = mysql_real_escape_string(htmlspecialchars($_POST['price']));
 $description = mysql_real_escape_string(htmlspecialchars($_POST['description']));
 $category = mysql_real_escape_string(htmlspecialchars($_POST['category']));
 
 
 // check that fields are filled in
 if ($product == '' || $price == '' || $description == '' || $category == '')
 {
 // if not shows error message
 $error = 'ERROR: Please fill in all required fields!';
 
 //error, display form again
 renderForm($id, $product, $price, $description, $category, $error);
 }
 else
 {
 // save the data to the database
 mysql_query("UPDATE lab3 SET product='$product', price='$price', description='$description', category='$category' WHERE id='$id'")
 or die(mysql_error()); 
 
 // after saving this redirect back to the view page
 header("Location: view.php"); 
 }
 }
 else
 {
 // if the 'id' isn't valid, display an error
 echo 'Error1';
 }
 }
 else
 // if the form hasn't been submitted, get the data from the db and display the form
 {
 
 // get the 'id' value from the URL, if it is valid(numeric and larger than 0)
 if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
 {
 // query db
 $id = $_GET['id'];
 $result = mysql_query("SELECT * FROM lab3 WHERE id=$id")
 or die(mysql_error()); 
 $row = mysql_fetch_array($result);
 
 // check that the 'id' matches up with a row in the database
 if($row)
 {
 
 // get data from db
 $product = $row['product'];
 $price = $row['price'];
 $description = $row['description'];
 $category = $row['category'];
 
 // show form
 renderForm($id, $product, $price, $description, $category, '');
 }
 else
 // if no match, display result
 {
 echo "No results!";
 }
 }
 else
 // if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
 {
 echo 'Error2';
 }
 }

?>