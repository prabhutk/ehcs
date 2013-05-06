<?php

namespace EHCS;
use mysqli;

abstract class Model
{
    public function init()
    {
        $config = Config::getInstance();
        $this->mysqli = new mysqli($config['db']['host'], $config['db']['user'], $config['db']['login'], $config['db']['name']);

        /* check connection */
        if ($this->mysqli->connect_errno) {
            $error = $config['error']['db']['connect'];
            Redirector::getInstance()->redirect('error/page/db/', array('error' => $error));
        }
    }

    public function runSql($sql)
    {
        $result = $this->mysqli->query($sql);
        if ($result === false) {
            $config = Config::getInstance();
            $error = $config['error']['db']['sql'];
            Redirector::getInstance()->redirect('error/page/db/', array('error' => $error));
        }

        return $result;
    }

    public function getAffectedRows()
    {
        return $this->mysqli->affected_rows;
    }

    public function createHash($inText, $saltHash = NULL, $mode = 'sha1')
    {
        // hash the text //
        $textHash = hash($mode, $inText);
        // set where salt will appear in hash //
        $saltStart = strlen($inText);
        // if no salt given create random one //
        if ($saltHash == NULL) {
            $saltHash = hash($mode, uniqid(rand(), true));
        }
        // add salt into text hash at pass length position and hash it //
        if ($saltStart > 0 && $saltStart < strlen($saltHash)) {
            $textHashStart = substr($textHash, 0, $saltStart);
            $textHashEnd = substr($textHash, $saltStart, strlen($saltHash));
            $outHash = hash($mode, $textHashEnd . $saltHash . $textHashStart);
        } elseif ($saltStart > (strlen($saltHash) - 1)) {
            $outHash = hash($mode, $textHash . $saltHash);
        } else {
            $outHash = hash($mode, $saltHash . $textHash);
        }
        // put salt at front of hash //
        $output = hash($mode, $saltHash . $outHash);
        return $output;
    }

    //===================================== private =====================================

    private $mysqli;
}