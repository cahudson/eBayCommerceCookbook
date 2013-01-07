<?php
/***********************************************************
QRCreateLabel.php

Create the QR Code label for putting on the particular product.

Call from QRShareIt.php with the product id.

***********************************************************/

// For documentationo on the Google QR Code Infographics API see:
// https://google-developers.appspot.com/chart/infographics/docs/qr_codes

// Check if the page has been posted to with a product id.
if (isset($_REQUEST['product_id'])) {
	
	// Retrieve the product id and create string with guid.
	$product_id = $_REQUEST['product_id'];
	$pkey = md5(uniqid());
	
	/* TODO the product key should be stored or retrieved from the 
	   product database so that it can be matched upon scanning. */
	$product_string = "pid=" . $product_id . "&pky=" . $pkey;
	
	// Create the data to put into the QR Code with the tracking link.
	$qr_link = "<YOUR_URL>/QRscan.php";
	$qr_data .= urlencode($qr_link . "?" . $product_string);
	
	// Create the full URL for the QR image using Google.
	$qr_generator = "https://chart.googleapis.com/chart?cht=qr";
	$qr_size = "&chs=220x220";
	$qr_data = "&chl=" . $qr_data;
	$qr_image = $qr_generator . $qr_size . $qr_data;
	
} else {
	
	// Redirect the user if not posted.
	header("Location: QRShareIt.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Product Share It Label</title>
<style>
body {
	background: #ddd; 
	color: #000; 
	font: normal 100%/1.5 tahoma, verdana, sans-serif; 
	text-align:center
}
#labelcontainer {
	 margin:0 auto; 
	 background:#fff; 
	 width:270px; 
	 padding:20px;
}
fieldset {
	border:5px solid #ccc; 
	border-radius: 5px; 
	padding: 10px;
}
legend {
	font-size: 1.8em; 
	padding: 0 5px;
}
#qrcode {
    position:relative;
}
#prodid {
		font-size:60%;
		text-align:right;
}
</style>
</head>
<body>
	<div id="labelcontainer">
    <fieldset>
      <legend>Scan It. Share It.</legend>
      Like this product? Then scan the QR code below and share it with your friends.
      <br/>
      <div id="qrcode">
        <img src="<?php echo $qr_image;?>"/>
      </div>
      Use our mobile app to scan the code for additional offers.
      <div id="prodid">
        <p><?php echo "PRD-" . $product_id;?></p>
      </div>
    </fieldset>
  </div>
</body>
</html>