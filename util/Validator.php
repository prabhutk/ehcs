<?php

Class Validator
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
  
  public function validateEmail($email)
  {
     $isValid = true;
     $atIndex = strrpos($email, "@");
     
     if (is_bool($atIndex) && !$atIndex)
     {
        $isValid = false;
     }
     else
     {
        $domain = substr($email, $atIndex+1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);
        
        if ($localLen < 1 || $localLen > 64)
        {
           // local part length exceeded
           $isValid = false;
        }
        elseif ($domainLen < 1 || $domainLen > 255)
        {
           // domain part length exceeded
           $isValid = false;
        }
        elseif ($local[0] == '.' || $local[$localLen-1] == '.')
        {
           // local part starts or ends with '.'
           $isValid = false;
        }
        elseif (preg_match('/\\.\\./', $local) )
        {
           // local part has two consecutive dots
           $isValid = false;
        }
        elseif (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain) )
        {
           // character not valid in domain part
           $isValid = false;
        }
        elseif (preg_match('/\\.\\./', $domain) )
        {
           // domain part has two consecutive dots
           $isValid = false;
        }
        elseif(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local) ) )
        {
           // character not valid in local part unless 
           // local part is quoted
           if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local) ) )
           {
              $isValid = false;
           }
        }      
     }
     
     return $isValid;
  }
}

?>