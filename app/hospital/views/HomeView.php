<?php

namespace hospital\views;
use EHCS\View;
use EHCS\Config;

class HomeView extends View
{  
  function display()
  {        
    $this->setHtmlContent('hospital');                  
    $this->setHtmlFooter(''); 
    parent::display();
  }
}