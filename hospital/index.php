<?php
                  
require_once '../util/EHCS.php';
$EHCS = EHCS::getInstance();    
$EHCS->setPermissionRequired(ROLE_DOCTOR);     
$EHCS->setPagePath(PAGE_HOSPITAL);
$EHCS->setNavPath(NAV_HOSPITAL);

// perform checks and redirect if needed
$EHCS->init();         

// we're still on the page, let's build the content                                      
$EHCS->setHtmlTitle('Hospitals');        
// $EHCS->setHtmlContent('<div class="span4">' . User::getInstance()->getAddForm() . '</div>');
$EHCS->display();

?>
