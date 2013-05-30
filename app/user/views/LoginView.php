<?php

namespace user\views;
use EHCS\View;
use EHCS\Form;
use EHCS\Config;

class LoginView extends View
{
    function display(Form $form = null, Form $signupForm = null)
    {
        $htmlContent = '<div class="row">
                          <div class="span8">
                            <div id="welcome_carousel" class="carousel slide">
                            <div class="carousel-inner">';
        $active = 'active';
        foreach (glob("img/carousel/*") as $filename) {
            $htmlContent .= '<div class="item ' . $active . '">
                                <img src="' . BASE_URL . $filename . '" alt="' . $filename . '" />
                              </div>';
            $active = '';
        }

        $htmlContent .= '</div>
                            <a class="carousel-control left" href="#welcome_carousel" data-slide="prev">&lsaquo;</a>
                            <a class="carousel-control right" href="#welcome_carousel" data-slide="next">&rsaquo;</a>
                          </div>
                        </div>         
                        <div class="span4">
                            <div>' . $form->getHtml() . '</div>';
        if($signupForm) {
            $htmlContent .= '<div>' . $signupForm->getHtml() . '</div>';
        }

        $htmlContent .= '</div>
                      </div>';

        $this->setHtmlContent($htmlContent);

        $htmlHead = '<link rel="stylesheet" href="' . BASE_URL . 'js/dijit/themes/claro/claro.css">';
        $this->setHtmlHead($htmlHead);

        $this->setHtmlFooter('<script type="text/javascript">
                        $(document).ready(function(){
                          $("#welcome_carousel").carousel({ interval: 3000 });
                        });
                      $(function() {
                        $( "#appt_date" ).datepicker({dateFormat: "yy-mm-dd"});
                      });
                      </script>');
        parent::display();
    }

    function displayReset(Form $form)
    {
        $this->setHtmlContent($form->getHtml());
        parent::display();
    }
}