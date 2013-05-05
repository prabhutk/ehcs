<?php

namespace user\forms;
use EHCS\Form;
use EHCS\Request;
use EHCS\Validator;

class ActivateForm extends Form
{    
  public function validate()
  {
    return Validator::getInstance()->validateEmail(Request::getInstance()->getGet('email'));
  }    
}