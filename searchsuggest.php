<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Process & display search suggestions 
 *****************************************/
$xmlDoc = new DOMDocument();
$xmlDoc->load("catalog.xml");

$catalogProducts = $xmlDoc->getElementsByTagName('catalogproduct');
$suggestions = "";

//get the q parameter from URL
$q = $_GET["q"];

//lookup all links from the xml file if length of q>0
//count($anArray) is used to get the size of an array
if (strlen($q) > 0)
{
	for ($i = 0; $i < ($catalogProducts->length); $i++)
	{
		$catalogProduct = $catalogProducts->item($i);
		$productAttributes = $catalogProduct->attributes;
		$id = $productAttributes->item(0)->nodeValue;
		$type = $productAttributes->item(1)->nodeValue;
		$catalogProductTitle = $catalogProduct->getElementsByTagName('product')->item(0)->nodeValue;
		//echo ("Prod: " . $catalogProductTitle);
		if (stristr($catalogProductTitle,$q))
		{
			if ($suggestions=="")
			{		
				$suggestions = '<a href="detail.php?id=' . $id . '&ctype=' . $type . '">' . $catalogProductTitle . '</a>';
			}
			else
			{
				$suggestions = $suggestions . '<br /><a href="detail.php?id=' . $id . '&ctype=' . $type . '">' . $catalogProductTitle . '</a>';
				
			}
		}
	}
}

// Set output to "no suggestion" if no hint were found
// or to the correct values
if ($suggestions == "")
{
	$response = "No suggestions";
}
else
{
	$response = $suggestions;
}

//output the response
echo $response;
?> 