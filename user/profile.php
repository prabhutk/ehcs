<?php
                  
require_once '../util/EHCS.php';
$EHCS = EHCS::getInstance();    
$EHCS->setPermissionRequired(ROLE_OPERATOR);     
$EHCS->setPagePath(PAGE_USER);
$EHCS->setNavPath(NAV_ACCOUNT);

// perform checks and redirect if needed
$EHCS->init();         

// we're still on the page, let's build the content 
$EHCS->setHtmlTitle('Users');        
// $EHCS->setHtmlContent('<div class="span4">' . User::getInstance()->getAddForm() . '</div>');
$EHCS->display();

?>
