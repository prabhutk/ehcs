<?php

namespace hospital\controllers;
use EHCS\Controller;
use hospital\views\HomeView as HomeView;

class HomeController extends Controller
{
    function monthAction()
    {
        $this->getView($this->getModule(), 'home')->display();
    }
}