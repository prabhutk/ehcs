<?php

namespace user\views;
use EHCS\View;
use EHCS\Config;
use EHCS\Form;

class HomeView extends View
{
    function display(Form $form)
    {
        $this->setHtmlContent($form->getHtml());
        $this->setHtmlFooter('');
        parent::display();
    }
}