<?php

namespace EHCS;

class Request
{                          
  public static function getInstance() 
  {
    if(!self::$instance) 
    { 
      self::$instance = new self(); 
    } 

    return self::$instance;
  }
  
  function getGet($param) 
  {
    $value = NULL;
    if(isset($_GET[$param]))
    {
      $value = $this->sanitize($_GET[$param]);
    }
    
    return $value;   
  }
  
  function getPost($param) 
  {         
    $value = NULL;
    if(isset($_POST[$param]))
    {
      $value = $this->sanitize($_POST[$param]);
    }
    
    return $value;  
  }
  
  function sanitize($value)
  {
    return mysql_real_escape_string(trim($value));                       
  } 
  
  //===================================== private =====================================
  
  private static $instance; 
  private function __construct() {}
}