<?php

// SuperHTML Class Def
// Andy Harris
// PHP / MySQL Programming for the Absolute Beginner
// 3rd Ed. (Now XHTML strict compliant)

class html {

  //properties
  var $title;
  var $css; // link to css
  var $thePage; // collector for html code, everything is pushed here
  var $maindiv; // to add <div id="page"> around the whole content. Set to false if not wanted
  var $allowTempHeaders;
	var $tpTemporaryHeaders = '
   <link rel="stylesheet" type="text/css" href="../css/bookslide.css" />
	<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js"></script>
        
  
  
  <script>$(function() {

    var $el, leftPos, newWidth,
        $mainNav = $("#navbarList");

    $mainNav.append("<li id="magic-line"></li>");
    var $magicLine = $("#magic-line");

    $magicLine
        .width($(".currentPage").width())
        .css("left", $(".currentPage a").position().left)
        .data("origLeft", $magicLine.position().left)
        .data("origWidth", $magicLine.width());

    $("#navbarList li a").hover(function() {
        $el = $(this);
        leftPos = $el.position().left;
        newWidth = $el.parent().width();
        $magicLine.stop().animate({
            left: leftPos,
            width: newWidth
        });
    }, function() {
        $magicLine.stop().animate({
            left: $magicLine.data("origLeft"),
            width: $magicLine.data("origWidth")
        });
    });
});</script>

    <script type="text/javascript">
        var imgs = [
        "../images/banner1.png",
        "../images/banner2.png"];
        var cnt = imgs.length;

        $(function() {
            setInterval(Slider, 6000);
        });

        function Slider() {
        $("#imageSlide").fadeOut("slow", function() {
           $(this).attr("src", imgs[(imgs.length++) % cnt]).fadeIn("slow");
        });
        }
</script>


<script> 
 $(function(){
    //Get our elements for faster access and set overlay width
    var div = $("div.bookSlide"),
                 ul = $("ul.bookSlide"),
                 // unordered list"s left margin
                 ulPadding = 15;

    //Get menu width
    var divWidth = div.width();

    //Remove scrollbars
    div.css({overflow: "hidden"});

    //Find last image container
    var lastLi = ul.find("li:last-child");

    //When user move mouse over menu
    div.mousemove(function(e){

      //As images are loaded ul width increases,
      //so we recalculate it each time
      var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;

      var left = (e.pageX - div.offset().left) * (ulWidth-divWidth) / divWidth;
      div.scrollLeft(left);
    });
});</script>';

  function __construct($nTitle = "Internetprogramming", $nCss = array(), $nMaindiv = true, $nAllowTempHeaders = false){
    //constructor
    $this->title = $nTitle;
	$this->css = $nCss;
	$this->maindiv = $nMaindiv;
	$this->allowTempHeaders = $nAllowTempHeaders;
  } // end constructor

  function getTitle(){
    return $this->title;
  } // end getTitle

  function getPage(){
    return $this->thePage;
  } // end getPage

  //most basic tags
  function addText($content){
    //given any text (including HTML markup)
    //adds the text to the page
    $this->thePage .= $content;
    $this->thePage .= "\n";
  } // end addText

  function gAddText($content){
    //given any text (including HTML markup)
    //returns the text
    $temp= $content;
    $temp .= "\n";
    return $temp;
  } // end addText

  function buildTop(){
    $cssFile = $this->css;
    $temp = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="EN" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/xml; charset=utf-8" />
  <title>'.$this->title.'</title>';
  
    foreach($this->css as $css){
    $temp .=	'<link rel = "stylesheet"
        type = "text/css"
        href = "'.$css.'" />';
    }
        
    if($this->allowTempHeaders){
        $temp .= $this->tpTemporaryHeaders;
    }
	$temp .='</head>
<body>';

;
	if ($this->maindiv)
		$temp .= '<div id="wrapper">';
    $this->addText($temp);
  } // end buildTop;

  function buildBottom(){
    //builds the bottom of a generic web page
	if ($this->maindiv)
		$temp = '</div>';
    $temp .= <<<HERE
	
</body>
</html>

HERE;
    $this->addText($temp);
  } // end buildBottom;

  // general attribute function
  function attributes($attributes){
	  $temp = '';
	  if (count($attributes) > 0){
		 foreach ($attributes as $key => $value){
			  $temp .= ' '.$key.'="'.$value.'"';
		 }
	  }	 
	  return $temp;
  }

  //general tag function
  function tag($tagName, $contents, $attributes = array()){
    //given any tag, surrounds contents with tag
    //edit by Ilkka: add attributes as an associative array
    $this->addText($this->gTag($tagName, $contents, $attributes));
  } // end tag

  function gTag($tagName, $contents, $attributes = array()){
    //given any tag, surrounds contents with tag
    //returns tag but does not add it to page
    $temp = "<$tagName";
	$temp .= $this->attributes($attributes);
	$temp .= ">\n";
    $temp .= "  " . $contents . "\n";
    $temp .= "</$tagName>\n";
    return $temp;
  } // end tag  

