<?php

namespace user\controllers;
use EHCS\Controller;
use EHCS\User;
use EHCS\Config;
use EHCS\Redirector;
use user\views\LoginView;
use user\views\ResetView;
use user\forms\LoginForm;
use user\forms\ActivateForm;
use user\forms\ResetForm;
use user\models\LoginModel;

class LoginController extends Controller
{
    function indexAction()
    {
        $this->getView($this->getModule(), 'login')->display($this->getForm($this->getModule(), 'login'));
    }

    function verifyAction()
    {
        $form = $this->getForm($this->getModule(), 'login');
        $config = Config::getInstance();

        if ($form->validate()) {
            $model =  $this->getModel($this->getModule(), 'login');
            $result = $model->authenticate();

            if ($result->num_rows === 1) {
                $row = $result->fetch_object();
                $success = $config['success']['user']['login'];

                User::getInstance()->login();
                User::getInstance()->setPermission($row->Role);
                User::getInstance()->setAttribute(ATTR_USER_ID, $row->UserId);
                Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
            } else {

                $error = $config['error']['user']['login'];
                Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
            }
        } else {
            $error = $config['error']['user']['email'];
            Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
        }
    }

    function activateAction()
    {
        $form = $this->getForm($this->getModule(), 'activate');
        $config = Config::getInstance();

        if ($form->validate()) {
            $model =  $this->getModel($this->getModule(), 'login');
            $result = $model->verifyActivateLink();

            if ($result->num_rows === 1) {
                $row = $result->fetch_object();

                User::getInstance()->login();
                User::getInstance()->setPermission($row->Role);
                User::getInstance()->setAttribute(ATTR_USER_ID, $row->UserId);

                // take to change-password page
                $success = $config['success']['user']['activate'];
                Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
            } else {
                // take to report-problem page
                $error = $config['error']['user']['activate'];
                Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
            }
        } else {
            $error = $config['error']['user']['activate'];
            Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
        }
    }

    function resetAction()
    {
        $this->getView($this->getModule(), 'reset')->display($this->getForm($this->getModule(), 'reset'));
    }

    function logoutAction()
    {
        User::getInstance()->logout();
        $config = Config::getInstance();
        $success = $config['success']['user']['logout'];
        Redirector::getInstance()->redirect($this->getForm($this->getModule(), 'login')->getFailPage(), array('success' => $success));
    }
}