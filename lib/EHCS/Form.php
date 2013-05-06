<?php

namespace EHCS;

abstract class Form
{
    public abstract function getHtml();
    public abstract function validate();

    public function init($module, $form)
    {
        $config = Config::getInstance();
        if (isset($config['form']['action'][$module][$form])) {
            $this->action = $config['form']['action'][$module][$form];
        } else {
            $this->action = '';
        }
        if (isset($config['form']['method'][$module][$form])) {
            $this->method = $config['form']['method'][$module][$form];
        } else {
            $this->method = 'GET';
        }
        if (isset($config['form']['pass'][$module][$form])) {
            $this->pass = $config['form']['pass'][$module][$form];
        } else {
            $this->pass = '';
        }
        if (isset($config['form']['fail'][$module][$form])) {
            $this->fail = $config['form']['fail'][$module][$form];
        } else {
            $this->fail = '';
        }
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getPassPage()
    {
        return $this->pass;
    }

    public function getFailPage()
    {
        return $this->fail;
    }

    //===================================== private =====================================

    private $action;
    private $method;
    private $pass;
    private $fail;
}     
                  