  function gBuildList($theArray, $type = "ul", $typeAttributes = array(), $liAttributes = array()){
    //given an array of values, builds a list based on that array
    $temp= "<$type";
	$temp .= $this->attributes($typeAttributes);
	$temp .= ">\n";
    foreach ($theArray as $value){
      	$temp .= " <li";
		$temp .= $this->attributes($liAttributes);
		$temp .= ">$value</li> \n";
    } // end foreach
    //shorten type if it included style information
    $type = substr($type, 0, 2);
    $temp .= "</$type> \n";
    return $temp;
  } // end gBuildList

  function buildList($theArray, $type = "ul", $typeAttributes = array(), $liAttributes = array()){
    $temp = $this->gBuildList($theArray, $type, $typeAttributes, $liAttributes);
    $this->addText($temp);
  } // end buildList

  function gDl ($listVals, $dlAttributes = array(), $dtAttributes = array(), $ddAttributes = array()){
    //Create a definition list from an associative array   
    $temp = "";
    $temp .= "<dl";
	$temp .= $this->attributes($dlAttributes);
	$temp .= ">\n";
    foreach ($listVals as $term => $def){
      	$temp .= "  <dt";
		$temp .= $this->attributes($dtAttributes);
		$temp .= ">$term</dt> \n";
      	$temp .= "  <dd";
		$temp .= $this->attributes($ddAttributes);
		$temp .= ">$def</dd> \n";
    } // end foreach
    $temp .= "</dl> \n";
    return $temp;
  }
  
  function dl($listVals, $dlAttributes = array(), $dtAttributes = array(), $ddAttributes = array()){
    $this->addText($this->gDl($listVals, $dlAttributes, $dtAttributes, $ddAttributes));
  } // end dl

  function gBuildTable($theArray, $tableAttributes = array(), $trAttributes = array(), $tdAttributes = array()){
    //given a 2D array, builds an HTML table based on that array
    $table = "<table";
	$table .= $this->attributes($tableAttributes);
	$table .= ">\n";
    foreach ($theArray as $row){
      	$table .= "<tr";
		$table .= $this->attributes($trAttributes);
		$table .= ">\n";
      foreach ($row as $cell){
        $table .= "  <td";
		$table .= $this->attributes($tdAttributes);
		$table .= ">$cell</td> \n";
      } // end foreach
      $table .= "</tr> \n";
    } // end foreach
    $table .= "</table> \n";

    return $table;
  } // end gBuildTable

  function buildTable($theArray, $tableAttributes = array(), $trAttributes = array(), $tdAttributes = array()){
    $temp = $this->gBuildTable($theArray, $tableAttributes, $trAttributes, $tdAttributes);
    $this->addText($temp);
  } // end buildTable


  function startTable($tableAttributes = array()){
    $this->thePage .= '<table'.$this->attributes($tableAttributes).">\n";
  } // end startTable

  function tRow ($rowData, $rowType = "td", $trAttributes = array(), $tdAttributes = array()){
    //expects an array in rowdata, prints a row of th values
    $this->thePage .= '<tr'.$this->attributes($trAttributes).">\n";
    foreach ($rowData as $cell){
      	$this->thePage .= "  <$rowType".$this->attributes($tdAttributes).">$cell</$rowType> \n";
    } // end foreach
    $this->thePage .= "</tr> \n";
  } // end tRow

  function endTable(){
    $this->thePage .= "</table> \n";
  } // end endTable
  
  function gStartTable($tableAttributes = array()){
    return '<table'.$this->attributes($tableAttributes).">\n";
  } // end startTable

  function gRow ($rowData, $rowType = "td", $trAttributes = array(), $tdAttributes = array()){
    //expects an array in rowdata, prints a row of the values
    $temp = '<tr'.$this->attributes($trAttributes).">\n";
    foreach ($rowData as $cell){
      	$temp .= "  <$rowType".$this->attributes($tdAttributes).">$cell</$rowType> \n";
    } // end foreach
    $temp .= "</tr> \n";
    return $temp;
  } // end tRow

  function gEndTable(){
    return "</table> \n";
  } // end endTable

  //form elements
  
  function startForm($action = "", $method = "post", $formAttributes = array()){
    //begins form creation with fieldset
	$attributes = 'action="'.$action.'" method="'.$method.'"'.$this->attributes($formAttributes);
    $temp = <<<HERE
    <form $attributes>
      <fieldset>

HERE;
    $this->thePage .= $temp;
  } // end startForm
  
  function endForm(){
    //adds form end tag
    $this->thePage .= <<<HERE
      </fieldset>
    </form>
    
HERE;

  }// end endForm

  function gSelect($name, $listVals, $selectAttributes = array()){
    //given an associative array,
    //prints an HTML select object
    //Each element has the appropriate
    //value and displays the associated name
    $temp = "";
    $temp .= "<select name = \"$name\" ".$this->attributes($selectAttributes).">\n";
    foreach ($listVals as $val => $desc){
      $temp .= "  <option value = \"$val\">$desc</option> \n";
    } // end foreach
    $temp .= "</select> \n";
    return $temp;

  } // end gSelect

  function select($name, $listVals, $selectAttributes = array()){
    $this->addText($this->gSelect($name, $listVals, $selectAttributes));
  } // end select
  
  function formResults(){
    //returns the names and values of all form elements
    //in an HTML definition list
   if (!empty($_REQUEST)){
      $this->dl($_REQUEST);
    } // end isset
    
   
  } // end formResults

} // end class def

//list all the product from DB

?>
