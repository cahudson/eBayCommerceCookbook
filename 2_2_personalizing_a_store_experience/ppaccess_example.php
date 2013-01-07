<?php
/********************************************
ppaccess_example.php

Example launch file showing if the customer
has logged in via the PayPal Identity service.
If the user has not logged in then a log in button
is provided which will launch the auth url.
Once logged in the token and profile info is shown.
********************************************/

// Start our session.
session_start();

// Require the auth class.
require_once('auth.php');

// Handle actions selected.
if (isset($_GET['action'])) {
	if ($_GET['action'] = 'logout') {
			// Clean up session and flags.
			unset($_SESSION['TOKEN']);
			unset($_SESSION['PROFILE']);
			$flgLoggedIn = false;
	}
}

// Check if the user is logged in.
if (isset($_SESSION['TOKEN'])) {
	
	// User logged in, set flag.
	$flgLoggedIn = true;
	
} else {
	
	// User not logged in, set flag.
	$flgLoggedIn = false;
	// Initialize a new PayPal Access instance.
  $ppaccess = new PayPalAccess();
	// Get the authentication url for logging in.
	$auth_url = $ppaccess->get_auth_url();
}

?>
<!DOCTYPE html>
<html>
<head>
<title>PayPal Access OpenID</title>
<style>
* {margin: 0; padding: 0;}
body {background: #fff; color: #000; font: normal 62.5%/1.5 tahoma, verdana, sans-serif;}
legend {font-size: 2em; padding-left:5px;padding-right:5px; position: relative;}
fieldset {border: 1px solid #ccc; border-radius: 5px; float: left; padding: 10px; margin: 10px; width: 320px;}
li {clear: both; list-style-type: none; margin: 0 0 10px;
   white-space: pre-wrap;      /* CSS3 */   
   white-space: -moz-pre-wrap; /* Firefox */    
   white-space: -pre-wrap;     /* Opera <7 */   
   white-space: -o-pre-wrap;   /* Opera 7 */    
   word-wrap: break-word;      /* IE */}
button {width:168px;height:31px;cursor:pointer; margin-bottom:10px;}
</style>
<script>

// Initialize the button click event handlers.
function init() {
	
	<?php 
	// Set button handlers based on logged in status.
	if ($flgLoggedIn) { 
		// User is logged in.
	?>
		var buttonLogout = document.getElementById('logout');
		buttonLogout.addEventListener('click', launchLogout, false);
	<?php 
	} else { 
		// User is not logged in.
	?>
		var buttonLogin = document.getElementById('login');
		buttonLogin.addEventListener('click', launchLogin, false);
	<?php } ?>
}

// Helper functions for button clicks.
function launchLogin() {
	window.open('<?php echo $auth_url;?>','_blank','height=550,width=400');
}
function launchLogout() {
	window.location.href = 'ppaccess_example.php?action=logout';
}

// Add the window load event listener.
window.addEventListener('load', init, false);

</script>
</head>
<body>
	<?php
	if ($flgLoggedIn) { 
		// User logged in.
	?>
  <fieldset>
		<legend>PayPal Access - Logged In</legend>
    <div><button id="logout">Log Out</button></div>
  </fieldset>
  <fieldset>
    <legend>Profile</legend>
    <ol>
      <li>Name: <?php echo $_SESSION['PROFILE']->name;?></li>
      <li>Email: <?php echo $_SESSION['PROFILE']->email;?></li>
      <li>Address:<br/><?php echo $_SESSION['PROFILE']->address->street_address;?><br/><?php echo $_SESSION['PROFILE']->address->locality.", ".$_SESSION['PROFILE']->address->region." ".$_SESSION['PROFILE']->address->postal_code;?></li>
      <li>Country: <?php echo $_SESSION['PROFILE']->address->country;?></li>
      <li>Language: <?php echo $_SESSION['PROFILE']->language;?></li>
      <li>Locale: <?php echo $_SESSION['PROFILE']->locale;?></li>
      <li>Zone: <?php echo $_SESSION['PROFILE']->zoneinfo;?></li>
      <li>User ID: <?php echo $_SESSION['PROFILE']->user_id;?></li>
    </ol>
  </fieldset>
  <fieldset>
		<legend>Token Info</legend>
    <ol>
      <li>Token Type: <?php echo $_SESSION['TOKEN']->token_type;?></li>
      <li>Expires: <?php echo $_SESSION['TOKEN']->expires_in;?></li>
      <li>Refresh Token:<br/><?php echo $_SESSION['TOKEN']->refresh_token;?></li>
      <li>ID Token:<br/><?php echo $_SESSION['TOKEN']->id_token;?></li>
    	<li>Access Token:<br/><?php echo $_SESSION['TOKEN']->access_token;?></li>
    </ol>
  </fieldset>
  <?php
	} else { 
		// User not logged in.
	?>
  <fieldset>
		<legend>PayPal Access - Not Logged In</legend>
    <div><button id="login"><img src="https://www.paypalobjects.com/en_US/Marketing/i/btn/login-with-paypal-button.png" /></button></div>
  </fieldset>
  <?php 
	}	// End check if user logged in.
	?>
</body>
</html>