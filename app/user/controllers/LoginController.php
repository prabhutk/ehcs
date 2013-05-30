<?php

namespace user\controllers;
use EHCS\Controller;
use EHCS\User;
use EHCS\Config;
use EHCS\Redirector;
use EHCS\Request;
use EHCS\EmailSender;
use user\views\LoginView;
use user\forms\LoginForm;
use user\forms\ActivateForm;
use user\forms\ResetForm;
use user\models\LoginModel;

class LoginController extends Controller
{
    function indexAction()
    {
        if(Request::getInstance()->getGet('success')) {
            $this->getView($this->getModule(), $this->getController())->display($this->getForm($this->getModule(), $this->getController()));
        } else {
            $this->getView($this->getModule(), $this->getController())->display($this->getForm($this->getModule(), $this->getController()), $this->getForm($this->getModule(), 'signup'));
        }
    }

    function verifyAction()
    {
        $form = $this->getForm($this->getModule(), $this->getController());
        $config = Config::getInstance();

        if ($form->validate()) {
            $model =  $this->getModel($this->getModule(), $this->getController());
            $result = $model->authenticate();

            if ($result->num_rows === 1) {
                $row = $result->fetch_object();
                $success = $config['success'][$this->getModule()][$this->getController()];

                User::getInstance()->login();
                User::getInstance()->setPermission($row->Role);
                User::getInstance()->setAttribute(ATTR_USER_ID, $row->UserId);
                Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
            } else {

                $error = $config['error'][$this->getModule()][$this->getController()];
                Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
            }
        } else {
            $error = $config['error'][$this->getModule()]['email'];
            Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
        }
    }

    function activateAction()
    {
        $form = $this->getForm($this->getModule(), $this->getController());
        $config = Config::getInstance();

        if ($form->validate()) {
            $model =  $this->getModel($this->getModule(), $this->getController());
            $result = $model->verifyActivateLink();

            if ($result->num_rows === 1) {
                $row = $result->fetch_object();

                User::getInstance()->login();
                User::getInstance()->setPermission($row->Role);
                User::getInstance()->setAttribute(ATTR_USER_ID, $row->UserId);

                // take to change-password page
                $success = $config['success'][$this->getModule()][$this->getAction()];
                Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
            } else {
                // take to report-problem page
                $error = $config['error'][$this->getModule()][$this->getAction()];
                Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
            }
        } else {
            $error = $config['error'][$this->getModule()][$this->getAction()];
            Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
        }
    }

    function resetAction()
    {
        $this->getView($this->getModule(), $this->getController())->display($this->getForm($this->getModule(), $this->getAction()));
    }

    function logoutAction()
    {
        User::getInstance()->logout();
        $config = Config::getInstance();
        $success = $config['success'][$this->getModule()][$this->getAction()];
        Redirector::getInstance()->redirect($this->getForm($this->getModule(), $this->getAction())->getFailPage(), array('success' => $success));
    }

    function dosignupAction()
    {
        $form = $this->getForm($this->getModule(), 'signup');
        $config = Config::getInstance();

        if ($form->validate()) {
            $model = $this->getModel($this->getModule(), $this->getModule());

            $key = $model->save(ROLE_PATIENT);

            $patientId = $model->getLastInsertId();
            $model = $this->getModel('appointment', 'appointment');
            $model->signup($patientId);

            $email = Request::getInstance()->getPost('email');
            $html = '<div>Click <a href="' . BASE_URL . 'user/login/activate/?email=' . $email . '&key=' . $key . '">here</a> to activate your account</div>';
            EmailSender::getInstance()->send($email, '', $html);

            $success = $config['success'][$this->getModule()]['signup'];
            Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
        } else {
            $error = $config['error'][$this->getModule()]['email'];
            Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
        }
    }
}