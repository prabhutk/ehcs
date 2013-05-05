<?php          

namespace EHCS;

abstract class Controller
{                   
  public abstract function getView();
  
  public function init($module, $controller, $action)
  {                          
    $this->module = $module;
    $this->controller = $controller;
    $this->action = $action;
  }   
  
  public function getModule()
  {
    return $this->module;
  }
  
  public function getController()
  {
    return $this->controller;
  }
  
  public function getAction()
  {
    return $this->action;
  }
  
  //===================================== private =====================================
          
  private $view;
  private $module;
  private $controller;
  private $action;
}
