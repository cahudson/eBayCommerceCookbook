<?php
/********************************************
authReturn.php

This file checks the return from PayPal Access.
If the log in was successful then retrieve
the token information and profile information.

Called by PayPal Access upon return.

Uses the auth.php PayPal Access library via
OpenID Connect found at:
https://github.com/jcleblanc/paypal-access.

********************************************/

session_start();

// Require the auth library.
require_once('auth.php');

// Initialize a PayPalAccess instance.
$ppaccess = new PayPalAccess();

// If the code variable is present, then returning from PayPal Access log in.
if (isset($_GET['code'])){
	
    // Ask for a set of tokens from PayPal Access.
    $token = $ppaccess->get_access_token();
		
		// Check for a token retrieval error.
		if (!isset($token->error)) {
			
			// Save the token settings in the session for debugging.
			$_SESSION['TOKEN'] = $token;
			
			// Get the profile through PayPal Access using the tokens retrieved.
			$profile = $ppaccess->get_profile();
			if (isset($profile)) {
				
				// Store the profile in the session for now.
				$_SESSION['PROFILE'] = $profile;
			}
			
			// End the session with PayPal Access.
			$ppaccess->end_session();
			
			// Echo out javascript to refresh the base window and close this window.
			echo '<script>window.opener.location.href = "ppaccess_example.php";window.close();</script>';
			
		} else {
			// An error has occurred acquiring the tokens.
			echo "Error: " . $token->error . " :: " . $token->error_description;
		}
    
//if the code parameter is not available, the user should be pushed to auth
} else {
	
    // Handle case where there was an error during auth 
		// (e.g. the user didn't log in / refused permissions / invalid_scope)
    if (isset($_GET['error_uri'])){
			
        echo "You need to log in via PayPal Access.";
				
    // If no error then need to push to PayPal Access.
    } else {
			
        // Get auth url and redirect user browser to PayPal to log in.
        $url = $ppaccess->get_auth_url();
        header("Location: $url");
    }
}
?>