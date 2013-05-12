<?php

namespace appointment\controllers;
use EHCS\Controller;

class MonthController extends Controller
{
    function viewAction()
    {
        $model = $this->getModel($this->getModule(), $this->getModule());
        $result = $model->fetchAll();

        $appointments = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $appointments[] = array(
                    'AppointMentId' => $row->AppointMentId,
                    'PatientName' => $row->PatientName,
                    'DoctorName' => $row->DoctorName,
                    'StartTime' => $row->StartTime,
                    'EndTime' => $row->EndTime
                );
            }
        }
        $this->getView($this->getModule(), $this->getController())->display($appointments);
    }
}