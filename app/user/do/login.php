<?php
                  
require_once '../../../lib/EHCS.php'; 
$EHCS = EHCS::getInstance();    
$user = User::getInstance();    
  
if($user->validateLoginForm())
{               
  $result = $user->authenticate();
  
  if($result->num_rows === 1)
  {            
    $row = $result->fetch_object();
    
    $user->init();                    
    $user->setPermission($row->Role);
    $user->setProperty(PROPERTY_USER_ID, $row->UserId);
    Redirector::getInstance()->success(SUCCESS_LOGIN); 
  }          
  else
  {    
    Redirector::getInstance()->error(FAILED_LOGIN);
  }
} 
else                                                                  
{
  Redirector::getInstance()->error(ERROR_LOGIN);
}
?>
