<?php

namespace clinic\forms;
use EHCS\Form;
use EHCS\Config;
use EHCS\Validator;
use EHCS\Request;

class AddForm extends Form
{
    public function getHtml()
    {
        $form = '<form class="form-user-add" action="' . BASE_URL . $this->getAction() . '" method="POST">
              <h2 class="form-user-heading">Add clinic</h2>
              <input type="text" maxlength="3" class="input-block-level" name="code" placeholder="Code">
              <input type="text" maxlength="128" class="input-block-level" name="name" placeholder="Name">
              <div>
                <select name="isopen">
                    <option value="Y">Open</option>
                    <option value="N">Closed</option>
                </select>
              </div>
              <button class="btn btn-large btn-primary" type="submit">Add</button>
            </form>';

        return $form;
    }

    public function validate()
    {
        return true;
    }
}