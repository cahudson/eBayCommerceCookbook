<?php
/***********************************************************
QRShareIt.php

Simple form for entering product id for QR Code referral link.

Calls QRCreateLabel.php from form submittal

***********************************************************/
?>
<!DOCTYPE html>
<html>
<head>
<title>QR Code Creation Form</title>
<style>
* {margin: 0; padding: 0;}
body {background: #fff; color: #000; font: normal 62.5%/1.5 tahoma, verdana, sans-serif;}
form {padding: 0 10px; width: 700px;}
legend {font-size: 2em; padding-left:5px;padding-right:5px; position: relative;}
fieldset {border: 1px solid #ccc; border-radius: 5px; float: left; padding: 10px; width: 320px;}
li {clear: both; list-style-type: none; margin: 0 0 10px;}
label, input {font-size: 1.3em;}
label {display: block; padding: 0 0 5px; width: 200px}
input {background-position: 295px 5px; background-repeat: no-repeat; border: 2px solid #ccc; border-radius: 5px;  padding: 5px 25px 5px 5px; width: 285px;}
input:focus {outline: none;}
input:invalid:required {background-image: url(images/asterisk.png); box-shadow: none;}
input:focus:invalid {background-image: url(images/invalid.png); box-shadow: 0px 0px 5px #b01212; border: 2px solid #b01212;}
input:valid:required {background-image: url(images/accept.png); border: 2px solid #7ab526;}
div {clear: both; float: left; margin: 10px 0; text-align: center; width: 100%;}
input[type=submit] {background: #7ab526; border: none; box-shadow: 0px 0px 5px #7ab526; color: #fff; cursor: pointer; font-size: 2em; font-weight: bold; margin: 10px auto; padding: 10px; width: auto;}
input[type=submit]:hover {box-shadow: 0px 0px 25px #7ab526; }
</style>
</head>
<body>
  <form id="qrForm" name="qrForm" action="QRCreateLabel.php" method="post">
  <fieldset>
		<legend>Create the Product QR Label</legend>
		<ol>
      <li>
      	<label for="product_id">Product ID/SKU</label>
      	<input type="text" id="product_id" name="product_id" required />
      </li>
    </ol>
    <div><input type="submit" value="Submit" /></div>
  </fieldset>
  </form>
</body>
</html>