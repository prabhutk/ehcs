<?php

namespace user\controllers;
use EHCS\Controller;
use EHCS\User;        
use EHCS\Config;                
use EHCS\Redirector;
use user\views\LoginView;  
use user\views\ResetView;  
use user\forms\LoginForm;   
use user\forms\ActivateForm; 
use user\forms\ResetForm; 
use user\models\LoginModel;

class LoginController extends Controller
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
      $this->view = new LoginView();
      $this->view->init($this->getModule(), $this->getController(), $this->getAction());
    }
    return $this->view;
  }
  
  function getResetView()
  {
    if($this->resetView === NULL)
    {
      $this->resetView = new ResetView();
      $this->resetView->init($this->getModule(), $this->getController(), $this->getAction());
    }
    return $this->resetView;
  }
  
  function getLoginForm()
  {
    if($this->loginForm === NULL)
    {
      $this->loginForm = new LoginForm(); 
      $this->loginForm->init($this->getModule(), $this->getController());
    }
    return $this->loginForm;
  }
  
  function getResetForm()
  {
    if($this->resetForm === NULL)
    {
      $this->resetForm = new ResetForm(); 
      $this->resetForm->init($this->getModule(), $this->getAction());
    }
    return $this->resetForm;
  }
  
  function getActivateForm()
  {
    if($this->activateForm === NULL)
    {
      $this->activateForm = new ActivateForm(); 
      $this->activateForm->init($this->getModule(), $this->getAction());
    }
    return $this->activateForm;
  }
   
  function indexAction()
  {                           
    $this->getView()->display($this->getLoginForm());
  }
  
  function verifyAction()
  {
    $form = $this->getLoginForm();
    $config = Config::getInstance();
                                 
    if($form->validate())
    {
      $model = new LoginModel();
      $model->init();
      
      $result = $model->authenticate();
                                        
      if($result->num_rows === 1)
      {                                               
        $row = $result->fetch_object();
        $success = $config['success']['user']['login']; 
        
        User::getInstance()->login(); 
        User::getInstance()->setPermission($row->Role); 
        User::getInstance()->setAttribute(ATTR_USER_ID, $row->UserId); 
        Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
      }          
      else
      {                  
                                                               
        $error = $config['error']['user']['login'];
        Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
      }
    }
    else
    {                                        
      $error = $config['error']['user']['email'];
      Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
    } 
  }
  
  function activateAction()
  {                        
    $form = $this->getActivateForm();
    $config = Config::getInstance();
                                 
    if($form->validate())
    {                            
      $model = new LoginModel();
      $model->init();
      
      $result = $model->verifyActivateLink();
  
      if($result->num_rows === 1)
      {                       
        $row = $result->fetch_object();
        
        User::getInstance()->login(); 
        User::getInstance()->setPermission($row->Role); 
        User::getInstance()->setAttribute(ATTR_USER_ID, $row->UserId); 
        
        // take to change-password page
        $success = $config['success']['user']['activate'];
        Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
      }          
      else
      {    
        // take to report-problem page
        $error = $config['error']['user']['activate'];
        Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
      }
    }
    else
    {                                        
      $error = $config['error']['user']['activate'];
      Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
    } 
  } 
   
  function resetAction()
  {                           
    $this->getResetView()->display($this->getResetForm());
  }
  
  function logoutAction()
  {
    User::getInstance()->logout();  
    $config = Config::getInstance(); 
    $success = $config['success']['user']['logout'];
    Redirector::getInstance()->redirect($this->getLoginForm()->getFailPage(), array('success' => $success));
  }
  
  private $loginForm;
  private $activateForm;
  private $resetForm;
  private $resetView;
}