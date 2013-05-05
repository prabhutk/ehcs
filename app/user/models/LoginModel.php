<?php                      

namespace user\models;
use EHCS\Model;
use EHCS\Request;
use EHCS\Config;
use EHCS\User;

class LoginModel extends Model
{                
  function init()
  {
    parent::init();
  }        
  
  public function authenticate()
  {
    $email = Request::getInstance()->getPost('email');
    $login = Request::getInstance()->getPost('login');
    
    $config = Config::getInstance();
    $login = $this->createHash($login, $config['db']['salt']);
    
    $sql = "SELECT `UserId`, `Role` 
            FROM `" . $config['db']['name'] . "`.`user_login`
            WHERE `Email` = '$email'
            AND `Login` = '$login'
            AND `IsActive` = 'Y'";
            
    return $this->runSql($sql);
  }
  
  public function verifyActivateLink()
  {
    $email = Request::getInstance()->getGet('email');
    $key = Request::getInstance()->getGet('key');
                                              
    $config = Config::getInstance();
    $sql = "SELECT `UserId`, `Role` 
            FROM `" . $config['db']['name'] . "`.`user_login`
            WHERE `Email` = '$email'
            AND `Login` = '$key'
            AND `IsActive` = 'N'";
            
    return $this->runSql($sql);
  }
  
  public function saveReset()
  {
    $login = Request::getInstance()->getPost('login');     
    $userId = User::getInstance()->getAttribute(ATTR_USER_ID); 
                   
    $config = Config::getInstance();
    $login = $this->createHash($login, $config['db']['salt']); 
    
    $sql = "UPDATE `" . $config['db']['name'] . "`.`user_login` 
            SET `Login` = '$login',
            `IsActive` = 'Y'
            WHERE `UserId` = '$userId'";  
            
    return $this->runSql($sql);
  }
}     
                  