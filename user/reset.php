<?php
                  
require_once '../util/EHCS.php';
$EHCS = EHCS::getInstance();    
$EHCS->setPermissionRequired(ROLE_OPERATOR);     
$EHCS->setPagePath(PAGE_USER_RESET);
// $EHCS->setNavPath(NAV_USER);

// perform checks and redirect if needed
$EHCS->init();         

// we're still on the page, let's build the content 
$EHCS->setHtmlTitle('Account activated');        
$EHCS->setHtmlContent('<div class="span4">' . User::getInstance()->getResetForm() . '</div>');
$EHCS->display();

?>
