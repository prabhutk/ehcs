<?php

namespace clinic\models;
use EHCS\Model;
use EHCS\Request;
use EHCS\Config;
use EHCS\Redirector;

class ClinicModel extends Model
{
    public function fetchAll()
    {
        $config = Config::getInstance();
        $sql = "SELECT `ClinicId`, `Code`, `Name`, `IsOpen`
            FROM `" . $config['db']['name'] . "`.`clin_clinic`";

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
            $error = $config['error'][$this->getController()]['add'];
            Redirector::getInstance()->redirect('error/page/db/', array('error' => $error));
        }
    }
}     
                  