<?php

require_once '../../../lib/EHCS.php';  
$EHCS = EHCS::getInstance();                    
User::getInstance()->destroy();                        
Redirector::getInstance()->success(SUCCESS_LOGOUT); 

?>
