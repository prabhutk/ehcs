<?php
                  
require_once '../../../lib/EHCS.php'; 
$EHCS = EHCS::getInstance();    
$user = User::getInstance();    
  
if($user->validateResetForm())
{        
  $user->saveReset();
  Redirector::getInstance()->success(SUCCESS_USER_RESET);
} 
else                                                                  
{
  Redirector::getInstance()->error(FAILED_USER_ACTIVATE);
}
?>
