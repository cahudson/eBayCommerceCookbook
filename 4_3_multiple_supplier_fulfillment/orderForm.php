<?php
/***********************************************************
orderForm.php

Sample order form that kicks off chained payment. In practice
this would be your shopping cart checkout page.

Calls processOrder.php from form submittal

***********************************************************/
?>
<!DOCTYPE html>
<html>
<head>
<title>Order Form - Chained Payments</title>
<style>
* {margin: 0; padding: 0;}
body {background: #fff; color: #000; font: normal 90%/1.5 tahoma, verdana, sans-serif;}
h1 {font-size: 2.9em; font-weight: bold; margin: 1em 0 1em 10px;}
form {padding: 0 10px; width: 700px;}
legend {font-size: 2em; padding-left:5px;padding-right:5px; position: relative;}
fieldset {border: 1px solid #ccc; border-radius: 5px; float: left; padding: 10px; width: 640px;}
td {padding: 2px;}
</style>
</head>
<body>
<div id="orderForm">
<fieldset>
<legend>Order Form</legend>
  <form id="orderForm" name="orderForm"action="processOrder.php" method="post">
  	<div>
    	Sender's Email: <input type="text" size="50" maxlength="64" name="email" 
    	placeholder="Sandbox account email" value="<YOUR SANDBOX SENDERS EMAIL ADDRESS>">
    </div>
    <table align="center">
    	<thead>
      <tr>
        <td>item #</td>
        <td>Item :</td>
        <td>Qty:</td>
        <td>Price:</td>
        <td>Receiver:</td>
      </tr>
      </thead>
      <tr>
        <td><input type="hidden" name="item[]" value="1001" />1001</td>
        <td>Blue pencil</td>
        <td><input type="text" name="qty[]" value="2" /></td>
        <td><input type="text" name="price[]" value="1.00" /></td>
        <td><input type="text" name="source[]" value="0" /></td>
      </tr>
      <tr>
        <td><input type="hidden" name="item[]" value="1002" />1002</td>
        <td>Red pencil</td>
        <td><input type="text" name="qty[]" value="1" /></td>
        <td><input type="text" name="price[]" value="0.90" /></td>
        <td><input type="text" name="source[]" value="1" /></td>
      </tr>
      <tr>
        <td><input type="hidden" name="item[]" value="1003" />1003</td>
        <td>Eraser</td>
        <td><input type="text" name="qty[]" value="3" /></td>
        <td><input type="text" name="price[]" value="1.25" /></td>
        <td><input type="text" name="source[]" value="1" /></td>
      </tr>
      <tr>
        <td><input type="hidden" name="item[]" value="2001" />2001</td>
        <td>Cup</td>
        <td><input type="text" name="qty[]" value="3" /></td>
        <td><input type="text" name="price[]" value="5.25" /></td>
        <td><input type="text" name="source[]" value="2" /></td>
      </tr>
  	</table>
    <div><input type="submit" value="Submit" /></div>
  </form>
  </fieldset>
</div>
</body>
</html>