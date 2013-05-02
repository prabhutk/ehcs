<?php
                  
require_once 'util/EHCS.php';
$EHCS = EHCS::getInstance();         
$EHCS->setPagePath(PAGE_ERROR);
$EHCS->setHtmlTitle('Oops');    

$errorCode = Request::getInstance()->getGet('error'); 
   
if($errorCode == ERROR_LOGIN)
{
    $EHCS->setHtmlContent(User::getInstance()->getLoginForm()); 
}

$EHCS->display();

?>
