<?php

namespace EHCS;

abstract class Controller
{
    public function init($module, $controller, $action)
    {
        $this->module = $module;
        $this->controller = $controller;
        $this->action = $action;
        $action .= 'Action';
        $this->$action();
    }

    public function getModule()
    {
        return $this->module;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    function getView($module, $viewName)
    {
        $viewName = strtolower($viewName);
        $view = $module . '\\views\\' . ucfirst($viewName) . 'View';
        $view = new $view();
        $view->init($module, $this->getController(), $this->getAction());
        return $view;
    }

    public function getForm($module, $formName)
    {
        $formName = strtolower($formName);
        $form = $module . '\\forms\\' . ucfirst($formName) . 'Form';
        $form = new $form();
        $form->init($module, $formName);
        return $form;
    }

    public function getModel($module, $modelName)
    {
        $modelName = strtolower($modelName);
        $model = $module . '\\models\\' . ucfirst($modelName) . 'Model';
        $model = new $model();
        $model->init();
        return $model;
    }

    //===================================== private =====================================

    private $module;
    private $controller;
    private $action;
}
