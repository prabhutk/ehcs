<?php

class User
{                                        
  private static $instance;   
  
  private $permissions = array(ROLE_OPERATOR, ROLE_PATIENT, ROLE_DOCTOR, ROLE_ADMIN);
  private $permissionLabels = array('Operator', 'Patient', 'Doctor', 'Admin');

  public static function getInstance() 
  {
    if(!self::$instance) 
    { 
      self::$instance = new self(); 
    } 

    return self::$instance;
  }
  
  private function __construct() 
  {
  }
  
  public function init()
  {
  	$_SESSION['user'] = array();
  }
  
  public function destroy()
  {
  	unset($_SESSION['user']);
  }
  
  public function isValid() 
  {
  	if(isset($_SESSION['user']) ) 
    {
      return true;
    }
  	else 
    {
      return false;
    }
  }
  
  private function givePermission($permission, $value) 
  {
    $_SESSION['user']['permission'][$permission] = $value;
  }
  
  public function getPermission($permission) 
  {
    return($_SESSION['user']['permission'][$permission]);
  }
  
  public function setPermission($newPermission) 
  {                 
  	if($newPermission === ROLE_ADMIN)
  	{                        
      foreach($this->permissions as $permission)
      {            
        $this->givePermission($permission, true);
      } 
    }
    else                           
  	{  
      foreach($this->permissions as $permission)
      {
        $this->givePermission($permission, false);
      }
      $this->givePermission($newPermission, true);
    }
  }
  
  public function setProperty($property, $value) 
  {
    $_SESSION['user']['property'][$property] = $value;
  }
  
  public function getProperty($property) 
  {
    return($_SESSION['user']['property'][$property]);
  }
  
  public function getLoginForm()
  {
    return '<form class="form-signin" action="' . BASE_URL . Redirector::getInstance()->getPagePath(ACTION_USER_LOGIN) . '.php" method="POST">
              <h2 class="form-signin-heading">Please sign in</h2>
              <input type="text" class="input-block-level" name="email" placeholder="Email address">
              <input type="password" class="input-block-level" name="login" placeholder="Password">
              <button class="btn btn-large btn-primary" type="submit">Sign in</button>
            </form>';
  }
  
  public function validateLoginForm()
  {
    return Validator::getInstance()->validateEmail(Request::getInstance()->getPost('email'));
  }
  
  public function getAddForm()
  {
    $form = '<form class="form-user-add" action="' . BASE_URL . Redirector::getInstance()->getPagePath(ACTION_USER_ADD) . '.php" method="POST">
              <h2 class="form-user-heading">Add user</h2>
              <input type="text" class="input-block-level" name="email" placeholder="Email address">
              <div>
                <select name="role">';
              
    for($i = 1, $size = count($this->permissions); $i < $size; $i++)
    {
      $form .= '<option value="' . $this->permissions[$i] . '">' . $this->permissionLabels[$i] . '</option>';
    }
    
    $form .=    '</select>
              </div>
              <button class="btn btn-large btn-primary" type="submit">Create</button>
            </form>';
            
    return $form;
  } 
  
  public function authenticate()
  {
    $email = Request::getInstance()->getPost('email');
    $login = Request::getInstance()->getPost('login');
    $login = Persistence::getInstance()->createHash($login, DB_SALT);
    
    $sql = "SELECT `UserId`, `Role` 
            FROM `" . DB_NAME . "`.`user_login`
            WHERE `Email` = '$email'
            AND `Login` = '$login'
            AND `IsActive` = 'Y'";
            
    return Persistence::getInstance()->runSql($sql);
  }
  
  public function validateAddForm()
  {
    return Validator::getInstance()->validateEmail(Request::getInstance()->getPost('email'));
  }
  
  public function save()
  {
    $email = Request::getInstance()->getPost('email');
    $role = Request::getInstance()->getPost('role');
    $login = Persistence::getInstance()->createHash($email, DB_SALT);
    
    $sql = "INSERT INTO `" . DB_NAME . "`.`user_login`
            (`UserId`, `Email`, `Login`, `Role`, `IsActive`)
            VALUES
            ('', '$email', '$login', '$role', 'N')";
    
    Persistence::getInstance()->runSql($sql);
    if(Persistence::getInstance()->getAffectedRows !== 1)
    {
      Redirector::getInstance()->error(ERROR_DB_SQL);
    }
    else
    {
      return $login;
    }
  }
  
  public function validateActivateForm()
  {                                                                                     
    return Validator::getInstance()->validateEmail(Request::getInstance()->getGet('email'));
  }
  
  public function verifyActivateLink()
  {
    $email = Request::getInstance()->getGet('email');
    $key = Request::getInstance()->getGet('key');
    
    $sql = "SELECT `UserId`, `Role` 
            FROM `" . DB_NAME . "`.`user_login`
            WHERE `Email` = '$email'
            AND `Login` = '$key'
            AND `IsActive` = 'N'";
            
    return Persistence::getInstance()->runSql($sql);
  }
  
  public function getResetForm()
  {
    return '<form class="form-signin" action="' . BASE_URL . Redirector::getInstance()->getPagePath(ACTION_USER_RESET) . '.php" method="POST">
              <h2 class="form-signin-heading">Enter password</h2>
              <input type="password" class="input-block-level" name="login" placeholder="Password">
              <input type="password" class="input-block-level" name="login2" placeholder="Repeat Password">
              <button class="btn btn-large btn-primary" type="submit">Sign in</button>
            </form>';
  }
  
  public function validateResetForm()
  {
      return Request::getInstance()->getPost('login') === Request::getInstance()->getPost('login2');
  }   
  
  public function saveReset()
  {
    $login = Request::getInstance()->getPost('login');
    $login = Persistence::getInstance()->createHash($login, DB_SALT);
    $userId = User::getInstance()->getProperty(PROPERTY_USER_ID);
    
    $sql = "UPDATE `" . DB_NAME . "`.`user_login` 
            SET `Login` = '$login',
            `IsActive` = 'Y'
            WHERE `UserId` = '$userId'";
            
    Persistence::getInstance()->runSql($sql);
    if(Persistence::getInstance()->getAffectedRows() !== 1)
    {
      Redirector::getInstance()->error(ERROR_DB_SQL);
    }
  }
}

?>
