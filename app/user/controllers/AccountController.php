<?php

namespace user\controllers;
use EHCS\Controller;
use EHCS\Config;
use EHCS\Request;
use user\forms\AddForm;
use user\forms\ResetForm;
use user\views\LoginView;
use user\models\UserModel;
use user\models\LoginModel;
use EHCS\EmailSender;
use EHCS\Redirector;

class AccountController extends Controller
{
    function viewAction()
    {
        $this->getView($this->getModule(), $this->getController())->displayReset($this->getForm($this->getModule(), 'reset'));
    }
}