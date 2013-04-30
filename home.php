<?php
                  
require_once 'util/EHCS.php';
$EHCS = new EHCS();         
$EHCS->pagePath = 'home.php';
$EHCS->navPath = NAV_HOME;

// perform checks and redirect if needed
$EHCS->init();         

// we're still on the page, let's build the content
$EHCS->htmlTitle = 'Home';
$EHCS->htmlContent = $EHCS->pageContent->getLoginForm();     
$EHCS->display();

?>
