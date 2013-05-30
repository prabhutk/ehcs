<?php

namespace error\controllers;
use EHCS\Controller;
use EHCS\Request;
use error\views\HomeView as HomeView;

class PageController extends Controller
{
    function notfoundAction()
    {
        $message = 'If you typed the url in a browser, make sure you have spelled it correctly. You can visit the home page by clicking <a href="' . BASE_URL . '">here</a>.';
        $this->getView($this->getModule(), $this->getModule())->display($message);
    }
}