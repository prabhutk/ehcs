<?php

namespace EHCS;

class Redirector
{
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function redirect($url, $request = array())
    {
        $glue = '?';
        $location = 'location:' . BASE_URL . $url;

        foreach ($request as $key => $value) {
            $location .= $glue . $key . '=' . $value;
            $glue = '&';
        }

        header($location);
        exit;
    }

    //===================================== private =====================================

    private static $instance;

    private function __construct()
    {
    }
}