<?php

define('BASE_URL', 'http://localhost/petprojects/ehcs');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_LOGIN', 'mysqlrt');
define('DB_NAME', 'ehcs');
define('DB_SALT', 'qwertyuioplkjhgfdsazxcvbnm');

define('ERROR_CONNECTION', 0);
define('ERROR_DB', 1);         
define('ERROR_LOGIN', 2); 
define('FAILED_LOGIN', 3);  
define('ERROR_PERMISSION', 4);  
define('ERROR_USER_ADD', 5);  
define('ERROR_DB_SQL', 6);
define('FAILED_USER_ACTIVATE', 7);
define('FAILED_USER_RESET', 8);  

define('SUCCESS_LOGIN', 0); 
define('SUCCESS_LOGOUT', 1); 
define('SUCCESS_USER_ADD', 2);  
define('SUCCESS_USER_ACTIVATE', 3);  
define('SUCCESS_USER_RESET', 4);  

define('ROLE_OPERATOR', 'O');
define('ROLE_PATIENT', 'P'); 
define('ROLE_DOCTOR', 'D');
define('ROLE_ADMIN', 'A');

define('NAV_HOME', 0);
define('NAV_HOSPITAL', 1);
define('NAV_USER', 2);
define('NAV_ACCOUNT', 3);  
define('NAV_HOSPITAL', 4);        

define('MSG_ERROR', 0);
define('MSG_WARNING', 1);
define('MSG_INFO', 2);
define('MSG_SUCCESS', 3);
                        
define('MODULE_PAGE_CONTENT', 0);
define('MODULE_CONSTANTS', 1);
define('MODULE_USER', 2);
define('MODULE_REQUEST', 3);
define('MODULE_REDIRECTOR', 4);
define('MODULE_VALIDATOR', 5);

define('PAGE_ERROR', 0);
define('PAGE_INDEX', 1);
define('PAGE_HOME', 2);
define('PAGE_HOSPITAL', 3);
define('PAGE_USER', 4);
define('ACTION_USER_LOGIN', 5);
define('ACTION_USER_LOGOUT', 6);
define('ACTION_USER_ADD', 7);
define('ACTION_USER_ACTIVATE', 8);
define('PAGE_USER_RESET', 9);
define('ACTION_USER_RESET', 10);
define('PAGE_ACCOUNT', 11);



?>
