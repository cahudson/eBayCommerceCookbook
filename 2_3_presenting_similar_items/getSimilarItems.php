<?php
/********************************************
getSimilarItems.php

Uses getSimilarItems of the eBay Merchandising
API to display 10 similar items as a recently
closed item on eBay, given the item id.

Requires the merchandisingConstants.php file.
********************************************/

// Include our Merchandising API constants.
require_once 'merchandisingConstants.php';

// Create the JSON Request variables.
// Replace the itemId with a recently (within 2 weeks)
// completed eBay item id.
$jsonRequest = '{
	"itemId":"170923268700",
	"listingType":"FixedPriceItem",
	"maxResults":"10"
}';

// Define the header array for the Merchandising API call.
$headers = array(
	'X-EBAY-SOA-OPERATION-NAME:getSimilarItems',
	'X-EBAY-SOA-SERVICE-NAME:MerchandisingService',
	'X-EBAY-SOA-SERVICE-VERSION:'.MERCHANDISING_API_VERSION,
	'EBAY-SOA-CONSUMER-ID:'.API_KEY,
	'X-EBAY-SOA-GLOBAL-ID:'.GLOBAL_ID,
	'X-EBAY-SOA-REQUEST-DATA-FORMAT:'.REQUEST_ENCODING,
	'X-EBAY-SOA-RESPONSE-DATA-FORMAT:'.RESPONSE_ENCODING
);

// Initialize the curl session.
$session  = curl_init(MERCHANDISING_API_ENDPOINT);

// Set the curl HTTP Post options with the JSON request.
curl_setopt($session, CURLOPT_HTTPHEADER, $headers);
curl_setopt($session, CURLOPT_POST, true);
curl_setopt($session, CURLOPT_POSTFIELDS, $jsonRequest);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// Execute the curl request.
$responseJSON = curl_exec($session);

// Close the curl session
curl_close($session);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>3-4 Presenting Similar Items</title>
<style>
body {background: #fff; color: #000; font: normal 62.5%/1.5 tahoma, verdana, sans-serif;}
* {margin: 0; padding: 0;}
div.item {font-size:1.3em;font-weight: bold;border: 7px solid #ccc; border-radius: 5px; padding: 10px; margin:10px; width: 500px; vertical-align:top;}
div.itemImage {float:left;display:block;width:100px;}
div.itemTitle {float:left;display:block;width:320px;}
div.itemPrice {float:right;}
</style>
</head>
<body>
<?php
// Convert the JSON to a PHP object.
$objResponse = json_decode($responseJSON);

// Set the call ack response value.
$ack = $objResponse->getSimilarItemsResponse->ack;

// Check if the call to the Merchandising API was successful.
if ($ack == "Success") {
	
	// Get a reference to the array of items.
	$items = $objResponse->getSimilarItemsResponse->itemRecommendations->item;
	
	// Loop through the items and display.
	echo '<H1>Similar Items</H1>';
	foreach ($items as $item) {
		// Display the image, title, item id, price
		echo '<div class="item" style="overflow:hidden">';
		echo '<div class="itemImage"><img src="'.$item->imageURL.'"/></div>';
		echo '<div class="itemTitle"><a href="'.$item->viewItemURL.'">'.$item->itemId." - ".$item->title.'</a></div>';
		echo '<div class="itemPrice">'.$item->buyItNowPrice->__value__.'</div>';
		echo '</div>';
	}
}
else {
	// Call to Merchandising API failed.
	$errors = $objResponse->getSimilarItemsResponse->errorMessage->error;
	
	// Display Errors.
	echo '<H1>'.count($errors).' Error(s)</H1>';
	foreach ($errors as $error) {
		echo "Error Id " . $error->errorId . " :: " . $error->message . "<br/>";
	}
}
?>
</body>
</html>