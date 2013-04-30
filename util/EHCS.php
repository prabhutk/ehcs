<?php

require_once 'constants.php'; 

class EHCS 
{        
  var $pagePath;      
  var $navPath;      
  var $permissionRequired; 
  var $baseUrl = 'http://localhost/petprojects/ehcs';
  
  var $htmlTitle;
  var $htmlHead;
  var $htmlContent;
  
  var $pageContent;
  
  function init() 
  {
    $this->initSession();
    $this->initDatabase();  
    $this->checkUserPermission();
  }
  
  function redirectWithError($error) 
  {      
    switch ($error) 
    {                              
    		case ERROR_LOGIN: 
          $path = 'index.php';
    		  break;
    		case ERROR_CONNECTION: 
        case ERROR_DB: 
    		case ERROR_PERMISSION: 
        default:
          $path = 'error.php';
          break;
    } 
    header("location:$this->baseUrl/$path.php?error=$error&path=$pagePath");
    exit;
  }  
  
  function getErrorDescription($error)
  {
    switch ($error) 
    {
    		case ERROR_CONNECTION: 
          $errorDescription = 'Could not connect to data source';     
          break;
        case ERROR_DB: 
          $errorDescription =  'Could not connect to database';   
          break;
    		case ERROR_LOGIN: 
          $errorDescription =  'Please login to continue';    
          break;
    		case ERROR_PERMISSION: 
          $errorDescription =  'That is a restricted page';  
          break;
        default:
          $errorDescription =  'An unidentified error has occurred';  
          break;
    } 
    
    return $errorDescription;
  }
  
  function initSession() 
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
                  
  //===================================== Database =====================================
  
  function initDatabase() 
  { 
    $databaseConnection = @mysql_connect('localhost', 'root', 'mysqlrt');

    if($databaseConnection == '')
    {                                                                   
        $this->redirectWithError(ERROR_CONNECTION); 
    }
    
    $databaseHandle = mysql_select_db('ehcs');
    
    if(!$databaseHandle)
    {                                                          
        $this->redirectWithError(ERROR_DB); 
    }
  }
          
  //===================================== User =====================================
  
  function checkUserPermission() 
  {                                         
    require_once 'User.php';
    
    if($this->permissionRequired !== NULL) 
    {                   
      $user = new User();
      if(!$user->isValid() )
      {
        $this->redirectWithError(ERROR_LOGIN); 
      }
      if(!$user->getPermission($this->permissionRequired)) 
      { 
        $this->redirectWithError(ERROR_PERMISSION);  
      }
    }
  }  
  
  function setUserPermission($permission) 
  {                  
    $user = new User();
    
  	if($user->isValid() )
    {
  		// reset permissions
  		$user->setPermission(ROLE_DOCTOR, false);
  		$user->setPermission(ROLE_PATIENT, false);
  		$user->setPermission(ROLE_ADMIN, false);
  		
      switch($permission) 
      {
      		case ADMIN: $this->setUserProperty(ROLE_ADMIN, true);
          case DOCTOR: $this->setUserProperty(ROLE_DOCTOR, true);
      		case PATIENT: $this->setUserProperty(ROLE_PATIENT, true);
          break;
  		} 
  	}
  }
  
  //===================================== Page =====================================
  
  function loadModule($module_array) {  
    // we're still on the page, let's build the content
    foreach($module_array as $module)
    {
      switch($module)
      {
        case MODULE_PAGE_COMMON: 
          require_once 'PageContent.php';
          $this->pageContent = new PageContent();
      }
    }  
  }
  
  function display() {    
    $this->pageContent->displayHtmlHeader($this->htmlTitle, $this->htmlHead);  
    $this->pageContent->displayHtmlBody($this->htmlContent, $this->baseUrl, $this->navPath);           
    $this->pageContent->displayHtmlFooter();   
  }
  
  //===================================== Request =====================================
  
  function getGet($param) {
    return mysql_real_escape_string(trim($_GET[$param]) ); 
  }
  
  function getPost($param) {
    return mysql_real_escape_string(trim($_POST[$param]) ); 
  }
}
?>
