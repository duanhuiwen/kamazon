<?php
// checks users credentials against regEx, sends data to database or faults if something breaks
session_start();

include_once("../common/dbConnect.php");
include_once("../common/dbFunctions.php");
include_once("../common/functions.php");
include_once('../common/regEx.php');


$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$address = $_POST['address'];
$city = $_POST['city'];
$zip = $_POST['zip'];
$email1 = $_POST['email1'];
$email2 = $_POST['email2'];
$psw1 = $_POST['password1'];
$psw2 = $_POST['password2'];



// used to keep track that if something fails
$fail = false;


//check email
if($email1 == $email2)
{
 $sql ="select * from customers WHERE Email='$email1';";
 $STH = @$DBH->query($sql);
 $STH->setFetchMode(PDO::FETCH_NUM);
 $rowCount = $STH->rowCount();
 //check if the email has been used.
 if($rowCount == 1){
 	//$_SESSION['error'] is used to pass errors between pages
	$_SESSION['error'] = "This Email address has been registered once! " ;
	$fail = true;
	}
//if not been used, check the validity.
	else{
		if(preg_match('/'.$emailExp.'/',$email1)){
			
		}else if($email1 == ""){
			$_SESSION['error'] .= 'No Email provided ';
			$fail = true;
		}
		else{
			$_SESSION['error'] .= 'not a valid Email address ';
			$fail = true;
		}
	}
}else{
	$_SESSION['error'] .= 'Emails not same';
	$fail = true;
}


//check password
if($psw1 == $psw2)
{
	if( preg_match('/'.$pwdExp.'/',$psw1)){
		
	}else if($psw1 == ""){
		$_SESSION['error'] .= '(At least 8 character) ';
		$fail = true;
	}
	else{
		$_SESSION['error'] .= 'password not ok ';
		$fail = true;
	}

}else{
	$_SESSION['error'] .= 'no pass';
	$fail = true;
}
//checking validity of firstname
if($fname){
	if( preg_match('/'.$nameExp.'/',$fname)){
		
	}else{
		$_SESSION['error'] .= 'not valid firstname ';
		$fail = true;
	}
}else{
	$_SESSION['error'] .= 'no firstname';
	$fail = true;
}

// checking validity of lastname
if($lname){
	if( preg_match('/'.$nameExp.'/',$lname)){
		
	}else{
		$_SESSION['error'] .= 'not valid lastname ';
		$fail = true;
	}
}else{
	$_SESSION['error'] .= 'no lastname ';
	$fail = true;
}

// checking validity of zip
if($zip){
	if( preg_match('/'.$zipExp.'/',$zip)){
		
	}else{
		$_SESSION['error'] .= 'not valid zip ';
		$fail = true;
	}
}else{
	$_SESSION['error'] .= 'no zip ';
	$fail = true;
}

// checking validity of address
if($address){
	if( preg_match('/'.$nameExp.'/',$address)){
		
	}else{
		$_SESSION['error'] .= 'not valid lastname ';
		$fail = true;
	}
}else{
	$_SESSION['error'] .= 'no lastname ';
	$fail = true;
}

// checking validity of city
if($city){
	if( preg_match('/'.$nameExp.'/',$city)){
		
	}else{
		$_SESSION['error'] .= 'not valid city ';
		$fail = true;
	}
}else{
	$_SESSION['error'] .= 'no city ';
	$fail = true;
}

//if everythings correct, insert into latest database entry
if(!$fail){
	$_SESSION['error'] .= 'success';
	
	//checks which one is latest entry. Assuming no entries have been deleted
	$STH = $DBH->query("SELECT CustomerId from customers");
	$STH->setFetchMode(PDO::FETCH_NUM);
	$i = array();
	$e = 0;
	while($row = $STH->fetch()){
		$i[$e] = $row;
		$e++;
	}
	//counts amount of old rows and adds it to temp + 1
	$temp = count($i) + 1;
	
	//hashes password
	$psw1 = hash('sha256', $psw1);
	
	//inserts everything into database
	try{$DBH->exec("INSERT INTO customers VALUES ($temp, '$fname', '$lname', '$address', '$email1', '$city', '$zip', '$psw1') ");
	}catch(Exception $e){
		echo $e;
	}
}

redirect("register.php");

?>
