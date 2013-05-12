<?php

namespace user\models;
use EHCS\Model;
use EHCS\Request;
use EHCS\Config;
use EHCS\Redirector;

class UserModel extends Model
{
    public function fetchAll()
    {
        $config = Config::getInstance();
        $sql = "SELECT `UserId`, `Email`, `Role`, `IsActive`
            FROM `" . $config['db']['name'] . "`.`user_login`";

        return $this->runSql($sql);
    }

    public function save()
    {
        $email = Request::getInstance()->getPost('email');
        $role = Request::getInstance()->getPost('role');

        $config = Config::getInstance();
        $login = $this->createHash($email, $config['db']['salt']);

        $sql = "INSERT INTO `" . $config['db']['name'] . "`.`user_login`
            (`UserId`, `Email`, `Login`, `Role`, `IsActive`)
            VALUES
            ('', '$email', '$login', '$role', 'N')";

        $this->runSql($sql);

        if ($this->getAffectedRows() !== 1) {
            $error = $config['error']['user']['add'];
            Redirector::getInstance()->redirect('error/page/db/', array('error' => $error));
        }

        return $login;
    }
}     
                  