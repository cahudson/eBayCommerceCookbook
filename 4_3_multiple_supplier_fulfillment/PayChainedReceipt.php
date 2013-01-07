<?php

/********************************************
PayChainedReceipt.php

Called by SetChainedPay.php
Calls  caller.php,and APIError.php.
********************************************/

require_once 'lib/AdaptivePayments.php';
require_once 'web_constants.php';

session_start();

			try {
				
			
	        /* The servername and serverport tells PayPal where the buyer
	           should be directed back to after authorizing payment.
	           In this case, its the local webserver that is running this script
	           Using the servername and serverport, the return URL is the first
	           portion of the URL that buyers will return to after authorizing payment                */
	
	           $serverName = $_SERVER['SERVER_NAME'];
	           $serverPort = $_SERVER['SERVER_PORT'];
	           $url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);
	
	
	           /* The returnURL is the location where buyers return when a
	            payment has been succesfully authorized.
	            The cancelURL is the location buyers are sent to when they hit the
	            cancel button during authorization of payment during the PayPal flow                 */
	
	           $returnURL =$url."/PaymentDetails.php";
	           $cancelURL ="$url/SetPayChained.php" ;
	           $currencyCode=$_REQUEST['currencyCode'];
	           $memo=$_REQUEST["memo"];
	           $feesPayer=$_REQUEST["feesPayer"];
	           $email = $_REQUEST["email"];
	           $requested='';
	           $receiverEmail='';
	           $amount='';
	           $primary='';
	           $count= count($_POST['receiveremail']);
	           
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
				$payRequest->clientDetails->applicationId =APPLICATION_ID;
	           	$payRequest->clientDetails->deviceId = DEVICE_ID;
	           	$payRequest->clientDetails->ipAddress = "127.0.0.1";
	           	$payRequest->currencyCode = $currencyCode;
	           	$payRequest->senderEmail = $email;
	           	$payRequest->requestEnvelope = new RequestEnvelope();
	           	$payRequest->requestEnvelope->errorLanguage = "en_US";
	           	          	
	           	$receiver1 = new receiver();
	           	$receiver1->email = $_POST['receiveremail'][0];
	           	$receiver1->amount = $_REQUEST['amount'][0];
	           	$receiver1->primary = $_REQUEST['primary'][0];
	           	
	           	$receiver2 = new receiver();
	           	$receiver2->email = $_POST['receiveremail'][1];
	           	$receiver2->amount = $_REQUEST['amount'][1];
	           	$receiver2->primary = $_REQUEST['primary'][1];
	           	
	           	$payRequest->receiverList = array($receiver1,$receiver2);
	           	
	           	$payRequest->feesPayer = $feesPayer;
	           	$payRequest->memo = $memo;
	           	
	           	
	           /* Make the call to PayPal to get the Pay token
	            If the API call succeded, then redirect the buyer to PayPal
	            to begin to authorize payment.  If an error occured, show the
	            resulting errors
	            */
	           $ap = new AdaptivePayments();
	           $response=$ap->Pay($payRequest);
	           
	           if(strtoupper($ap->isSuccess) == 'FAILURE')
				{
					$_SESSION['FAULTMSG']=$ap->getLastError();
					$location = "APIError.php";
					header("Location: $location");
				
				}
				else
				{
					$_SESSION['payKey'] = $response->payKey;
					if($response->paymentExecStatus == "COMPLETED")
					{
						$location = "PaymentDetails.php";
						header("Location: $location");
					}
				
					else
					{
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