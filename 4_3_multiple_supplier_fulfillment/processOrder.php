<?php
/********************************************
processOrder.php

Called by orderForm.php
Calls  APIError.php on error

Based on PayChainedReceipt.php from SDK Samples
********************************************/

require_once 'lib/AdaptivePayments.php';
require_once 'web_constants.php';

session_start();

try {

	/* The servername and serverport tells PayPal where the buyer
	should be directed back to after authorizing payment.
	In this case, its the local webserver that is running this script
	Using the servername and serverport, the return URL is the first
	portion of the URL that buyers will return to after authorizing payment
	*/
	$serverName = $_SERVER['SERVER_NAME'];
	$serverPort = $_SERVER['SERVER_PORT'];
	$url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);
	
	/* The returnURL is the location where buyers return when a
	payment has been succesfully authorized.
	The cancelURL is the location buyers are sent to when they hit the
	cancel button during authorization of payment during the PayPal flow
	*/
	$returnURL = $url."/PaymentDetails.php";
	$cancelURL = "$url/orderForm.php" ;
	$email = $_REQUEST["email"];
	
	/* Set a couple arrays of item costs and receivers since we
	are not using a real database in this example. Normally this 
	information would come from the shopping cart and/or database
	being used to track items being sold and sources. 
	*/
	$arrItemCosts = array('1001' => 1.00,
	'1002' => 0.60,
	'1003' => 1.00,
	'2001' => 4.00);
	
	// set array of receivers with us first (based on order)
	$arrReceivers = array('wppm_1341107399_biz@aduci.com',
		'sell1_1341107573_biz@aduci.com',
		'servic_1241987644_biz@aduci.com');
	$arrReceiverAmounts = array();
	
	// Determine and set amounts for each receiver
	$totalSale = 0;
	
	$itemCount = count($_POST['item']);
	for ($idxItem=0; $idxItem<$itemCount; $idxItem++) {
		
		/* Get each items data. This would typically come
		from the cart / database.
		*/
		$itemSku = $_POST['item'][$idxItem];
		$itemQty = $_POST['qty'][$idxItem];
		$itemSource = $_POST['source'][$idxItem];
		$itemPrice = $_POST['price'][$idxItem];
		$itemCost = $arrItemCosts[$itemSku];
		
		// Update tota sale amount
		$totalSale += $itemQty * $itemPrice;
		
		// Calculate amount for this item and add to receivers amount
		$itemAmount = $itemQty * $itemCost;
		$arrReceiverAmounts[$itemSource] += $itemAmount;
	}
	
	// Set the total sale to our own primary receiver
	$arrReceiverAmounts[0] += $totalSale;
	
	/* Make the call to PayPal to get the Pay token
	If the API call succeded, then redirect the buyer to PayPal
	to begin to authorize payment.  If an error occured, show the
	resulting errors
	*/
	$payRequest = new PayRequest();
	$payRequest->actionType = "PAY";
	$payRequest->cancelUrl = $cancelURL ;
	$payRequest->returnUrl = $returnURL;
	$payRequest->clientDetails = new ClientDetailsType();
	$payRequest->clientDetails->applicationId = APPLICATION_ID;
	$payRequest->clientDetails->deviceId = DEVICE_ID;
	$payRequest->clientDetails->ipAddress = "127.0.0.1";
	$payRequest->currencyCode = "USD";
	$payRequest->senderEmail = $email;
	$payRequest->requestEnvelope = new RequestEnvelope();
	$payRequest->requestEnvelope->errorLanguage = "en_US";
	
	// Set the receivers
	$arrReceiverList = array();
	
	for ($idxReceivers=0; $idxReceivers<count($arrReceivers); $idxReceivers++) {
	
		$tmpReceiver = new receiver();
		$tmpReceiver->email = $arrReceivers[$idxReceivers];
		$tmpReceiver->amount = $arrReceiverAmounts[$idxReceivers];
		if ($idxReceivers == 0) {
			// If reciever is us then set priary to true
			$tmpReceiver->primary = true;
		} else {
			$tmpReceiver->primary = false;
		}
		
		// create a unique invoice per receiver (replace with yours)
		$tmpReceiver->invoiceId = "12009-" . $idxReceivers;
		
		// Add this receiver to the array
		array_push($arrReceiverList, $tmpReceiver);
	}
	
	// Set the array of receivers into the Pay Request
	$payRequest->receiverList = $arrReceiverList;
	
	// Set optional Pay Request fields
	$payRequest->feesPayer = "EACHRECEIVER";
	$payRequest->memo = "Chained Payment";
	
	/* Make the call to PayPal to get the Pay token
	If the API call succeded, then redirect the buyer to PayPal
	to begin to authorize payment.  If an error occured, show the
	resulting errors
	*/
	$ap = new AdaptivePayments();
	$response=$ap->Pay($payRequest);
	
	if (strtoupper($ap->isSuccess) == 'FAILURE') {
		$_SESSION['FAULTMSG']=$ap->getLastError();
		$location = "APIError.php";
		header("Location: $location");
	} else {
		$_SESSION['payKey'] = $response->payKey;
		if ($response->paymentExecStatus == "COMPLETED") {
			$location = "PaymentDetails.php";
			header("Location: $location");
		} else {
			$token = $response->payKey;
			$payPalURL = PAYPAL_REDIRECT_URL.'_ap-payment&paykey='.$token;
			header("Location: ".$payPalURL);
		}
	}	
} 
catch(Exception $ex) {
	$fault = new FaultMessage();
	$errorData = new ErrorData();
	$errorData->errorId = $ex->getFile() ;
	$errorData->message = $ex->getMessage();
	$fault->error = $errorData;
	$_SESSION['FAULTMSG']=$fault;
	$location = "APIError.php";
	header("Location: $location");
}	
?>