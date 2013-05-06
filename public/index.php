<?php

session_start();
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../app'));
define('BASE_URL', 'http://localhost/petprojects/ehcs/public/');
define('CONFIG_PATH', '../config/ehcs.ini');

set_include_path(implode(';', array(
    realpath(APPLICATION_PATH . '/../lib'),
    realpath(APPLICATION_PATH),
    get_include_path(),
)));

spl_autoload_register(function ($className) {
    require_once $className . '.php';
});

use EHCS\Router;

require_once 'constants.php';
Router::getInstance()->route();