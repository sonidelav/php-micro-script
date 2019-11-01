<?php

class DbException extends Exception
{
    private $connectionName;

    public function __construct($connName, $message = "", $code = 13, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->connectionName = $connName;
    }

    public function __toString()
    {
        return "DbException: " . $this->getMessage() . " ( Connection = " . $this->connectionName . " )";
    }

    public function getConnectionName()
    {
        return $this->connectionName;
    }
}