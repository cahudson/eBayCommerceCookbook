<?php
/***********************************************************
SetPay.php

This is the main web page for the Pay Checkout sample.
The page allows the user to enter amount and currency type
and receiver email and other data needed for AdaptivePayments Pay API.
When the user clicks the Submit button, PayReceipt.php is
called.
Called by index.html.

***********************************************************/
// clearing the session before starting new API Call
require_once 'web_constants.php';
session_unset();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
  <meta name="generator" content=
  "HTML Tidy for Windows (vers 14 February 2006), see www.w3.org">

  <title>PayPal Platform - Pay Center- Samples</title>
 <link href="common/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<br/>
        <div id="jive-wrapper">
            <div id="jive-header">
                <div id="logo">
                    <span >You must be Logged in to <a href="<?php echo DEVELOPER_PORTAL;?>" target="_blank">PayPal sandbox</a></span>
                    <a title="Paypal X Home" href="#"><div id="titlex"></div></a>
                </div>
            </div>

<div id="main">
<?php include 'menu.html'?>
<div id="request_form">
 
    <form id="Form1" name="Form1"action="PayChainedReceipt.php" method="post">
      <table class="api">
        <tr>
          <td><h3>Adaptive Payments -
          Pay</h3></td>
        </tr>

       
      </table>

      <table align="center">
      	<tr>
          <td class="thinfield">Sender's Email:</td>

          <td><input type="text" size="50" maxlength="64" name=
          "email" value="platfo_1255077030_biz@gmail.com"></td>
        </tr>
        <tr>
			<td class="thinfield">Memo:</td>
			<td><input type="text" size="50" maxlength="32" name="memo"
				value="chained" ></td>
		</tr>
		<tr>
			<td class="thinfield">Fees Payer:</td>
			<td><input type="text" size="50" maxlength="32" name="feesPayer"
				value="EACHRECEIVER" /></td>
	    </tr>
        <tr>
          <td class="thinfield" width="52">currencyCode:</td>

          <td><select name="currencyCode">
            <option value="USD" selected>
              USD
            </option>

            <option value="GBP">
              GBP
            </option>

            <option value="EUR">
              EUR
            </option>

            <option value="JPY">
              JPY
            </option>

            <option value="CAD">
              CAD
            </option>

            <option value="AUD">
              AUD
            </option>
          </select></td>
        </tr>

        <tr>
          <td class="thinfield" height="14" colspan="3">
            <p align="center">Pay Details</p>
          </td>
        </tr>

         <tr>
		 		<td class="thinfield" width="52">Payee</td>
		 		<td class="thinfield">ReceiverEmail :</td>
		 		<td class="thinfield">Amount:</td>
		 		<td class="thinfield">Primay Receiver:</td>

		 </tr>

		 <tr>
		 		<td width="52">
		 		<P align="left">1</P>
		 		</td>
		 		<td><input type="text" name="receiveremail[]" size="64"
		 			value="platfo_1255612361_per@gmail.com"></td>
		 		<td><input class="smalltext" type="text" name="amount[]"
		 			value="1.0"></td>
		 		<td><input class="smalltext" type="text" name="primary[]"
		 			value="false"></td>
		 </tr>
		 <tr>
		 		<td width="52">
		 		<P align="left">2</P>
		 		</td>
		 		<td><input type="text" name="receiveremail[]" size="64"
		 			value="platfo_1255611349_biz@gmail.com"></td>
		 		<td><input class="smalltext" type="text" name="amount[]"
		 			value="2.0"></td>
		 		<td><input class="smalltext" type="text" name="primary[]"
		 			value="true"></td>
	    </tr>
          <tr>
          </tr>
          <tr> 
               <td></td>       
               <td colspan='3'>
               <font style="font-size:12px"> NOTE: Chained payment requires one primary receiver, Note that one primary receiver ia set to true</font></td>
          </tr>
  <tr>
	<td>
	<br />
	</td>
	</tr>

	<tr align="center">
<td colspan="2">
<a class="pop-button primary" onclick="document.Form1.submit();" id="Submit"><span>Submit</span></a>
			</td>
		</tr>
    
      
      </table>
    </form>
 </div>
 </div> 
</body>
</html>