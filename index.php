<?php
                          
require_once 'util/EHCS.php';
$EHCS = EHCS::getInstance(); 
$EHCS->setPagePath(PAGE_INDEX);
$EHCS->setHtmlTitle('Login');

$htmlContent = '<div class="row">
                      <div class="span8">
                        <div id="welcome_carousel" class="carousel slide">
                        <div class="carousel-inner">';
$active = 'active';
foreach (glob("img/carousel/*") as $filename) 
{
    $htmlContent .= '<div class="item ' . $active . '">
                            <img src="' . $filename . '" alt="' . $filename . '" />
                          </div>';
    $active = '';
}

$htmlContent .=   '</div>
                        <a class="carousel-control left" href="#welcome_carousel" data-slide="prev">&lsaquo;</a>
                        <a class="carousel-control right" href="#welcome_carousel" data-slide="next">&rsaquo;</a>
                      </div>
                    </div>         
                    <div class="span4">' . User::getInstance()->getLoginForm() . '</div>
                  </div>';
                    
$EHCS->setHtmlContent($htmlContent);    
$EHCS->setFooterContent('<script type="text/javascript">
                    $(document).ready(function(){
                      $("#welcome_carousel").carousel({ interval: 3000 });
                    });
                  </script>'); 
$EHCS->display();

?>
