<?php

namespace user\forms;
use EHCS\Form;
use EHCS\Config;
use EHCS\Validator;
use EHCS\Request;

class LoginForm extends Form
{
    public function getHtml()
    {
        return '<form class="form-signin" action="' . BASE_URL . $this->getAction() . '" method="' . $this->getMethod() . '">
              <h2 class="form-signin-heading">Please sign in</h2>
              <input type="text" class="input-block-level" name="email" placeholder="Email address">
              <input type="password" class="input-block-level" name="login" placeholder="Password">
              <button class="btn btn-large btn-primary" type="submit">Sign in</button>
            </form>';
    }

    public function validate()
    {
        return Validator::getInstance()->validateEmail(Request::getInstance()->getPost('email'));
    }
}