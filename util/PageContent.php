<?php

class PageContent
{
  function displayHtmlHeader($htmlTitle, $htmlHead) 
  {
  
?>

<!DOCTYPE html>
<html>
  <head>
    <title>ECSH :: <?php echo $htmlTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel = 'shortcut icon' href = 'favicon.ico' />
    <?php echo $htmlHead; ?>
  </head>
  
<?php

  }
  
  function displayHtmlBody($htmlContent, $baseUrl, $navPath)
  {
  
?>
  <body> 
<?php    
    if($navPath !== NULL) 
    {
      echo '<div class="container">' . $this->displayNavigation($baseUrl, $navPath) . '</div>';
    } 
    
    echo '<div class="container">' . $htmlContent . '</div>'; 
  } 
  
  function displayHtmlFooter() 
  {
  
?>
    
    </div> <!-- /.container -->            
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

<?php
         
  }
  
  function displayNavigation($baseUrl, $navPath) 
  {             
    $navLabels = array('Home', 'Hospitals');
    $navUrls = array('', '/hospitals.php');

?>
  
      <div class="navbar-wrapper">
        <div class="navbar">
          <div class="navbar-inner">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo $baseUrl . $navUrls[0]; ?>">EHCS</a>
            <div class="nav-collapse collapse">
              <ul class="nav">
<?php
    for($i = 0; $i < 2; $i++)
    {
      echo '<li';
      if($i == $navPath)
      {
        echo ' class="active"';
      }
      echo '><a href="' . $baseUrl . $navUrls[$i] . '">' . $navLabels[$i] . '</a></li>';    
    }

?>              
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li class="nav-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
              </ul>
            </div><!--/.nav-collapse -->
          </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->
<?php
         
  }
  
  function getLoginForm()
  {
    return '<div class="span6">
              <form class="form-signin">
                <h2 class="form-signin-heading">Please sign in</h2>
                <input type="text" class="input-block-level" placeholder="Email address">
                <input type="password" class="input-block-level" placeholder="Password">
                <button class="btn btn-large btn-primary" type="submit">Sign in</button>
              </form>
            </div>';
  }
}

?>