<?php
                  
require_once '../../../lib/EHCS.php';  
$EHCS = EHCS::getInstance();    
$user = User::getInstance(); 
         
if($user->validateActivateForm())
{                       
  $result = $user->verifyActivateLink();
  
  if($result->num_rows === 1)
  {                       
    $row = $result->fetch_object();
    $user->init();                    
    $user->setPermission($row->Role);
    $user->setProperty(PROPERTY_USER_ID, $row->UserId);
    
    // take to change-password page
    Redirector::getInstance()->success(SUCCESS_USER_ACTIVATE); 
  }          
  else
  {    
    // take to report-problem page
    Redirector::getInstance()->error(FAILED_USER_ACTIVATE);
  }
} 
else                                                                  
{
  Redirector::getInstance()->error(ERROR_LOGIN);
}
?>
