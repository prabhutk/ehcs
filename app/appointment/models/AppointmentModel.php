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
        $sql = "SELECT `AppointmentId`, `StartTime`, `EndTime`, `Email`,"
            . " CONCAT(`patient_account`.`FirstName`, ' ', `patient_account`.`MiddleName`, ' ', `patient_account`.`LastName`) AS `PatientName`,"
            . " CONCAT(`doctor_account`.`FirstName`, ' ', `doctor_account`.`MiddleName`, ' ', `doctor_account`.`LastName`) AS `DoctorName`"
            . " FROM `ehcs`.`appt_appointment`"
            . " INNER JOIN `" . $config['db']['name'] . "`.`user_login`"
            . " ON `appt_appointment`.`user_login_UserId` = `user_login`.`UserId`"
            . " LEFT JOIN `" . $config['db']['name'] . "`.`user_account` AS `patient_account`"
            . " ON `appt_appointment`.`user_login_UserId` = `patient_account`.`user_login_UserId`"
            . " LEFT JOIN `" . $config['db']['name'] . "`.`user_account` AS `doctor_account`"
            . " ON `appt_appointment`.`user_login_UserId1` = `doctor_account`.`user_login_UserId`";

        return $this->runSql($sql);
    }

    public function signup($patientId)
    {
        $date = Request::getInstance()->getPost('appt_date');
        $time = Request::getInstance()->getPost('appt_time');
        $startTime = $date . ' ' . $time; ;
        $endTime = date('Y-m-d H:i:s', strtotime($startTime) + (25 * 60));

        $config = Config::getInstance();

        $sql = "INSERT INTO `" . $config['db']['name'] . "`.`appt_appointment`
            (`AppointmentId`, `StartTime`, `EndTime`, `user_login_UserId`)
            VALUES
            ('', '$startTime', '$endTime', '$patientId')";

        $this->runSql($sql);

        if ($this->getAffectedRows() !== 1) {
            $error = $config['error']['user']['signup'];
            Redirector::getInstance()->redirect('error/page/db/', array('error' => $error));
        }
    }
}     
                  