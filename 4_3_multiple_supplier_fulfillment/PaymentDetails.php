<?php

/******************************************************
PaymentDetails.php
This page is specified as the ReturnURL for the Pay Operation.
When returned from PayPal this page is called.
Page get the payment details for the payKey either stored
in the session or passed in the Request.
******************************************************/

require_once 'lib/AdaptivePayments.php';
require_once 'lib/Stub/AP/AdaptivePaymentsProxy.php';

session_start();
	if(isset($_GET['cs'])) {
		$_SESSION['payKey'] = '';
	}
	try {
		if(isset($_REQUEST["payKey"])){
			$payKey = $_REQUEST["payKey"];}
			if(empty($payKey))
			{
				$payKey = $_SESSION['payKey'];
			}
			
			$pdRequest = new PaymentDetailsRequest();
			$pdRequest->payKey = $payKey;
			$rEnvelope = new RequestEnvelope();
			$rEnvelope->errorLanguage = "en_US";
			$pdRequest->requestEnvelope = $rEnvelope;
			
			$ap = new AdaptivePayments();
			$response=$ap->PaymentDetails($pdRequest);
			
			/* Display the API response back to the browser.
			   If the response from PayPal was a success, display the response parameters'
			   If the response was an error, display the errors received using APIError.php.
			 */
			if(strtoupper($ap->isSuccess) == 'FAILURE')
			{
				$_SESSION['FAULTMSG']=$ap->getLastError();
				$location = "APIError.php";
				header("Location: $location");
			
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
  <title>PayPal PHP SDK -Payment Details</title>
  <link href="common/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="main">
<div id="request_form">
 
    <h3><b>Payment
    Details</b></h3><br>
    <br>

   <table align="center">
    <tr>
			<td class="thinfield"><?php if(isset($response->paymentInfoList->paymentInfo[0]->transactionId))echo "Transaction ID:"  ?></td>
			<td class="thinfield"><?php echo $response->paymentInfoList->paymentInfo[0]->transactionId ; ?></td>
		</tr>	
    	<tr>
			<td class="thinfield">Transaction Status:</td>
			<td class="thinfield"><?php echo $response->status ; ?></td>
		</tr>	
		<tr>
			<td class="thinfield">Pay Key:</td>
			<td class="thinfield"><?php echo $response->payKey ; ?></td>
		</tr>
      	<tr>
			<td class="thinfield">Sender Email:</td>
			<td class="thinfield"><?php echo $response->senderEmail ; ?></td>
		</tr>
		<tr>
			<td class="thinfield">Action Type:</td>
			<td class="thinfield"><?php echo $response->actionType ; ?></td>
		</tr>
		<tr>
			<td class="thinfield">Fees Payer:</td>
			<td class="thinfield"><?php echo $response->feesPayer ; ?></td>
		</tr>
		<tr>
			<td class="thinfield">Currency Code:</td>
			<td class="thinfield"><?php echo $response->currencyCode ; ?></td>
		</tr>
		<tr>
			<td class="thinfield">Preapproval Key:</td>
			<td class="thinfield"><?php 
					if(isset($response->preapprovalKey))
					{
						echo $response->preapprovalKey;
					}
					else
					{
						echo "Not Applicable" ;
					
					}
					
					 
				?>
			</td>
		</tr>
    </table>
 </div>
 </div>
</body>
</html>