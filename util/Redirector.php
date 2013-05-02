<?php

class Redirector
{                                                        
  private static $instance;

  public static function getInstance() 
  {
    if(!self::$instance) 
    { 
      self::$instance = new self(); 
    } 

    return self::$instance;
  }
  
  private function __construct() 
  {
  }
  
  public function error($errorCode, $pagePath = '') 
  {      
    switch($errorCode) 
    {                              
    		case ERROR_LOGIN:   
    		case FAILED_LOGIN: 
          $path = 'index';
    		  break;
    		case ERROR_USER_ADD: 
          $path = 'user';
    		  break;        
    		case FAILED_USER_ACTIVATE:  
          $path = 'user/reset';
    		  break;        
    		case ERROR_CONNECTION: 
        case ERROR_DB: 
        case ERROR_DB_SQL: 
    		case ERROR_PERMISSION: 
    		case FAILED_USER_ACTIVATE:
        default:
          $path = 'error';
          break;
    } 
    
    $location = 'location:' . BASE_URL . "/$path.php?error=$errorCode";
    
    if($pagePath != '')
    {
      $location .= "&path=$pagePath";
    }
    
    header($location);
    exit;
  }  
  
  public function success($successCode, $pagePath = '') 
  {      
    switch($successCode) 
    {                           
    		case SUCCESS_LOGOUT:     
          $path = 'index';
    		  break;    
    		case SUCCESS_USER_ADD:     
          $path = 'user/index';
    		  break;
    		case SUCCESS_USER_ACTIVATE:     
          $path = 'user/reset';
    		  break;              
    		case SUCCESS_LOGIN:
    		case SUCCESS_USER_RESET:
        default:
          $path = 'home';
          break;
    } 
    
    $location = "Location:" . BASE_URL . "/$path.php?success=$successCode";
    
    if($pagePath != '')
    {
      $location .= "&path=$pagePath";
    }
     
    header($location);
    exit;
  }  
  
  public function getErrorMessage($errorCode)
  {
    switch ($errorCode) 
    {
    		case ERROR_CONNECTION: 
          $message = 'Could not connect to data source';     
          break;
        case ERROR_DB: 
          $message =  'Could not connect to database';   
          break;
        case ERROR_DB_SQL: 
          $message =  'Could not update records';   
          break;
    		case ERROR_LOGIN: 
          $message =  'Please login to continue';    
          break;
    		case ERROR_PERMISSION: 
          $message =  'That is a restricted page';  
    		case FAILED_LOGIN: 
          $message =  'Incorrect credentials';  
          break;  
    		case ERROR_USER_ADD: 
          $message =  'User was not added';  
          break;
        case FAILED_USER_ACTIVATE: 
          $message =  'Passwords have to match';  
          break;
        default:
          $message =  'An unidentified error has occurred';  
          break;
    } 
    
    return $message;
  } 
  
  function getSuccessMessage($successCode)
  {
    switch ($successCode) 
    {
    		case SUCCESS_LOGIN: 
          $message = 'Yay, welcome back!';     
          break;
        case SUCCESS_LOGOUT: 
          $message =  'Ok, bye';   
          break;
        case SUCCESS_USER_ADD: 
          $message =  'You created a user';   
          break;
        case SUCCESS_USER_ACTIVATE: 
          $message =  'You have activated your account';   
          break;        
    		case SUCCESS_USER_RESET:     
          $message =  'Your password has been saved';   
          break;        
        default:
          $message =  'Something good happened';  
          break;
    } 
    
    return $message;
  }
  
  function getPagePath($pathCode)
  {
    switch($pathCode)
    {
      case PAGE_ERROR:
        $path = '/error';
        break;
      case PAGE_INDEX:
        $path = '/index';
        break;
      case PAGE_HOME:
        $path = '/home';
        break;
      case PAGE_HOSPITAL:
        $path = '/hospital/index';
        break;
      case PAGE_USER:
        $path = '/user/index';
        break;
      case PAGE_ACCOUNT:
        $path = '/user/profile';
        break;
      case ACTION_USER_LOGIN:
        $path = '/user/do/login';      
        break;
      case ACTION_USER_LOGOUT:
        $path = '/user/do/logout';     
        break;
      case ACTION_USER_ADD:
        $path = '/user/do/add';   
        break;
      case ACTION_USER_ACTIVATE:
        $path = '/user/do/activate';  
        break;
      case PAGE_USER_RESET:
        $path = '/user/reset';  
        break;
      case ACTION_USER_RESET:
        $path = '/user/do/reset';  
        break;
      default:
        $path = '/index';
        break;
    }
    
    return $path;
  }
}

?>
