<?php
                  
require_once('constants.php');
function __autoload($class_name) {
    include $class_name . '.php';
}
     
class EHCS 
{                
  private static $instance;
  private $pagePath; 
  private $navPath;      
  private $permissionRequired; 
  private $htmlTitle;
  private $htmlHead;
  private $htmlContent;
  private $footerContent;
  
  public static function getInstance() 
  {
    if(!self::$instance) 
    { 
      self::$instance = new self(); 
    }                        

    return self::$instance;
  } 
  
  public function setPagePath($pagePath)
  {
    $this->pagePath = $pagePath;  
  }
  public function setNavPath($navPath)
  {
    $this->navPath = $navPath;  
  }
  public function setPermissionRequired($permissionRequired)
  {
    $this->permissionRequired = $permissionRequired;  
  }
  public function setHtmlTitle($htmlTitle)
  {
    $this->htmlTitle = $htmlTitle;  
  }
  public function setHtmlHead($htmlHead)
  {
    $this->htmlHead = $htmlHead;  
  }
  public function setHtmlContent($htmlContent)
  {
    $this->htmlContent = $htmlContent;  
  }
  public function setFooterContent($footerContent)
  {
    $this->footerContent = $footerContent;  
  }

  public function init() 
  {  
    $this->checkUserPermission();
  } 
  public function display() {          
    PageContent::getInstance()->displayHtmlHeader($this->htmlTitle, $this->htmlHead);  
    
    $errorCode = Request::getInstance()->getGet('error');
    
    if($errorCode !== NULL)
    {
      $message = Redirector::getInstance()->getErrorMessage($errorCode);
      $messageType = MSG_ERROR;
    }
    else
    {
      $successCode = Request::getInstance()->getGet('success');
      if($successCode !== NULL)
      {
        $message = Redirector::getInstance()->getSuccessMessage($successCode);
        $messageType = MSG_SUCCESS; 
      }
    }
                     
    PageContent::getInstance()->displayHtmlBody(User::getInstance(), $this->htmlContent, $this->navPath, $message, $messageType);           
    PageContent::getInstance()->displayHtmlFooter($this->footerContent);   
  }
                  
  //===================================== private =====================================
  
  private function __construct() 
  {    
    // prevent server caching of pages
    header("Cache-Control: no-store, no-cache, must-revalidate"); 
    header("Cache-Control: post-check=0, pre-check=0", false); 
    header("Pragma: no-cache"); 
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
    session_cache_limiter('private, must-revalidate');
    
    set_include_path('c:/wamp/www/petprojects/echs');
    session_start();
  }
  
  private function checkUserPermission() 
  {                          
    if($this->permissionRequired) 
    {                  
      if(!User::getInstance()->isValid() )
      {                                   
        Redirector::getInstance()->error(ERROR_LOGIN, $this->pagePath); 
      }
      
      if(!User::getInstance()->getPermission($this->permissionRequired)) 
      {                                                    
        Redirector::getInstance()->error(ERROR_PERMISSION);  
      }
    }
  } 
}
?>
