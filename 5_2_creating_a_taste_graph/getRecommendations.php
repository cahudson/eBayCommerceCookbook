<?
/***********************************************************
getRecommendations.php

Create 3x3 box of recommendations via hunch API from a user's
item purchase and twitter username taste graph.

***********************************************************/

// Include the auth_sig library.
require_once("libHunchAuthSig.php");

// Define the app constants.
define("HUNCH_API_ROOT","http://api.hunch.com/api/v1");
define("APP_ID","<YOUR_HUNCH_APP_ID>");
define("APP_SECRET","<YOUR_HUNCH_APP_SECRET>");

// Define the number of recomendations.
define("LIMIT_NUM",9);

// Function to handle Curl API calls
function curl_get_file($url) {
	
	// Initialize the curl request.
	$ch = curl_init();

	// Set the curl options.
	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_URL, $url);      

	// Execute the curl request.
	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}

// Function to use the get-results api Hunch call to retrieve the Hunch item Id.
function getHunchItemInfo($itemName, $topicList) {
	
	// Create the Hunch url for get-results call.
	$urlGetRes = HUNCH_API_ROOT."/get-results/?topic_ids=".$topicList."&name=".$itemName."&app_id=".APP_ID;
	
	// Sign the url request.
	$urlGetResSigned = signUrl($urlGetRes, APP_SECRET);
	
	// Make the curl request.
	$strResults = curl_get_file($urlGetResSigned);
	
	// Convert the json results string to an object.
	$objResults = json_decode($strResults);
	
	// Check the results and set the result_id and topic_id
	if ($objResults->ok && $objResults->total>0) {
		$result_id = $objResults->results[0]->result_id;
		$topic_id = $objResults->results[0]->topic_ids[0];
	}
	
	// Return the item result_id and topic_id.
	return array ($result_id, $topic_id);
}

// Function to use the get-recommendations to retrieve Hunch recommendations.
function getHunchRecommendations($prodName, $listId, $twName) {
	
	// Get the hunch item id and topic category via the get-results API
	$hunchItemInfo = getHunchItemInfo($prodName, $listId);
	
	// Set the hunch item id and category returned.
	$hnItemId = $hunchItemInfo[0];
	$hnCategory = $hunchItemInfo[1];
	
	// Modify the twitter username with the Hunch prefix for twitter.
	$twName = "tw_".$twName;
	
	// Construct the get-recommendations API call with the data.
	$urlGetRec = HUNCH_API_ROOT."/get-recommendations/?likes=".$hnItemId.
		"&blocked_result_ids=".$hnItemId."&user_id=".$twName."&topic_ids=".$hnCategory.
		"&limit=".LIMIT_NUM."&tags=kitchen&app_id=".APP_ID;
		
	// Sign the url request.
	$urlGetRecSigned = signUrl($urlGetRec, APP_SECRET);

	// Make the get-recommendations request.
	$strResults = curl_get_file($urlGetRecSigned);
	
	return $strResults;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Recommendations</title>
<style>
	body {color: #000;font: normal 100%/1.5 tahoma, verdana, sans-serif;text-align:center}
	#reccontainer {margin:0 auto;background:#fff;width:340px;padding:20px;}
	fieldset {border:2px solid #ccc;border-radius: 5px;padding: 10px;}
	legend {font-size: 1em;padding: 0 5px;}
	.productHolder {float:left;width:100px;height:100px;}
	.productImage {max-width:100px;max-height:100px;}
</style>
</head>
<body>
	<div id="reccontainer">
    <fieldset>
      <legend>Other Product Ideas</legend>
      <?php
			
			// Set the item recently purchased, hunch list topic, and twitter username.
			$itemName = "kitchenaid-professional-600-series-stand-mixer-kp26m1xnp";
			$hunchList = "list_electric-mixer";
			$twitterUsername = "chuckhudson";
			
			// Make function call to get the recommendations.
			$strRecommendations = getHunchRecommendations($itemName,$hunchList,$twitterUsername);
			
			// Convert the recommendations json string to an object.
			$objRecs = json_decode($strRecommendations);
			
			// Check the results to verify success.
			if ($objRecs->ok && $objRecs->total>0) {
				
				// Loop through each recommendation and display linked image.
				foreach($objRecs->recommendations as $recommendation) {
					echo '<div class="productHolder">';
					echo '<a href="'.$recommendation->url.'" title="'.$recommendation->title.'">';
					echo '<img class="productImage" src="'.$recommendation->image_url.'" />';
					echo '</a>';
					echo '</div>';
				}
			} else {
				echo "No Recommendations Found.";
			}
			?>
    </fieldset>
  </div>
</body>
</html>