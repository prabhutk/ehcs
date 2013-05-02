<?php

class PageContent
{                                                                
  private static $instance;   

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
  
  public function displayHtmlHeader($htmlTitle, $htmlHead) 
  {
  
?>

<!DOCTYPE html>
<html>
  <head>
    <title>ECSH :: <?php echo $htmlTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo BASE_URL; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel = 'shortcut icon' href = '<?php echo BASE_URL; ?>favicon.ico' />
    <?php echo $htmlHead; ?>
  </head>
  
<?php

  }
  
  public function displayHtmlBody($user, $htmlContent, $navPath, $message, $messageType)
  {
  
?>
  <body> 
<?php    
    if($navPath !== NULL) 
    {
      $this->displayNavigation($user, $navPath);
    } 
    
    if($message !== NULL)
    {
      $this->displayMessage($message, $messageType);
    }
    
    echo '<div class="container">' . $htmlContent; 
  } 
  
  public function displayHtmlFooter($htmlContent) 
  {
  
?>
    
    </div> <!-- /.container -->            
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/js/jquery-1.9.1.min.js"></script> 
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/js/bootstrap.min.js"></script>
  </body>
  <?php echo $htmlContent; ?>
</html>

<?php
         
  }
  
  public function displayNavigation($user, $navPath) 
  {                                
    $navigationPaths = array(NAV_HOME, NAV_HOSPITAL, NAV_USER, NAV_ACCOUNT, NAV_LOGOUT);
    $navigationLabels = array('Home', 'Hospital', 'User', 'Account', 'Logout');
    $func = function($path) {
      return Redirector::getInstance()->getPagePath($path);
    };
    $navigationUrls = array_map($func, array(PAGE_HOME, PAGE_HOSPITAL, PAGE_USER, PAGE_ACCOUNT, ACTION_USER_LOGOUT));
    $navigationPermissions = array(NULL, ROLE_ADMIN, ROLE_ADMIN, NULL, NULL);

?>
  
      <div class="navbar-wrapper">
        <div class="container">
          <div class="navbar">
            <div class="navbar-inner">
              <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </a>
              <a class="brand" href="<?php echo BASE_URL . $navigationUrls[0]; ?>.php">EHCS</a>
              <div class="nav-collapse collapse">
                <ul class="nav">
<?php
    for($i = 0, $size = count($navigationPaths); $i < $size; $i++)
    {
      if(NULL === $navigationPermissions[$i] || User::getInstance()->getPermission($navigationPermissions[$i]))
      { 
        echo '<li';
        if($i == $navPath)
        {
          echo ' class="active"';
        }      
        echo '><a href="' . BASE_URL . $navigationUrls[$i] . '.php">' . $navigationLabels[$i] . '</a></li>';  
      }  
    }

?>              
            
                </ul>
              </div><!--/.nav-collapse -->
            </div><!-- /.navbar-inner -->
          </div><!-- /.navbar -->     
        </div><!-- /.container -->
      </div><!-- /.navbar-wrapper -->
<?php
         
  }
  
  public function displayMessage($message, $messageType)
  { 
    if($message !== NULL)
    {               
      switch($messageType)
      {
        case MSG_ERROR: 
          $cssClass = 'error';
          break;
        case MSG_WARNING: 
          $cssClass = 'warning';
          break;     
        case MSG_INFO: 
          $cssClass = 'info';
          break;     
        case MSG_SUCCESS: 
          $cssClass = 'success';
          break;     
        default: 
          $cssClass = '';
          break;
      }
      
      echo '<div class="container"><table class="table"><tr class="' . $cssClass . '"><td>' . $message . '</td><tr></table></div>';
    }
  }
}

?>