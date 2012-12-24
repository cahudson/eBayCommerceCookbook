<?php
/********************************************
addItem.php

Uses eBay Trading API to list an item under 
a seller's account.

********************************************/

// include our Trading API constants
require_once 'tradingConstants.php';

// check if posted
if (!empty($_POST)) {
	
	// grab our posted keywords and call helper function
	// TODO: check if need urlencode
	$title = $_POST['title'];
	$categoryID = $_POST['categoryID'];
	$startPrice = $_POST['startPrice'];
	$pictureURL = $_POST['pictureURL'];
	$description = $_POST['description'];
	
	// call the getAddItem function to make AddItem call
  $response = getAddItem($title, $categoryID, $startPrice, $pictureURL, $description);

}

// Function to call the Trading API AddItem
function getAddItem($addTitle, $addCatID, $addSPrice, $addPicture, $addDesc) {
	
	/* Sample XML Request Block for minimum AddItem request
	see ... for sample XML block given length*/
	
	// Create unique id for adding item to prevent duplicate adds
	$uuid = md5(uniqid());
	
	// create the XML request
	$xmlRequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
	$xmlRequest .= "<AddItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">";
	$xmlRequest .= "<ErrorLanguage>en_US</ErrorLanguage>";
  $xmlRequest .= "<WarningLevel>High</WarningLevel>";
  $xmlRequest .= "<Item>";
  $xmlRequest .= "<Title>" . $addTitle . "</Title>";
  $xmlRequest .= "<Description>" . $addDesc . "</Description>";
  $xmlRequest .= "<PrimaryCategory>";
  $xmlRequest .= "<CategoryID>" . $addCatID . "</CategoryID>";
  $xmlRequest .= "</PrimaryCategory>";
  $xmlRequest .= "<StartPrice>" . $addSPrice . "</StartPrice>";
  $xmlRequest .= "<ConditionID>1000</ConditionID>";
  $xmlRequest .= "<CategoryMappingAllowed>true</CategoryMappingAllowed>";
  $xmlRequest .= "<Country>US</Country>";
  $xmlRequest .= "<Currency>USD</Currency>";
  $xmlRequest .= "<DispatchTimeMax>3</DispatchTimeMax>";
  $xmlRequest .= "<ListingDuration>Days_7</ListingDuration>";
  $xmlRequest .= "<ListingType>Chinese</ListingType>";
  $xmlRequest .= "<PaymentMethods>PayPal</PaymentMethods>";
  $xmlRequest .= "<PayPalEmailAddress>yourpaypal@emailaddress.com</PayPalEmailAddress>";
  $xmlRequest .= "<PictureDetails>";
  $xmlRequest .= "<PictureURL>" . $addPicture . "</PictureURL>";
  $xmlRequest .= "</PictureDetails>";
  $xmlRequest .= "<PostalCode>05485</PostalCode>";
  $xmlRequest .= "<Quantity>1</Quantity>";
  $xmlRequest .= "<ReturnPolicy>";
  $xmlRequest .= "<ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>";
  $xmlRequest .= "<RefundOption>MoneyBack</RefundOption>";
  $xmlRequest .= "<ReturnsWithinOption>Days_30</ReturnsWithinOption>";
  $xmlRequest .= "<Description>" . $addDesc . "</Description>";
  $xmlRequest .= "<ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>";
  $xmlRequest .= "</ReturnPolicy>";
  $xmlRequest .= "<ShippingDetails>";
  $xmlRequest .= "<ShippingType>Flat</ShippingType>";
  $xmlRequest .= "<ShippingServiceOptions>";
	$xmlRequest .= "<ShippingServicePriority>1</ShippingServicePriority>";
  $xmlRequest .= "<ShippingService>USPSMedia</ShippingService>";
  $xmlRequest .= "<ShippingServiceCost>2.50</ShippingServiceCost>";
  $xmlRequest .= "</ShippingServiceOptions>";
  $xmlRequest .= "</ShippingDetails>";
  $xmlRequest .= "<Site>US</Site>";
  $xmlRequest .= "<UUID>" . $uuid . "</UUID>";
  $xmlRequest .= "</Item>";
  $xmlRequest .= "<RequesterCredentials>";
  $xmlRequest .= "<eBayAuthToken>" . AUTH_TOKEN . "</eBayAuthToken>";
  $xmlRequest .= "</RequesterCredentials>";
  $xmlRequest .= "<WarningLevel>High</WarningLevel>";
	$xmlRequest .= "</AddItemRequest>";
	
	// define our header array for the Trading API call
	// notice different headers from shopping API and SITE_ID changes to SITEID
	$headers = array(
		'X-EBAY-API-SITEID:'.SITEID,
		'X-EBAY-API-CALL-NAME:AddItem',
		'X-EBAY-API-REQUEST-ENCODING:'.RESPONSE_ENCODING,
		'X-EBAY-API-COMPATIBILITY-LEVEL:' . API_COMPATIBILITY_LEVEL,
		'X-EBAY-API-DEV-NAME:' . API_DEV_NAME,
		'X-EBAY-API-APP-NAME:' . API_APP_NAME,
		'X-EBAY-API-CERT-NAME:' . API_CERT_NAME,
		'Content-Type: text/xml;charset=utf-8'
	);
	
	// initialize our curl session
	$session  = curl_init(API_URL);

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
<title>2-4 Add Item to eBay using eBay Trading API</title>
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
</style>
</head>
<body>
<div id="frmProduct">
	<!-- simple form for query keyword entry -->
	<form name="addItem" action="addItem.php" method="post">
    <fieldset>
    <legend>Add Item</legend>
    <ol>
      <li>
        <label for="title">Title</label>
        <input autofocus required id="title" name="title" value="Great Black Headphones" maxlength="80" />
      </li>
      <li>
        <label for="categoryID">Category ID</label>
        <input required id="categoryID" name="categoryID" value="112529"/>
      </li>
      <li>
        <label for="startPrice">Start Price</label>
        <input required id="startPrice" name="startPrice" value="20.00"/>
      </li>
      <li>
        <label for="pictureURL">Picture URL</label>
        <textarea rows="4" cols="40" required id="pictureURL" name="pictureURL">http://www.monsterproducts.com/images_db/mobile/MH_BTS_ON-SOHD_BK_CT_glam.jpg</textarea>
      </li>
      <li>
        <label for="description">Description</label>
        <textarea rows="4" cols="40" required id="description" name="description">A great pair of brand new black headphones - one for each ear.</textarea>
      </li>
    </ol>
    <input type="submit" value="Add Item">
    </fieldset>
    <br/>
  </form>
</div>
<div id="container">
  <?php
		// Display information to user based on AddItem response.
		
		// Convert the xml response string in an xml object
		$xmlResponse = simplexml_load_string($response);
		
		// Verify that the xml response object was created
		if ($xmlResponse) {
			
			// Check for call success
			if ($xmlResponse->Ack == "Success") {
				
				// Display the item id number added
				echo "<p>Successfully added item as item #" . $xmlResponse->ItemID . "<br/>";
				
				// Calculate fees for listing
				// loop through each Fee block in the Fees child node
				$totalFees = 0;
				$fees = $xmlResponse->Fees;
				foreach ($fees->Fee as $fee) {
					$totalFees += $fee->Fee;
				}
				echo "Total Fees for this listing: " . $totalFees . ".</p>";

			} else {
				
				// Unsuccessful call, display error(s)
				echo "<p>The AddItem called failed due to the following error(s):<br/>";
				foreach ($xmlResponse->Errors as $error) {
					$errCode = $error->ErrorCode;
					$errLongMsg = htmlentities($error->LongMessage);
					$errSeverity = $error->SeverityCode;
					echo $errSeverity . ": [" . $errCode . "] " . $errLongMsg . "<br/>";
				}
				echo "</p>";
			}
			
		}
	?>
</div>
</body>
</html>