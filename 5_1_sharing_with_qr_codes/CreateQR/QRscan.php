<?php
/***********************************************************
QRscan.php

Traffic handler for receiving a scanned QR code.
Update stats, and forward appropriately.

Called from qr code scan

***********************************************************/

// For documentationo on the Google QR Code Infographics API see:
// https://google-developers.appspot.com/chart/infographics/docs/qr_codes

// Check if the page has been posted to with a product id.
if (isset($_GET['pid']) && isset($_GET['pky'])) {
	
	// Retrieve the product id and product key
	$product_id = $_GET['pid'];
	$product_key = $_GET['pky'];
	
	/* Validate that the key is valid by looking in your product 
	   database.
	   TODO Replace following line with check if key in database and guid */
	$pkeyValid = true;
	
	if ($pkeyValid) {
		// If valid do the following:
		
		// 1) Log the scan in your statistics
			// TODO Put in your logging functionality.
		
		// 2) Forward user to the social page with the product guid
		$sharePage = "SharePage.php?pid=" . $product_id;
		
		// Forward user to the share page for the product.
		header("Location: " . $sharePage);
	} else {
		
// Redirect the user if not from a qr code scan.
header("Location: InvalidAccess.php");
	}
} else {
// Redirect the user if not from a qr code scan.
header("Location: InvalidAccess.php");
}
?>