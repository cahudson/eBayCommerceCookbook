<?php
/********************************************
showReviews.php

Uses FindReviewsAndGuides to retrieve list of
most recent reviews.

Called by findProducts.php with ProductID
********************************************/

// include our Shopping API constants
require_once 'shoppingConstants.php';

// check if called with querystring
if (!empty($_GET)) {

	// get the product id and call the helper function
	$pid = $_GET['pid'];
  $response = getFindReviewsAndGuides($pid);

	// create a simple xml object from results
	$xmlResponse = simplexml_load_string($response);
}


// Function to call the Shopping API FindReviewsAndGuides
function getFindReviewsAndGuides($pid) {
	
	/* Sample XML Request Block
	<FindReviewsAndGuidesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
	<ProductID> ProductIDType </ProductID>
	<UserID> string </UserID>
	<CategoryID> string </CategoryID>
	<MaxResultsPerPage> int </MaxResultsPerPage>
	<PageNumber> int </PageNumber>
	<ReviewSort>CreationTime|CustomCode</ReviewSort>
	<SortOrder>Ascending|Descending|CustomCode</SortOrder>
	<MessageID> string </MessageID>
	</FindReviewsAndGuidesRequest>​
	*/
	
	// create the XML request
	$xmlRequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
	$xmlRequest .= "<FindReviewsAndGuidesRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">";
	$xmlRequest .= "<ProductID type=\"Reference\">" . $pid . "</ProductID>";
	$xmlRequest .= "</FindReviewsAndGuidesRequest>";

	// define our header array for the Shopping API call
	$headers = array(
		'X-EBAY-API-APP-ID:'.API_KEY,
		'X-EBAY-API-VERSION:'.SHOPPING_API_VERSION,
		'X-EBAY-API-SITE-ID:'.SITE_ID,
		'X-EBAY-API-CALL-NAME:FindReviewsAndGuides',
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
<title>2-2 Show Reviews with FindReviewsAndGuides</title>
<style>
body {background: #fff; color: #000; font: normal 62.5%/1.5 tahoma, verdana, sans-serif;}
* {margin: 0; padding: 0;}
div#stats {font-size:1.3em; font-weight:bold; margin:10px; padding:10px;}
div.reviewHeader {font-size:1.3em;font-weight: bold;border: 7px solid #ccc; border-radius: 5px; padding: 10px 10px 20px 10px; margin: -17px 0px 10px -17px; width: 500px; vertical-align:top; background-color:#9FC}
div.review {border: 7px solid #ccc; border-radius: 5px; padding: 10px; margin:10px; width: 500px; vertical-align:top;}
</style>
</head>
<body>
<div>
	<a href="findProducts.php">< Back</a>
</div>
<div>
  <?php
		// Result block creation if results from product id
		// check for valid XML response object
		if ($xmlResponse) {
			
			// display review count, guide count and average rating
			echo '<H1>Reviews</H1>';
			echo '<div id="stats">';
			echo $xmlResponse->ReviewCount . ' Reviews<br/>';
			echo $xmlResponse->BuyingGuideCount . ' Guides<br/>';
			echo 'Average rating: ' . $xmlResponse->ReviewDetails->AverageRating;
			echo '</div>';
			
			// loop through each XML review node in the response
			foreach ($xmlResponse->ReviewDetails->Review as $review) {
				
				// display the title, userid, rating and text for each
				// review based on internal ProductID
				echo '<div class="review">';
				echo '<div class="reviewHeader">';
				echo '<div>' . $review->Title . '</div>';
				echo '<div style="float:left;">' . $review->UserID . '</div>';
				echo '<div style="float:right;"><img src="stars' . $review->Rating . '.png" style="height:15px;"/></div>';
				echo '</div>';
				echo '<div style="clear:both;"></div>';
				echo '<div class="reviewText">';
				echo $review->Text;
				echo '</div>';
				echo '</div>';
			}
		}
		else {
			// display message if no reviews returned
			echo "No reviews found.";
		}
	?>
</div>
</body>
</html>