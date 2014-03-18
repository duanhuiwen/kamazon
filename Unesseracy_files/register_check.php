<?php
require_once('../common/dbConnect.php');
include_once('../common/regEx.php');

$pwd = null;
 



//check email
if(isset($_GET['email']))
{
 $email = $_GET['email'];
 $sql ="select * from users WHERE user='$email';";
 $STH = @$DBH->query($sql);
 $STH->setFetchMode(PDO::FETCH_NUM);
 $rowCount = $STH->rowCount();
 //check if the email has been used.
 if($rowCount == 1){
	echo "This Email address has been registered once!" ;
	}
//if not been used, check the validity.
	else{
		if(preg_match('/'.$emailExp.'/',$email)){
			echo '';
		}else if($email == ""){
			echo '';
		}
		else{
			echo 'not a valid Email address';
		}
	}
}




//check pwd
if(isset($_GET['password']))
{
	$pwd = $_GET['password'];
	if( preg_match('/'.$pwdExp.'/',$pwd)){
		echo '';
	}else if($pwd ==""){
		echo '(At least 8 character)';
	}
	else{
		echo 'password not ok';
	}

}









?>