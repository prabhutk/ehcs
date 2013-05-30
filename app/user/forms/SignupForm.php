<?php

namespace user\forms;
use EHCS\Form;
use EHCS\Config;
use EHCS\Validator;
use EHCS\Request;

class SignupForm extends Form
{
    public function getHtml()
    {
        $form = '<form class="form-user-signup" action="' . BASE_URL . $this->getAction() . '" method="POST">
              <h2 class="form-user-heading">New patients</h2>
              <input type="text" maxlength="128" class="input-block-level" name="email" placeholder="Email">
              <input type="text" class="input-block-level" name="appt_date" id="appt_date" placeholder="Date">
              <select class="input-block-level" name="appt_time" id="appt_time">
                <option value="09:00:00">9:00 AM</option>
                <option value="09:30:00">9:30 AM</option>
                <option value="10:00:00">10:00 AM</option>
                <option value="10:30:00">10:30 AM</option>
              </select>
              <button class="btn btn-large btn-primary" type="submit">Sign up</button>
            </form>';

        return $form;
    }

    public function validate()
    {
        return Validator::getInstance()->validateEmail(Request::getInstance()->getPost('email'));
    }
}