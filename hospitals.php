<?php
                  
require_once 'util/EHCS.php';
$EHCS = new EHCS();         
$EHCS->permissionRequired = ROLE_DOCTOR;
$EHCS->pagePath = 'hospitals.php';    
$EHCS->navPath = NAV_HOSPITALS;

// perform checks and redirect if needed
$EHCS->init();         

// we're still on the page, let's build the content
$EHCS->htmlTitle = 'Hospitals';
$EHCS->htmlContent = pageContent();
$EHCS->display();

function pageContent()
{             
  return '<p class="text-error">' . $error . '</p>';
}

?>
