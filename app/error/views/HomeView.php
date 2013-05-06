<?php

namespace error\views;
use EHCS\View;
use EHCS\Config;

class HomeView extends View
{
    function display()
    {
        $this->setHtmlContent('error');
        $this->setHtmlFooter('');
        parent::display();
    }
}