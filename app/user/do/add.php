<?php
                  
require_once '../../../lib/EHCS.php'; 
$EHCS = EHCS::getInstance();    
  
if(User::getInstance()->validateAddForm())
{                                           
  // insert into db
  $login = User::getInstance()->save();
  $email = Request::getInstance()->getPost('email');
  $html = '<div>Click <a href="' . BASE_URL . PAGE_USER_ACTIVATE . '.php?email=' . $email . '&key=' . $login . '">here</a> to activate your account</div>';                     
  // send out email
  $EmailSender = EmailSender::getInstance();
  $EmailSender->send($email, '', $html);
  Redirector::getInstance()->success(SUCCESS_USER_ADD, '/hospitals'); 
} 
else                                                                  
{
  Redirector::getInstance()->error(ERROR_USER_ADD);
} 

?>
