<?php

namespace user\views;
use EHCS\View;
use EHCS\Config;
use EHCS\Form;

class AccountView extends View
{
    function displayReset(Form $form)
    {
        $this->setHtmlContent($form->getHtml());
        $this->setHtmlFooter('');
        parent::display();
    }
}