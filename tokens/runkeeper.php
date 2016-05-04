<?php

/**
 * This is a simple file to recieve the get parameter from runkeper and save the token for the user
 */


$runkeeper = new RunKeeperAPI(___APP__RUNKEEPER___id,___APP__RUNKEEPER___sec,___APP__RUNKEEPER___url);
$runkeeper_auth_url = $runkeeper->connectRunkeeperButtonUrl();
/**getting the code from runkeeper as a response as a get parameter*/

if(isset($_GET["code"]) && $_GET["code"] )
{
    if($token = $runkeeper->getRunkeeperToken($_GET["code"]))// exchange the auth code for a access token 
    {
        //if ok, store the tokens            

    }
    else
    {
       // error
     
    }
}



?>
	

	
	
