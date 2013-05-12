<?php

namespace user\views;
use EHCS\View;
use EHCS\Config;
use EHCS\Form;

class UserView extends View
{
    function display($users)
    {
        $html = '<h3><a class="btn btn-mini" href="' . BASE_URL . 'user/user/add/' . '" title="Add"><i class="icon-plus-sign"></i></a> Users</h3>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Is Active</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach($users as $user)
        {
            $html .= '<tr>';
            $html .= '<td>' . $user['Email'] . '</td>';
            $html .= '<td>' . $user['Role'] . '</td>';
            $html .= '<td>' . $user['IsActive'] . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        $this->setHtmlContent($html);
        parent::display();
    }

    function displayAdd(Form $form)
    {
        $this->setHtmlContent($form->getHtml());
        $this->setHtmlFooter('');
        parent::display();
    }

    function displayReset(Form $form)
    {
        $this->setHtmlContent($form->getHtml());
        $this->setHtmlFooter('');
        parent::display();
    }
}