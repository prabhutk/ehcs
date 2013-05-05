<?php

namespace user\views;
use EHCS\View;
use EHCS\Config;

class ResetView extends View
{  
  function display($form)
  {         
    $this->setHtmlContent($form->getHtml());
    parent::display();
  }
}