<?php
session_start();

include_once("../common/dbConnect.php");
include_once("../common/dbFunctions.php");
include_once("../common/functions.php");

$isbn = $_POST['isbn'];
$name = $_POST['name'];
$description = $_POST['description'];
$category = $_POST['category'];
$price = $_POST['price'];
$file = $_POST['file'];

/*
$isbn = "154";
$name = "Angry Avians";
$description = "MAXIMUM FUCK";
$category = 4;
$price = 34;
$file = "";
*/

try{addBookToDB($DBH, $isbn, $name, $description, $category, $price, $file);
}catch(Exception $e){
	$_SESSION['error'] = $e;
}
redirect("admin.php");

?>
