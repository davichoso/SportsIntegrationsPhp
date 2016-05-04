<?php
session_start();
require_once('../../application/control/class_controllers_sp.ini.php');
error_reporting(-1);
$m = new Moves(___APP__MOVES___id,___APP__MOVES___sec,___APP__MOVES___url);

if (isset($_GET['code']) && $_GET['code']) {
    $request_token = $_GET['code'];
    
    
    if($tokens = $m->auth($request_token))
    {
        //Save this token for all future request for this user
        $tokens=json_encode($tokens);
        
		
        
    }
    else
    {
        $request_url = $m->requestURL();
        ?>
        
        <a href="<?php echo $request_url; ?>">aqui</a>
        <?php
        
    }
    
}
else
    {
        $request_url = $m->requestURL();
        ?>
     
        <a href="<?php echo $request_url; ?>">aqui</a>
        <?php
        
    }
?>