<?php

/********************************************
wsMiloAvailability.php
Web service helper for accessing Milo Open
API availabilty endpoint.

API key required for your domain.
Calls  caller.php,and APIError.php.
********************************************/

DEFINE("API_KEY","<YOUR_API_KEY>");
DEFINE("AVAIL_ENDPOINT","https://api.x.com/milo/v3/availability");

// Set the url to call
$url = AVAIL_ENDPOINT . "?key=" . API_KEY . "&" . $_SERVER['QUERY_STRING'];

// use a file stream to handle availability chunking of 
// return information. We will loop through all the chunks
// received and collapse to one json block.
$file_handle = fopen($url, "r");
if ($file_handle) {
	
	// array to hold new block for client
	$arr_json = array();
	
	while (!feof($file_handle)) {
		 
		// get the next line from the file stream
		$line = fgets($file_handle);
		 
		// decode the chunk or line we just received
		$jsonLine = json_decode($line, true);
		 
		// determine chunk type and handle
		switch (key($jsonLine)) {
			
			// received a merchant chunk
			case "merchant":
				// get the merchant and hold the merchant json
				$merchant_id = (string)$jsonLine['merchant']['id'];
				$arr_json[$merchant_id] = $jsonLine["merchant"];
				break;
			
			// received a store location chunk
			case "location":
				// get the location and add under merchant
				$location_id = (string)$jsonLine['location']['id'];
				$merchant_id = (string)$jsonLine['location']['merchant_id'];
				$arr_json[$merchant_id][$location_id] = $jsonLine["location"];
				break;
			
			// received the availability chunk
			case "result":
				// get the result and just merge with location stored
				$arr_json[$merchant_id][$location_id] += $jsonLine["result"];
				break;
		}
	}
	if (!feof($file_handle)) {
		echo "Error: unexpected fgets() fail\n";
	}
	
	// close our stream handler
	fclose($file_handle);
	
	// send the new json block down to client.
	echo json_encode($arr_json);

}
?>