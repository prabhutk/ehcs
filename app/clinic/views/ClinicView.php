<?php

namespace clinic\views;
use EHCS\View;
use EHCS\Config;
use EHCS\Form;

class ClinicView extends View
{
    function display($clinics)
    {
        $html = '<h3><a class="btn btn-mini" href="' . BASE_URL . 'clinic/clinic/add/' . '" title="Add"><i class="icon-plus-sign"></i></a> Clinics</h3>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>IsOpen</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach($clinics as $clinic)
        {
            $html .= '<tr>';
            $html .= '<td>' . $clinic['Code'] . '</td>';
            $html .= '<td>' . $clinic['Name'] . '</td>';
            $html .= '<td>' . $clinic['IsOpen'] . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        $this->setHtmlContent($html);
        parent::display();
    }

    function displayAdd(Form $form)
    {
        $this->setHtmlContent($form->getHtml());
        $this->setHtmlFooter('');
        parent::display();
    }
}