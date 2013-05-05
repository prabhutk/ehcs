<?php

namespace user\controllers;
use EHCS\Controller;          
use user\views\HomeView;        
use user\forms\AddForm;  

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
  
  function getForm()
  {
    if($this->form === NULL)
    {
      $this->form = new AddForm(); 
      $this->form->init($this->getModule(), 'add');
    }
    return $this->form;
  }
   
  function monthAction()
  {                           
    $this->getView()->display($this->getForm());
  }
  
  private $form;
}