<?php

namespace error\views;
use EHCS\View;
use EHCS\Config;

class ErrorView extends View
{
    function display($message = 'error')
    {
        $this->setHtmlContent($message);
        parent::display();
    }
}