<?php

namespace error\controllers;
use EHCS\Controller;
use error\views\HomeView as HomeView;

class PageController extends Controller
{
    function monthAction()
    {
        $this->getView($this->getModule(), 'home')->display($this->getForm($this->getModule(), 'add'));
    }
}