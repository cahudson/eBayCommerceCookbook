<?php
/****************************************************
 IPNListener.php

 This file recieves IPNs from PayPal and processes.
 Since this is from server to server there is no UI
 for this file. The only output is the log file which
 is for basic logging only.

 ****************************************************/
// flag to define if working in sandbox (debug)
$FLG_DEBUG_MODE = true;

// set our log file (could replace with PEAR)
$logfile = "./IPNListener.log";
$fh = fopen($logfile, 'a') or die("can't open log file");

logWrite("New IPN");

// create validate request with command
$req = 'cmd=' . urlencode('_notify-validate');

// add back all fields of the posted string
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// set if using the sandbox or production for validation
if ($FLG_DEBUG_MODE) {
	$val_server = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
} else {
	$val_server = 'https://www.paypal.com/cgi-bin/webscr';
}

// launch the curl request to PayPal servers to verify
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $val_server);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
$res = curl_exec($ch);
curl_close($ch);

// check if PayPal verified the IPN received
if (strcmp ($res, "VERIFIED") == 0) {

	// log out IPN in a json format.
	logWrite("Verified: " . json_encode($_POST));
	
	// assign posted variables to local variables
	$txn_id 					= $_POST['txn_id'];
	$txn_type 				= $_POST['txn_type'];
	$payment_status 	= $_POST['payment_status'];
	$receiver_email 	= $_POST['receiver_email'];
	
	// TODO::check that receiver_email is your Primary PayPal email
			
	// dispatch based on status of payment
	switch ($payment_status) {
		
		case "Completed":
			// completed sale
		
			// TODO::check that payment_amount/payment_currency are correct
			// TODO::check that txn_id has not been previously processed
			
			// check if the type of transaction is a cart
			if ($txn_type == 'cart') {
				
				// set up our holding arrays for keys and values
				$arrShipKeys	= array();
				$arrShipValues	= array();
				
				// set our shipping header information
				array_push($arrShipKeys, "<<DATE>>");
				array_push($arrShipValues, date("M j, Y", strtotime($_POST['payment_date'])));
				
				array_push($arrShipKeys, "<<STATUS>>");
				array_push($arrShipValues, "PAID");
				
				array_push($arrShipKeys, "<<TXNID>>");
				array_push($arrShipValues, $txn_id);
				
				// get payer information and add to arrays
				//TODO :: check if following funcs required
				$first_name				= $_POST['first_name'];
				$last_name				= $_POST['last_name'];
				$payer_email 			= $_POST['payer_email'];
				$address_street		= $_POST['address_street'];
				$address_city			= $_POST['address_city'];
				$address_state		= $_POST['address_state'];
				$address_zip			= $_POST['address_zip'];
				$address_country	= $_POST['address_country'];
				
				array_push($arrShipKeys, "<<ADDRESS>>");
				array_push($arrShipValues, $first_name . " " . $last_name . "<br/>" .
					$address_street . "<br/>" .
					$address_city . ", " . $address_state . " " . $address_zip . "<br/>" .
					$address_country);
				
				// get rest of transaction details
				$shipping_method	= $_POST['shipping_method'];
				if (isset($_POST['num_cart_items'])) {
					$num_cart_items		= $_POST['num_cart_items'];
				} elseif ($FLG_DEBUG_MODE) {
					// catch defect with simulator based IPN
					$num_cart_items = 1;
				} else {
					$num_cart_items = 0;
				}
				
				// Get the items in the cart
				$subtotal = 0;
				$items = "";
				
				for ($i=1; $i<=$num_cart_items; $i+=1) {
	
					// get fields of items in transaction and store each set
					$item_order_id	= $i;
					$item_number		= $_POST['item_number'.$i];
					$item_name			= $_POST['item_name'.$i];
					$quantity				= $_POST['quantity'.$i];
					$mc_gross				= $_POST['mc_gross_'.$i];
					
					$subtotal += $mc_gross;
					
					$items .= '<tr><td align="right" valign="top" class="borderBottomLeftRight"><p class="sliptabledata">' . $item_number . '</p></td>' .
										'<td align="left" valign="top" class="borderBottomRight"><p class="sliptabledata">' . $item_name . '</p></td>' .
										'<td align="center" valign="top" class="borderBottomRight"><p class="sliptabledata">' . $quantity . '</p></td>' .
										'<td align="right" valign="top" class="borderBottomRight"><p class="sliptabledata">' . $mc_gross . '</p></td>' .
										'</tr>';
				}
				array_push($arrShipKeys, "<<ITEMS>>");
				array_push($arrShipValues, $items);
				
				// Set the financial section numbers
				array_push($arrShipKeys, "<<SUBTOTAL>>");
				array_push($arrShipValues, number_format($subtotal,2));
				
				$mc_shipping = $_POST['mc_shipping'];
				if ($mc_shipping == "") {
					$mc_shipping = 0;
				}
				array_push($arrShipKeys, "<<SHIPPING>>");
				array_push($arrShipValues, number_format($mc_shipping,2));
				
				$mc_handling = $_POST['mc_handling'];
				if ($mc_handling == "") {
					$mc_handling = 0;
				}
				array_push($arrShipKeys, "<<HANDLING>>");
				array_push($arrShipValues, number_format($mc_handling,2));
				
				$tax = $_POST['tax'];
				if ($tax == "") {
					$tax = 0;
				}
				array_push($arrShipKeys, "<<TAX>>");
				array_push($arrShipValues, number_format($tax,2));
				
				$mc_gross	= $_POST['mc_gross'];
				array_push($arrShipKeys, "<<TOTAL>>");
				array_push($arrShipValues, $mc_gross);
				
				// finished parsing IPN
				logWrite("Finished IPN");
				
				// Call the function to create shipping label
				createShipping($txn_id, $arrShipKeys, $arrShipValues);
				
			}	// end if txn_type is cart
			
			break;
			
		// some other possible IPN transaction statuses
		case "Reversed":
			// sale was reversed - mark order as such
			break;
			
		case "Refunded":
			// Refunded: You refunded the payment.
			break;
			
	} // end switch payment status

} else if (strcmp ($res, "INVALID") == 0) {
	
	// PayPal responded with invalid request
	logWrite("INVALID REQUEST: " . json_encode($_POST));
}

// close log file
fclose($fh);

// function to create the shipping form
function createShipping($txn_id, $arrShipKeys, $arrShipValues) {
	
	// read in template file
	$ship_contents = file_get_contents("shipping_slip.html");
	
	// verify the template was read in
	if($ship_contents) {
		
		// merge in fields from IPN
		$ship_contents = str_replace($arrShipKeys, $arrShipValues, $ship_contents);
	
		// set output file to txn # and output merged content
		$shipping_file = "./slips/" . $txn_id . ".html";
		file_put_contents($shipping_file, $ship_contents);
	}
}

// function to add log entry
function logWrite($log_msg) {
	global $fh;
	$log_entry = date("y/m/d G:i:s") . " - " . $log_msg . "\n";
	fwrite($fh, $log_entry);
}
?>