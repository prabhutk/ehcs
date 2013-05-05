<?php

namespace appointment\views;
use EHCS\View;
use EHCS\Config;

class HomeView extends View
{  
  function display()
  {        
    $this->setHtmlContent('appointment');                  
    $this->setHtmlFooter(''); 
    parent::display();
  }
}