<?php

/********************************************
getPreapproval.php

This file creates the preapproval request, calls the PayPal
Adaptive Payments API for the preapproval key and forwards 
the user to paypal.com with the key upon success.

Called by preapprovalForm.php

Calls APIError.php on error.
Forwards to paypal.com with cmd on success.
********************************************/

// Link to our AP library and constants files.
require_once 'lib/AdaptivePayments.php';
require_once 'web_constants.php';

try {

	// Set our local server information for the return and cancel URLs.
	$serverName = $_SERVER['SERVER_NAME'];
	$serverPort = $_SERVER['SERVER_PORT'];
	$url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);
	
	// Set the return and cancel URLs for the user returning from PayPal.
	$returnURL = $url."/yourReturn.php";
	$cancelURL = $url."/preapprovalForm.php" ;

	// Create a new preapproval request and fill in entries.
	$preapprovalRequest = new preapprovalRequest();
	
		// Determine if senderEmail provided.
		if ($_POST['senderEmail'] != "") {
			$preapprovalRequest->senderEmail = $_POST['senderEmail'];
		}
		$preapprovalRequest->startingDate = $_POST['startingDate']."Z";
		$preapprovalRequest->endingDate = $_POST['endingDate']."Z";
		$preapprovalRequest->maxTotalAmountOfAllPayments = $_POST['maxTotalAmountOfAllPayments'];
		$preapprovalRequest->currencyCode = "USD";
		$preapprovalRequest->memo = "Preapproval example.";
		
		// Set the cancel and return URLs
		$preapprovalRequest->cancelUrl = $cancelURL ;
		$preapprovalRequest->returnUrl = $returnURL;
		
		// Add the required request envelope error language setting.
		$preapprovalRequest->requestEnvelope = new RequestEnvelope();
		$preapprovalRequest->requestEnvelope->errorLanguage = "en_US";
	
	// Create the adaptive payments object and call Preapproval.
	$ap = new AdaptivePayments();
	$response=$ap->Preapproval($preapprovalRequest);
	
	// Check for success of Preapproval call.
	if (strtoupper($ap->isSuccess) == 'SUCCESS') {
		// Call was successful, retrieve preapproval key and forward user to paypal.
		$PAKey = $response->preapprovalKey;
		$payPalURL = PAYPAL_REDIRECT_URL.'_ap-preapproval&preapprovalkey='.$PAKey;
		header("Location: ".$payPalURL);
	} else {
		// Call failed, show APIError message.
		$_SESSION['FAULTMSG']=$ap->getLastError();
		$location = "APIError.php";
		header("Location: $location");
	}
	
} 
catch(Exception $ex) {
	// Catch any operation exceptions and show error.
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