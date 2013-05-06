<?php

namespace user\controllers;
use EHCS\Controller;       
use EHCS\Config;        
use EHCS\Request;        
use user\forms\AddForm;   
use user\forms\ResetForm;   
use user\views\LoginView; 
use user\models\UserModel;
use user\models\LoginModel;
use EHCS\EmailSender;  
use EHCS\Redirector;

class AdminController extends Controller
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
  
  function getForm()
  {
    if($this->form === NULL)
    {
      $this->form = new AddForm(); 
      $this->form->init($this->getModule(), 'add');
    }
    return $this->form;
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
   
  function addAction()
  {                       
    $form = $this->getForm();
    $config = Config::getInstance();
                                 
    if($form->validate())
    {
      $model = new UserModel();
      $model->init();
      
      $email = Request::getInstance()->getPost('email');
      $html = '<div>Click <a href="' . BASE_URL . 'user/login/activate/?email=' . $email . '&key=' . $model->save() . '">here</a> to activate your account</div>';                     
      EmailSender::getInstance()->send($email, '', $html);         
      
      $success = $config['success']['user']['add'];
      Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
    }
    else
    {                                        
      $error = $config['error']['user']['email'];
      Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
    } 
  }
  
  function resetAction()
  {                                      
    $form = $this->getResetForm();
    $config = Config::getInstance();
                                 
    if($form->validate())
    {
      $model = new LoginModel();
      $model->init();   
      $model->saveReset();  
      
      if($model->getAffectedRows() === 1)
      {
        $success = $config['success']['user']['reset'];
        Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
      }  
      else
      {                                        
        $error = $config['error']['db']['sql'];
        Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
      } 
    }
    else
    {                                        
      $error = $config['error']['user']['reset'];
      Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
    } 
  }

    private $form;
    private $resetForm;
}