<?php

$host = 'mysql.metropolia.fi';//in xampp is localhost
$dbname = 'timopekk';
$username = 'timopekk';
$password = 'timopekk';


try {
	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(PDOException $e) {
	echo "Could not connect to database.";
	file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}

?>