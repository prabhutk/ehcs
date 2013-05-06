<?php

namespace user\controllers;
use EHCS\Controller;
use user\views\HomeView;
use user\forms\AddForm;

class HomeController extends Controller
{
    function monthAction()
    {
        $this->getView($this->getModule(), 'home')->display($this->getForm($this->getModule(), 'add'));
    }
}