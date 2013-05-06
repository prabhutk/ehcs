<?php

namespace appointment\controllers;
use EHCS\Controller;
use appointment\views\HomeView as HomeView;

class HomeController extends Controller
{
    function monthAction()
    {
        $this->getView($this->getModule(), 'home')->display();
    }
}