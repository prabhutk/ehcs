<?php                   
                  
require_once 'util/EHCS.php';    
$EHCS = EHCS::getInstance();
$EHCS->setPermissionRequired(ROLE_OPERATOR);     
$EHCS->setPagePath(PAGE_HOME);
$EHCS->setNavPath(NAV_HOME);

// perform checks and redirect if needed
$EHCS->init();         

// we're still on the page, let's build the content
$EHCS->setHtmlTitle('Home');        
$EHCS->setHtmlContent('');
$EHCS->display();
?>
