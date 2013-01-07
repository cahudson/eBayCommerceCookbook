<?php
/********************************************
findProducts.php

Uses FindProducts to retrieve list of
products based on keyword query.

********************************************/

// include our Shopping API constants
require_once 'shoppingConstants.php';

// check if posted
if (!empty($_POST)) {
	
	// grab our posted keywords and call helper function
	$query = $_POST['query'];
  $response = getFindProducts($query);

	// create a simple xml object from results
	$xmlResponse = simplexml_load_string($response);
}

// Function to call the Shopping API FindProducts
function getFindProducts($query) {
	
	/* Sample XML Request Block
	<FindProductsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
	<IncludeSelector> string </IncludeSelector>
	<AvailableItemsOnly> boolean </AvailableItemsOnly>
	<DomainName> string </DomainName>
	<ProductID> ProductIDType </ProductID>
	<QueryKeywords> string </QueryKeywords>
	<ProductSort>Popularity|Rating|ReviewCount|ItemCount|Title|CustomCode</ProductSort>
	<SortOrder>Ascending|Descending|CustomCode</SortOrder>
	<MaxEntries> int </MaxEntries>
	<PageNumber> int </PageNumber>
	<CategoryID> string </CategoryID>
	<HideDuplicateItems> boolean </HideDuplicateItems>
	<MessageID> string </MessageID>
	</FindProductsRequest>​
	*/
	
	// create the XML request
	$xmlRequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
	$xmlRequest .= "<FindProductsRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">";
	$xmlRequest .= "<QueryKeywords>" . $query . "</QueryKeywords>";
	$xmlRequest .= "<ProductSort>Popularity</ProductSort>";
	$xmlRequest .= "<SortOrder>Descending</SortOrder>";
	$xmlRequest .= "<MaxEntries>100</MaxEntries>";
	$xmlRequest .= "<HideDuplicateItems>true</HideDuplicateItems>";
	$xmlRequest .= "</FindProductsRequest>";
	
	// define our header array for the Shopping API call
	$headers = array(
		'X-EBAY-API-APP-ID:'.API_KEY,
		'X-EBAY-API-VERSION:'.SHOPPING_API_VERSION,
		'X-EBAY-API-SITE-ID:'.SITE_ID,
		'X-EBAY-API-CALL-NAME:FindProducts',
		'X-EBAY-API-REQUEST-ENCODING:'.RESPONSE_ENCODING,
		'Content-Type: text/xml;charset=utf-8'
	);
	
	// initialize our curl session
	$session  = curl_init(SHOPPING_API_ENDPOINT);

	// set our curl options with the XML request
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($session, CURLOPT_POST, true);
	curl_setopt($session, CURLOPT_POSTFIELDS, $xmlRequest);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

	// execute the curl request
	$responseXML = curl_exec($session);
	
	// close the curl session
	curl_close($session);

	// return the response XML
	return $responseXML;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>2-2 Find Products with FindProducts</title>
<style>
body {background: #fff; color: #000; font: normal 62.5%/1.5 tahoma, verdana, sans-serif;}
* {margin: 0; padding: 0;}
form {padding: 0 10px; width: 700px;}
legend {font-size: 2em; padding-left:5px;padding-right:5px; position: relative;}
fieldset {border: 1px solid #ccc; border-radius: 5px; padding: 10px; width: 320px;}
li {clear: both; list-style-type: none; margin: 0 0 10px;}
label, input {font-size: 1.3em;}
label {display: block; padding: 0 0 5px; width: 200px}
input {background-position: 295px 5px; background-repeat: no-repeat; border: 2px solid #ccc; border-radius: 5px; padding: 5px 25px 5px 5px; width: 285px;}
input:focus {outline: none;}
input:invalid:required {background-image: url(asterisk.png); box-shadow: none;}
input:focus:invalid {background-image: url(invalid.png); box-shadow: 0px 0px 5px #b01212; border: 2px solid #b01212;}
input:valid:required {background-image: url(accept.png); border: 2px solid #7ab526;}
div label {width: 100%;}
div.product {float:left; border: 7px solid #ccc; border-radius: 5px; padding: 10px; margin:10px; height:150px; width: 200px;text-align:center; vertical-align:top;}
div.product:hover {background-color:#39F; border-color:#FF6;}
</style>
</head>
<body>
<div id="frmProduct">
	<!-- simple form for query keyword entry -->
	<form name="search" action="findProducts.php" method="post">
    <fieldset>
    <legend>Product Search</legend>
    <ol>
      <li>
        <label for="query">Keyword</label>
        <input autofocus required id="query" name="query" placeholder="Nook" />
      </li>
    </ol>
    <input type="submit" value="Search">
    </fieldset>
    <br/>
  </form>
</div>
<div id="container">
  <?php
		// Result block creation if results from form being posted
		// check for valid XML response object
		if ($xmlResponse) {
			
			echo '<H1>Results for "' . $query . '". Select one.</H1>';
			
			// loop through each XML product node in the response
			foreach ($xmlResponse->Product as $product) {
				
				// display the image and title for each product
				// create link to reviews page with internal ProductID
				echo '<a href="showReviews.php?pid=' . $product->ProductID . '">';
				echo '<div class="product">';
				if (($product->DisplayStockPhotos)=='true') {
					echo '<img src="' . $product->StockPhotoURL . '" />';
				} else {
					echo '<img src="missing.png" style="height:70px;" />';
				}
				echo "<br/>";
				echo $product->Title;
				echo '</div></a>';
			}
		}
		else {
			// display message if no search results (not posted)
			echo "Enter a search keyword above.";
		}
	?>
</div>
</body>
</html>