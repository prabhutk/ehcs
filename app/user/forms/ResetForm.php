<?php

namespace user\forms;
use EHCS\Form;
use EHCS\Config;
use EHCS\Validator;
use EHCS\Request;

class ResetForm extends Form
{
    public function getHtml()
    {
        $config = Config::getInstance();
        return '<form class="form-signin" action="' . BASE_URL . $this->getAction() . '" method="' . $this->getMethod() . '">
              <h2 class="form-signin-heading">Enter password</h2>
              <input type="password" class="input-block-level" name="login" placeholder="Password">
              <input type="password" class="input-block-level" name="login2" placeholder="Repeat Password">
              <button class="btn btn-large btn-primary" type="submit">Submit</button>
            </form>';
    }

    public function validate()
    {
        return Request::getInstance()->getPost('login') === Request::getInstance()->getPost('login2');
    }
}