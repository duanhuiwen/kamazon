<?php

// Checks users credentials
function check_user($user, $pwd, $DBH) {
	$hashpwd = hash('sha256', $pwd);
	$sql = "SELECT * FROM customers WHERE Email='$user' AND
	password = '$hashpwd'";
	$STH = @$DBH->query($sql);
	if($STH->rowCount() > 0){
		return true;
	} else {
		return false;
	}
}


function productList($STH) {
	// FETCH_NUM gives out indexed arrays
	$STH->setFetchMode(PDO::FETCH_NUM);
	// Start the table
	$resultHTML = "<table border=\"1\">\n<tr>\n";

	// Output the table header
	$fieldCount = $STH->columnCount(); // number of columns

	for ($i=1; $i < $fieldCount; $i++) {
		//getColumnMeta($i) gets all metadata
		$meta = $STH->getColumnMeta($i); // names of the fields in asoc array
		$rowName = $meta['name'];
		$resultHTML .= "<th>$rowName</th>\n";
	} # end for

	$resultHTML .= "</tr>\n";

	// Output the table data
	while ($row = $STH->fetch()) {
		$resultHTML .= "<tr>\n";

		//scope of bracketless for/if/while/dowhile is one row and ends with ;
		for ($i = 1; $i < $fieldCount; $i++)
		$resultHTML .= "<td>".htmlentities($row[$i])."</td>\n";



		//? <-- puts stuff into url for GET method
		$resultHTML .= "<td><a href=\"?ID=". $row[0] ."\">add to cart</a></td>";
		$resultHTML .= "</tr>\n";

	} # end while

	// Close the table
	$resultHTML .= "</table>\n";

	return $resultHTML;

}

function editList($STH) {
	$STH->setFetchMode(PDO::FETCH_NUM);
	// Start the table
	$resultHTML = "<table border=\"1\">\n<tr>\n";

	// Output the table header
	$fieldCount = $STH->columnCount(); // number of columns

	for ($i=1; $i < $fieldCount; $i++) {
		$meta = $STH->getColumnMeta($i); // names of the fields
		$rowName = $meta['name'];
		$resultHTML .= "<th>$rowName</th>\n";
	} # end for

	$resultHTML .= "</tr>\n";

	// Output the table data
	while ($row = $STH->fetch()) {
		$resultHTML .= "<tr>\n";
		for ($i = 1; $i < $fieldCount; $i++)
		$resultHTML .= "<td>".htmlentities($row[$i])."</td>\n";

		//Sending old data to modify form for reference
		$resultHTML .= "<td><a href=\"modify.php?ID=". $row[0] ."&PRODUCT=". $row[1] ."&PRICE=". $row[2] ."&DESCRIPTION=". $row[3] ."\">modify</a></td>";

		$resultHTML .= "<td><a href=\"delete.php?ID=". $row[0] ."\">delete</a></td>";

		$resultHTML .= "</tr>\n";

	} # end while

	// Close the table
	$resultHTML .= "</table>\n";

	return $resultHTML;

}

function productList2($STH) {
	// FETCH_NUM gives out indexed arrays
	$STH->setFetchMode(PDO::FETCH_NUM);
	// Start the table
	$resultHTML = "<table border=\"1\">\n<tr>\n";

	// Output the table header
	$fieldCount = $STH->columnCount(); // number of columns

	for ($i=1; $i < $fieldCount; $i++) {
		//getColumnMeta($i) gets all metadata
		$meta = $STH->getColumnMeta($i); // names of the fields in asoc array
		$rowName = $meta['name'];
		$resultHTML .= "<th>$rowName</th>\n";
	} # end for

	$resultHTML .= "</tr>\n";

	// Output the table data
	while ($row = $STH->fetch()) {
		$resultHTML .= "<tr>\n";

		//scope of bracketless for/if/while/dowhile is one row and ends with ;
		for ($i = 1; $i < $fieldCount; $i++)
		$resultHTML .= "<td>".htmlentities($row[$i])."</td>\n";

		//? <-- puts stuff into url for GET method
		$resultHTML .= "<td><a href=\"javascript:addToCart(". $row[0] .")\">add to cart</a></td>";
		$resultHTML .= "</tr>\n";

	} # end while

	// Close the table
	$resultHTML .= "</table>\n";

	return $resultHTML;

}


?>