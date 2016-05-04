<?php

/**
 * This is a simple file to recieve the get parameter from runkeper and save the token for the user
 */
session_start();
require_once('../../application/control/class_controllers_sp.ini.php');


$under= new UnderArmour(___APP__MAPRUN___id,___APP__MAPRUN___sec,___APP__MAPRUN___url);



if(isset($_GET["code"]) && $_GET["code"] )
{

    if($token = $under->exchangeCodeforToken($_GET["code"]))
	{   
		$tokens=json_encode($token); // store token


		/*
	    $strava->setAccessToken($token);    
	    $response = $strava->get('athlete/activities');    */
	}
	else
	{
	    
	    $url =  $under->requestAuthorizationURL();
	    echo "<a href='$url'> click </a>";
	    
	}
 
}
else
{
    
    $url =  $under->requestAuthorizationURL();
    echo "   <a href='$url'> click </a>";
    
}





?>