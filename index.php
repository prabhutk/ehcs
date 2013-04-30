<?php
                  
require_once 'util/EHCS.php';
$EHCS = new EHCS(); 
$EHCS->htmlTitle = 'Login';
$EHCS->loadModule(array(MODULE_PAGE_CONTENT));     
$EHCS->htmlContent = $EHCS->pageContent->getLoginForm();  
$EHCS->display();

?>
