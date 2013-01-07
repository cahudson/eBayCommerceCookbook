<?php
/***********************************************************
donateOption.php

Sample form for donation option on check out.

Calls doParallelPmt.php from form submittal

***********************************************************/
?>
<!DOCTYPE html>
<html>
<head>
<title>Donate on Checkout Form</title>
<style>
* {margin: 0; padding: 0;}
body {background: #fff; color: #000; font: normal 62.5%/1.5 tahoma, verdana, sans-serif;}
h1 {font-size: 2.9em; font-weight: bold; margin: 1em 0 1em 10px;}
form {padding: 0 10px; width: 700px;}
legend {font-size: 2em; padding-left:5px;padding-right:5px; position: relative;}
fieldset {border: 1px solid #ccc; border-radius: 5px; float: left; padding: 10px; width: 320px;}
fieldset:nth-of-type(1) {margin-right: 10px;}
li {clear: both; list-style-type: none; margin: 0 0 10px;}
label, input {font-size: 1.3em;}
label {display: block; padding: 0 0 5px; width: 200px}
input {background-position: 295px 5px; background-repeat: no-repeat; border: 2px solid #ccc; border-radius: 5px;  padding: 5px 25px 5px 5px; width: 285px;}
input:focus {outline: none;}
input:invalid:required {background-image: url(images/asterisk.png); box-shadow: none;}
input:focus:invalid {background-image: url(images/invalid.png); box-shadow: 0px 0px 5px #b01212; border: 2px solid #b01212;}
input:valid:required {background-image: url(images/accept.png); border: 2px solid #7ab526;}
input[type=number] {background-position: 275px 5px; text-align: left;}
input[type=checkbox] {font-size: 2em; text-align: left; width:20px;}
div {clear: both; float: left; margin: 10px 0; text-align: center; width: 100%;}
div label {width: 100%;}
input[type=submit] {background: #7ab526; border: none; box-shadow: 0px 0px 5px #7ab526; color: #fff; cursor: pointer; font-size: 3em; font-weight: bold; margin: 20px auto; padding: 15px; width: auto;}
input[type=submit]:hover {box-shadow: 0px 0px 25px #7ab526; }
</style>
</head>
<body>
  <form id="donationForm" name="donationForm"action="doParallelPmt.php" method="post">
  <fieldset>
		<legend>Contribute to a Cause?</legend>
		<ol>
    	<li><input type="checkbox" id="flagDonation" name="flagDonation" value="1" /> Yes I would like to contribute.</li>
    	<li>
      	<label for="charityEmail">Select a charity:</label>
        <select id="charityEmail" name="charityEmail">
          <option value="donate@childsplaycharity.org">Child's Play (childsplaycharity.org)</option>
          <option value="servic_1241987644_biz@aduci.com">My Charity (mycharity.org)</option>
        </select>
      </li>
      <li><label for="donation">Donation Amount</label><input type="number" placeholder="&#36;" min="1" max="1000" size="50" id="donation" name="donation" value="1" /></li>
    </ol>
    <div><input type="submit" value="Submit" /></div>
  </fieldset>
  </form>
</body>
</html>