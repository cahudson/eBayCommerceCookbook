<?php
/*************************************************
APIError.php

Displays error parameters.

*************************************************/
require_once 'lib/AdaptiveAccounts.php';

session_start();
$aa=$_SESSION['result'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
    <title>PayPal Platform PHP API Response</title>
  <link href="common/style.css" rel="stylesheet" type="text/css" />
</head>

<body >
<div id="main">
<div id="request_form">
  
       
   
   
    <table align="center" width="650px">
    <tr>
    <td>
    <h3><b>The PayPal API has returned
        an error!</b></h3></td>
    </tr>
      <?php  //it will print if any URL errors
    if(isset($_SESSION['curl_error_no'])) {
            $errorCode= $_SESSION['curl_error_no'] ;
            $errorMessage=$_SESSION['curl_error_msg'] ;
	
    

?>


      <tr>
        <td class="thinfield">Error Number:</td>

        <td class="thinfield"><?php echo $errorCode ?></td>
      </tr>

      <tr>
        <td class="thinfield">Error Message:</td>

        <td class="thinfield"><?php echo $errorMessage ?></td>
      </tr>
    </table><?php } else { if(isset($_SESSION['FAULTMSG'])) {
    	
    	$fault = $_SESSION['FAULTMSG'];
    }

/* If there is no URL Errors, Construct the HTML page with
   Response Error parameters.
   */
?>
	

    <table width ="450px" align="center" >
      <tr>
      	<td><?php  
		        if(is_array($fault->error))
		        {
		        	echo '<table width =\"450px\" align=\"center\">';
		        	foreach($fault->error as $err) {
		        		echo '<tr>';
		        		echo '<td>';
		        			echo 'Error ID: ' . $err->errorId . '<br />';
		        			echo 'Domain: ' . $err->domain . '<br />';
		        			echo 'Severity: ' . $err->severity . '<br />';
		        			echo 'Category: ' . $err->category . '<br />';
		        			echo 'Message: ' . $err->message . '<br />';
						if(empty($err->parameter)) {
		        				echo '<br />';
		        			}
		        			else {
		        				echo 'Parameter: ' . $err->parameter . '<br /><br />';
		        			}
		        			
		        		echo '</td>';
		        		echo '</tr>';
		        	}
		        	echo '</table>';
		        }
		        else
		        {
		        	echo 'Error ID: ' . $fault->error->errorId . '<br />';
        			echo 'Domain: ' . $fault->error->domain . '<br />';
        			echo 'Severity: ' . $fault->error->severity . '<br />';
        			echo 'Category: ' . $fault->error->category . '<br />';
        			echo 'Message: ' . $fault->error->message . '<br />';
				if(empty($fault->error->parameter)) {
        				echo '</br>';
        			}
        			else {
        				echo 'Parameter: ' . $fault->error->parameter . '<br /><br />';
        			}
		        }
        		 
        		
        	?></td>
      </tr>
      <?php } //end else ?>

    </table>
   </div>
   </div>
</body>
</html>