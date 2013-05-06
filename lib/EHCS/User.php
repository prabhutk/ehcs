<?php

namespace EHCS;

class User
{
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function login()
    {
        $_SESSION['user'] = array();
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getPermission($permission)
    {
        return ($_SESSION['user']['permission'][$permission]);
    }

    public function setPermission($newPermission)
    {
        $config = Config::getInstance();
        if ($newPermission === ROLE_ADMIN) {
            foreach ($config['role'] as $permission) {
                $this->givePermission($permission, true);
            }
        } else {
            foreach ($config['role'] as $permission) {
                $this->givePermission($permission, false);
            }
            $this->givePermission($newPermission, true);
        }
    }

    public function setAttribute($attribute, $value)
    {
        $_SESSION['user']['attribute'][$attribute] = $value;
    }

    public function getAttribute($attribute)
    {
        return ($_SESSION['user']['attribute'][$attribute]);
    }

    //===================================== private =====================================

    private static $instance;

    private function __construct()
    {
    }

    private function givePermission($permission, $value)
    {
        $_SESSION['user']['permission'][$permission] = $value;
    }
}