<?php

namespace appointment\controllers;
use EHCS\Controller;
use appointment\views\HomeView as HomeView;

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