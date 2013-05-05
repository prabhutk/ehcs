<?php

namespace hospital\controllers;
use EHCS\Controller;
use hospital\views\HomeView as HomeView;

class HomeController extends Controller
{
  function init($module, $controller, $action)
  {
    parent::init($module, $controller, $action);
    $action .= 'Action';
    $this->$action();
  }
  
  function getView()
  {
    if($this->view === NULL)
    {
      $this->view = new HomeView();
      $this->view->init($this->getModule(), $this->getController(), $this->getAction());
    }
    return $this->view;
  }
   
  function monthAction()
  { 
    $this->getView()->display();
  
  }
}