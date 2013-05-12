<?php

namespace clinic\controllers;
use EHCS\Controller;
use EHCS\Config;
use EHCS\Request;
use EHCS\Redirector;

class ClinicController extends Controller
{
    function viewAction()
    {
        $model = $this->getModel($this->getModule(), $this->getController());
        $result = $model->fetchAll();

        $clinics = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $clinics[] = array(
                    'ClinicId' => $row->ClinicId,
                    'Code' => $row->Code,
                    'Name' => $row->Name,
                    'IsOpen' => $row->IsOpen
                );
            }
        }
        $this->getView($this->getModule(), $this->getController())->display($clinics);
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
            $model->save();

            $success = $config['success'][$this->getModule()]['add'];
            Redirector::getInstance()->redirect($form->getPassPage(), array('success' => $success));
        } else {
            $error = $config['error'][$this->getModule()]['email'];
            Redirector::getInstance()->redirect($form->getFailPage(), array('error' => $error));
        }
    }
}