<?php
// connect to the database
require_once('../common/dbConnect.php');


class shopping_cart
{
var $arrItems,
$intNumItems;
function shopping_cart()
{
$this->
arrItems = Array();
$this->intNumItems = 0;
}
function Add($intItemNumber, $strName, $dblPrice, $intQuantity)
/*$strName is the textual name of the item,
$dblPrice is the price of the item,
$intQuantity is the number of this item we are adding to the shopping cart 
The item information (name, price) for $intItemNumber is updated to match the newest data,
$intQuantity items are added to the previous quantity
$intNumItems is updated appropriately*/
{
// Set item’s name/price information
$this->arrItems[$intItemNumber][‘name’] = $strName;
$this->arrItems[$intItemNumber][‘price’] = $dblPrice;
// Add the appropriate number of items to the quantity$this->arrItems[$intItemNumber][‘quantity’] += $intQuantity;
// Update the intNumbItems variable$this->intNumItems += $intQuantity;
}
function Update($intItemNumber, $intQuantity)
/*
 $intItemNumber is the 3-digit item number code assignedto this item,
$intQuantity is the new quantity of this item that shouldbe in the shopping cart.
The item’s quantity is updated to match $intQuantity
$intNumItems is updated appropriately
*/
{
// Update intNumItems$this->intNumItems += $intQuantity -
$this->arrItems[$intItemNumber][‘quantity’];
// Update arrItems
$this->arrItems[$intItemNumber][‘quantity’] = $intQuantity;
}
function TotalItems()
/*
 nonereturns the total number of items in the shopping cart(stored in $intNumItems)
*/
{
return $this->intNumItems;
}
function NumItems($intItemNumber)
/*
 $intItemNumber is a 3-digit item identification numberthe quantity of items with the $intItemNumber itemnumber is returned
*/
{
return $this->arrItems[$intItemNumber][‘quantity’];
}
}
?>