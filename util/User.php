<?php

class User
{
  function init()
  {
  	$_SESSION['user'] = array();
  }
  
  function destroy()
  {
  	unset($_SESSION['user']);
  }
  
  function isValid() 
  {
    	if(isset($_SESSION['user']) ) 
      {
          return true;
      }
    	else 
      {
          return false;
      }
  }
  
  function setPermission($Property, $Value) 
  {
    	if(isValid() )	
      {
          $_SESSION['user'][$Property] = $Value;
      }
  }
  
  function hasPermission($Property) 
  {
      return($_SESSION['user'][$Property]);
  }
  
}

?>
