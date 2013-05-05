<?php

namespace user\views;
use EHCS\View;
use EHCS\Config;

class HomeView extends View
{  
  function display($form)
  {
    $this->setHtmlContent($form->getHtml());                  
    $this->setHtmlFooter(''); 
    parent::display();
  }
}