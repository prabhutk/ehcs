<?php
                  
require_once 'util/EHCS.php';
$EHCS = new EHCS();         
$EHCS->pagePath = 'error.php';
$EHCS->htmlTitle = 'Oops';    
$EHCS->loadModule(array(MODULE_PAGE_CONTENT));     
$EHCS->htmlContent = pageContent($EHCS->getGet('error'), $EHCS->getErrorDescription($EHCS->getGet('error')), $EHCS->pageContent);
$EHCS->display();

function pageContent($error, $errorMessage, $pageContent)
{               
  if($error == ERROR_LOGIN)
  {
      return $pageContent->getLoginForm(); 
  }
  else
  {
    return '<p class="text-error">' . $errorMessage . '</p>';
  }
}

?>
