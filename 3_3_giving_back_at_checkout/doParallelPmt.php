<?php
/********************************************
doParallelPmt.php

Called by donateOption.php
Calls  APIError.php on error

Based on PayParallelReceipt.php from SDK Samples
********************************************/

require_once 'lib/AdaptivePayments.php';
require_once 'web_constants.php';

session_start();

try {

	/* Set our store paypal id (seller email) for receiving the order payment. Also
	set the total sale amount for the order and the buyer's email. These
	would normally come from a customer database and the shopping cart.*/
	$recEmailSeller = 'wppm_1341107399_biz@aduci.com';
	$totalSale = 218.73;
	$senderEmail = "chudso_1241987592_per@aduci.com";
      
	
	/* Set the return and cancel urls instructing paypal where to 
	return the user upon payment confirmation or cancellation.*/
	$serverName = $_SERVER['SERVER_NAME'];
	$serverPort = $_SERVER['SERVER_PORT'];
	$url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);
	$returnURL = $url."/PaymentDetails.php";
	$cancelURL = $url."/donateOption.php" ;
	
	/* Create the actual pay request with our urls, client details,
	currency code, buyers email and request envelope*/
	$payRequest = new PayRequest();
	$payRequest->actionType = "PAY";
	$payRequest->cancelUrl = $cancelURL ;
	$payRequest->returnUrl = $returnURL;
	$payRequest->clientDetails = new ClientDetailsType();
	$payRequest->clientDetails->applicationId = APPLICATION_ID;
	$payRequest->clientDetails->deviceId = DEVICE_ID;
	$payRequest->clientDetails->ipAddress = "127.0.0.1";
	$payRequest->currencyCode = "USD";
	$payRequest->senderEmail = $senderEmail;
	$payRequest->requestEnvelope = new RequestEnvelope();
	$payRequest->requestEnvelope->errorLanguage = "en_US";
	
	// Create our receiver list for parallel payments.
	$receiverList = array();
	
	/* Set the store as the first receiver with the shopping
	cart total sale. The order of receivers does not matter but 
	having the main store first keeps it logical.*/
	$receiver0 = new receiver();
	$receiver0->email = $recEmailSeller;
	$receiver0->amount = $totalSale;
	$receiverList[0] = $receiver0;
	
	// check if a charity donation has been selected.
	if ($_POST['flagDonation'] == 1) {
		// If so then create a secondary receiver for the donation
		$receiver1 = new receiver();
		$receiver1->email = $_POST['charityEmail'];
		$receiver1->amount = $_POST['donation'];
		$receiverList[1] = $receiver1;
	}
	
	// Add the receiver list into the pay request.
	$payRequest->receiverList = $receiverList;
	
	/* Set optional Pay Request fields. The feesPayer with 
	EACHRECEIVER instructs paypal that each receiver will cover 
	their fees for the portion of the payment. Non-profits for 
	the donation have discounted fees with PayPal.*/
	$payRequest->feesPayer = "EACHRECEIVER";
	$payRequest->memo = "Donation via yoursite.com.";
	
	/* Make the call to PayPal to get the Pay token
	If the API call succeded, then redirect the buyer to PayPal
	to begin to authorize payment.  If an error occured, show the
	resulting errors.*/
	$ap = new AdaptivePayments();
	$response=$ap->Pay($payRequest);
	
	// Check the return of the request and handle appropriately.
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
			
			// Important to pass the _ap-payment command and paykey to PayPal.
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