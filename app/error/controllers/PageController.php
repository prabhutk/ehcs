<?php

namespace error\controllers;
use EHCS\Controller;
use error\views\HomeView as HomeView;

class PageController extends Controller
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
   
  function homeAction()
  { 
    $this->getView()->display();
  
  }
}