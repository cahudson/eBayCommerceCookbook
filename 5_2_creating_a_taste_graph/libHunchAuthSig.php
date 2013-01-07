<?php
/***********************************************************
libHunchAuthSig.php

Library to sign a Hunch API call based on an app_secret.

Source of file: 
http://hunch.com/developers/v1/resources/samples/#signing

***********************************************************/

// Helper function to the signUrl function.
function enc($c) {
    $c = str_replace(array('+', '/', '@', '%20'), array('%2B', '%2F', '%40', '+'), $c);
    return $c;

}

// Function to create the signed URL from the url and secret_key
// (app_secret) passed in.
function signUrl($url, $secret_key)
{
    $original_url = $url;
    $urlparts = parse_url($url);

    // Build $params with each name/value pair
    foreach (split('&', $urlparts['query']) as $part) {
        if (strpos($part, '=')) {
            list($name, $value) = split('=', $part, 2);
        } else {
            $name = $part;
            $value = '';
        }
        $params[$name] = $value;
    }

    // Sort the array by key
    ksort($params);

    // Build the canonical query string
    $canonical = '';
    foreach ($params as $key => $val) {
        $canonical .= "$key=".enc(utf8_encode($val))."&";
    }

    // Remove the trailing ampersand
    $canonical = preg_replace("/&$/", '', $canonical);

    // Build the sign
    $string_to_sign = enc($canonical) . $secret_key;

    // Calculate our actual signature and base64 encode it
    $signature = bin2hex(hash('sha1', $string_to_sign, $secret_key));

    // Finally re-build the URL with the proper string and include the Signature
    $url = "{$urlparts['scheme']}://{$urlparts['host']}{$urlparts['path']}?$canonical&auth_sig=".rawurlencode($signature);
    return $url;
}
?>