<?php

namespace appointment\models;
use EHCS\Model;
use EHCS\Request;
use EHCS\Config;
use EHCS\Redirector;

class AppointmentModel extends Model
{
    public function fetchAll()
    {
        $config = Config::getInstance();
        $sql = "SELECT `AppointmentId`, `StartTime`, `EndTime`,"
            . " CONCAT(`patient_account`.`FirstName`, ' ', `patient_account`.`MiddleName`, ' ', `patient_account`.`LastName`) AS `PatientName`,"
            . " CONCAT(`doctor_account`.`FirstName`, ' ', `doctor_account`.`MiddleName`, ' ', `doctor_account`.`LastName`) AS `DoctorName`"
            . " FROM `ehcs`.`appt_appointment`"
            . " INNER JOIN `" . $config['db']['name'] . "`.`user_account` AS `patient_account`"
            . " ON `appt_appointment`.`user_login_UserId` = `patient_account`.`user_login_UserId`"
            . " INNER JOIN `" . $config['db']['name'] . "`.`user_account` AS `doctor_account`"
            . " ON `appt_appointment`.`user_login_UserId1` = `doctor_account`.`user_login_UserId`";

        return $this->runSql($sql);
    }

    public function save()
    {
        $code = Request::getInstance()->getPost('code');
        $name = Request::getInstance()->getPost('name');
        $isOpen = Request::getInstance()->getPost('isopen');

        $config = Config::getInstance();

        $sql = "INSERT INTO `" . $config['db']['name'] . "`.`clin_clinic`
            (`ClinicId`, `Code`, `Name`, `IsOpen`)
            VALUES
            ('', '$code', '$name', '$isOpen')";

        $this->runSql($sql);

        if ($this->getAffectedRows() !== 1) {
            $error = $config['error']['appointment']['add'];
            Redirector::getInstance()->redirect('error/page/db/', array('error' => $error));
        }
    }
}     
                  