<?php
namespace Salon\LogEntries;


class LogEntries{

    protected $log;

    public function __construct($log)
    {
        $this->log = $log;
    }

    public function logInfo($info){

        $this->log->addInfo($info);

    }
    public function logError($error){

        $this->log->addError($error);

    }

    public function logWarning($warning){

        $this->log->addWarning($warning);
    }
}