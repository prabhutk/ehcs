<?php

namespace EHCS;

abstract class View
{
    public function init($module, $controller, $action)
    {
        $config = Config::getInstance();
        if (isset($config['page']['title'][$module][$controller][$action])) {
            $this->htmlTitle = $config['page']['title'][$module][$controller][$action];
        }
        if (isset($config['page']['nav'][$module][$controller][$action])) {
            $this->navPath = $config['page']['nav'][$module][$controller][$action];
        }
    }

    public function setHtmlHead($htmlHead)
    {
        $this->htmlHead = $htmlHead;
    }

    public function setHtmlContent($htmlContent)
    {
        $this->htmlContent = $htmlContent;
    }

    public function setHtmlFooter($htmlFooter)
    {
        $this->htmlFooter = $htmlFooter;
    }

    public function getHtmlHead()
    {
        return $this->htmlHead;
    }

    public function getHtmlContent()
    {
        return $this->htmlContent;
    }

    public function getHtmlFooter()
    {
        return $this->htmlFooter;
    }

    public function displayHtmlHeader()
    {
        // prevent server caching of pages
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        session_cache_limiter('private, must-revalidate');

        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <title>ECSH :: <?php echo $this->htmlTitle; ?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="<?php echo BASE_URL; ?>css/bootstrap.min.css" rel="stylesheet" media="screen">
            <link rel='shortcut icon' href='<?php echo BASE_URL; ?>favicon.ico'/>
            <?php echo $this->htmlHead; ?>
        </head>

    <?php

    }

public function displayHtmlBody()
{

    ?>
<body>
    <?php

    if (strlen($this->navPath) !== 0) {
        $this->displayNavigation();
    }

    $this->displayNotification();
    echo '<div class="container">' . $this->htmlContent;
}

    public function displayHtmlFooter()
    {

        ?>

        </div> <!-- /.container -->
        <script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>js/bootstrap.min.js"></script>
        </body>
        <?php echo $this->htmlFooter; ?>
        </html>

    <?php

    }

    public function displayNavigation()
    {
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
                        <a class="brand" href="<?php echo BASE_URL; ?>">EHCS</a>

                        <div class="nav-collapse collapse">
                            <ul class="nav">
                                <?php

                                $config = Config::getInstance();
                                foreach ($config['nav']['role'] as $name => $role) {
                                    if (User::getInstance()->getPermission($role)) {
                                        echo '<li';
                                        if ($config['nav']['code'][$name] == $this->navPath) {
                                            echo ' class="active"';
                                        }
                                        echo '><a href="' . BASE_URL . $config['nav']['path'][$name] . '">' . ucfirst($name) . '</a></li>';
                                    }
                                }

                                ?>

                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                    <!-- /.navbar-inner -->
                </div>
                <!-- /.navbar -->
            </div>
            <!-- /.container -->
        </div><!-- /.navbar-wrapper -->
    <?php

    }

    public function displayNotification()
    {
        $config = Config::getInstance();

        foreach(array_keys($config['msg']) as $messageType)
        {
            $message = Request::getInstance()->getGet($messageType);

            if($message !== NULL)
            {
                echo '<div class="container"><table class="table"><tr class="' . $messageType . '"><td>' . $message . '</td><tr></table></div>';
            }
        }
    }

    public function display()
    {
        $this->displayHtmlHeader();
        $this->displayHtmlBody();
        $this->displayHtmlFooter();
    }

    //===================================== private =====================================

    private $navPath;
    private $htmlTitle;
    private $htmlHead;
    private $htmlContent;
    private $htmlFooter;
}     
                  