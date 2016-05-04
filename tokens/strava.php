<?php

/**
 * This is a simple file to recieve the get parameter from runkeper and save the token for the user
 */
session_start();
require_once('../../application/control/class_controllers_sp.ini.php');
$strava = new StravaApi(___APP__STRAVA___id,___APP__STRAVA___sec);

if(isset($_GET["code"]) && $_GET["code"] )
{
    if($token = $strava->tokenExchange($_GET["code"]))
	{   
		$token = $token->access_token;
	    $strava->setAccessToken($token);    
	    $response = $strava->get('athlete/activities');   
	}
	else
	{
	    
	    $url =  $strava->authenticationUrl(___APP__STRAVA___url);
	    echo "  <a href='$url'> click </a>";
	    
	}
 
}
else
{
    
    $url =  $strava->authenticationUrl(___APP__STRAVA___url);
    echo "  <a href='$url'> click </a>";
    
}





?>