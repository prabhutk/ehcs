<?php

namespace appointment\views;
use EHCS\View;
use EHCS\Config;

class MonthView extends View
{
    function display($appointments)
    {
        $html = '<h3><a class="btn btn-mini" href="' . BASE_URL . 'appointment/appointment/add/' . '" title="Add"><i class="icon-plus-sign"></i></a> Appointments</h3>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>From</th>
                            <th>To</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach($appointments as $appointment)
        {
            $html .= '<tr>';
            $html .= '<td>' . $appointment['PatientName'] . '</td>';
            $html .= '<td>' . $appointment['DoctorName'] . '</td>';
            $html .= '<td>' . $appointment['StartTime'] . '</td>';
            $html .= '<td>' . $appointment['EndTime'] . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        $this->setHtmlContent($html);
        parent::display();
    }
}