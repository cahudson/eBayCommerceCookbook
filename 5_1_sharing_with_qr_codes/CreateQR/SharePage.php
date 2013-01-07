<?php
/***********************************************************
SharePage.php

Allow user to share the specific product with their friends.
Add your own landing page for the product. Maybe a central 
product support menu for product documentation, email share
with friends, social feed integration, etc.

Call from QRscan.php with the product id and key.

***********************************************************/
?>
<!DOCTYPE html>
<html>
<head>
<title>Share the Product You Love</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<style>
body {
	background: #fff; 
	color: #000; 
	font: normal 100%/1.5 tahoma, verdana, sans-serif; 
	text-align:center
}
#container {
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
</style>
</head>
<body>
	<div id="container">
    <fieldset>
      <legend>Share It.</legend>
      We are glad that you are enjoying your purchase. Share it with your friends via your favorite format; email, twitter, facebook, google+.
      <br/><br/>
      <img src="images/icn_twitter.png" />&nbsp;&nbsp;&nbsp;<img src="images/icn_facebook.png" />
      <br/><br/>
      As a thank you after sharing you will be provided a discount code off your next purchase.
    </fieldset>
  </div>
</body>
</html>