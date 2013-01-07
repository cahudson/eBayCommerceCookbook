<?php
/********************************************
merchandisingConstants.php

Constants used for Merchandising API calls.

********************************************/

// eBay developer API Key for production
DEFINE("API_KEY","<YOUR_API_KEY>");

// eBay Merchandising API constants
DEFINE("MERCHANDISING_API_ENDPOINT","http://svcs.ebay.com/MerchandisingService");
DEFINE("MERCHANDISING_SANDBOX_API_ENDPOINT","http://svcs.sandbox.ebay.com/MerchandisingService");
DEFINE("MERCHANDISING_API_VERSION","1.1.0");

// eBay site to use - 0 = United States
DEFINE("GLOBAL_ID","EBAY-US");

// encoding format - JSON
DEFINE("REQUEST_ENCODING","JSON");
DEFINE("RESPONSE_ENCODING","JSON");
?>