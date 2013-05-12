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

class UserController extends Controller
{
    function viewAction()
    {
        $model = $this->getModel($this->getModule(), $this->getController());
        $result = $model->fetchAll();

        $users = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $users[] = array(
                    'UserId' => $row->UserId,
                    'Email' => $row->Email,
                    'Role' => $row->Role,
                    'IsActive' => $row->IsActive
                );
            }
        }
        $this->getView($this->getModule(), $this->getController())->display($users);
    }

    function addAction()
    {
        $this->getView($this->getModule(), $this->getController())->displayAdd($this->getForm($this->getModule(), $this->getAction()));
    }

    function doaddAction()
    {
        $form = $this->getForm($this->getModule(), 'add');
        $config = Config::getInstance();

        if ($form->validate()) {
            $model = $this->getModel($this->getModule(), $this->getController());
            $key = $model->save();

            $email = Request::getInstance()->getPost('email');
            $html = '<div>Click <a href="' . BASE_URL . 'user/login/activate/?email=' . $email . '&key=' . $key . '">here</a> to activate your account</div>';
            EmailSender::getInstance()->send($email, '', $html);

            $success = $config['success'][$this->getModule()]['add'];
            Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
        } else {
            $error = $config['error'][$this->getModule()]['email'];
            Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
        }
    }

    function editAction()
    {
        $form = $this->getForm($this->getModule(), $this->getAction());
        $config = Config::getInstance();

        if ($form->validate()) {
            $model = $this->getModel($this->getModule(), 'login');
            $model->saveReset();

            if ($model->getAffectedRows() === 1) {
                $success = $config['success']['user']['reset'];
                Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
            } else {
                $error = $config['error']['db']['sql'];
                Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
            }
        } else {
            $error = $config['error']['user']['reset'];
            Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
        }
    }

    function deleteAction()
    {
        $form = $this->getForm($this->getModule(), $this->getAction());
        $config = Config::getInstance();

        if ($form->validate()) {
            $model = $this->getModel($this->getModule(), 'login');
            $model->saveReset();

            if ($model->getAffectedRows() === 1) {
                $success = $config['success']['user']['reset'];
                Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
            } else {
                $error = $config['error']['db']['sql'];
                Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
            }
        } else {
            $error = $config['error']['user']['reset'];
            Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
        }
    }
}