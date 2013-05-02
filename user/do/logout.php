<?php

require_once '../../util/EHCS.php';  
$EHCS = EHCS::getInstance();                    
User::getInstance()->destroy();                        
Redirector::getInstance()->success(SUCCESS_LOGOUT); 

?>
