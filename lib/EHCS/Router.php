<?php

namespace EHCS;

class Router
{
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function route()
    {
        $params = array_values(array_diff(explode('/', $_SERVER['REQUEST_URI']), explode('/', $_SERVER['SCRIPT_NAME'])));

        $module = $this->sanitize($params[0]);
        $controller = $this->sanitize($params[1]);
        $action = $this->sanitize($params[2]);

        // re-route to home pages
        if ($module === 'index' && $controller === 'index' && $action === 'index') {
            $module = 'appointment';
            $controller = 'month';
            $action = 'view';
        }

        $config = Config::getInstance();

        if (isset($config['page']['permission'][$module][$controller][$action])) {
            $permission = $config['page']['permission'][$module][$controller][$action];

            // page is valid
            if (strlen($permission)) {
                // needs login
                if (!User::getInstance()->isLoggedIn()) {
                    $error = $config['error']['page']['login'];
                    Redirector::getInstance()->redirect('user/login/index/', array('error' => $error));
                } elseif (!User::getInstance()->getPermission($permission)) {
                    $error = $config['error']['page']['restricted'];
                    Redirector::getInstance()->redirect('error/page/restricted/', array('error' => $error));
                }
            }
        } else {
            $error = BASE_URL . $module . '/' . $controller . '/' . $action . ' was not found.';
            Redirector::getInstance()->redirect('error/page/notfound/', array('error' => $error));
        }

        $controllerPath = $module . '\\controllers\\' . ucfirst($controller) . 'Controller';
        $controllerInstance = new $controllerPath();
        $controllerInstance->init($module, $controller, $action);
    }

    //===================================== private =====================================

    private static $instance;

    private function __construct()
    {
    }

    private function sanitize($value)
    {
        if(strchr($value, '?')) {
            $value = substr($value, 0, strpos($value, '?'));
        }
        $value = Request::getInstance()->sanitize($value);
        return strlen($value) === 0 ? 'index' : $value;
    }
}
