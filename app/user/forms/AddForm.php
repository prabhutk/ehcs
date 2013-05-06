<?php

namespace user\forms;
use EHCS\Form;
use EHCS\Config;
use EHCS\Validator;
use EHCS\Request;

class AddForm extends Form
{
    public function getHtml()
    {
        $form = '<form class="form-user-add" action="' . BASE_URL . $this->getAction() . '" method="POST">
              <h2 class="form-user-heading">Add user</h2>
              <input type="text" class="input-block-level" name="email" placeholder="Email address">
              <div>
                <select name="role">';

        $config = Config::getInstance();
        foreach ($config['role'] as $key => $value) {
            $form .= '<option value="' . $value . '">' . ucfirst($key) . '</option>';
        }

        $form .= '</select>
              </div>
              <button class="btn btn-large btn-primary" type="submit">Add</button>
            </form>';

        return $form;
    }

    public function validate()
    {
        return Validator::getInstance()->validateEmail(Request::getInstance()->getPost('email'));
    }
}