<?php

class Request
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
  
  function getGet($param) 
  {
    $value = NULL;
    if(isset($_GET[$param]))
    {
      $value = mysql_real_escape_string(trim($_GET[$param]) );
    }
    
    return $value;   
  }
  
  function getPost($param) 
  {         
    $value = NULL;
    if(isset($_POST[$param]))
    {
      $value = mysql_real_escape_string(trim($_POST[$param]) );
    }
    
    return $value;  
  }   
}

?>
