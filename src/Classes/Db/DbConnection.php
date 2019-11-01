<?php
require_once 'Medoo.php';
require_once 'DbException.php';

class DbConnection
{
    /**
     * @var Medoo[]
     */
    public static $dbConnections = [];

    /**
     * Initialize Component
     * @param $databaseConfig
     * @throws DbException
     */
    public static function init($databaseConfig)
    {
        if (count($databaseConfig))
        {
            // Init Database Connections
            foreach ($databaseConfig as $name => $options)
            {
                self::create($name, $options);
            }
        }
    }

    /**
     * @param string $name
     * @param array $options
     * @return Medoo
     * @throws DbException
     */
    public static function create($name, $options)
    {
        try {
            return self::$dbConnections[$name] = new Medoo($options);
        } catch(Exception $ex) {
            throw new DbException($name, $ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * @param string $name
     * @return Medoo
     * @throws DbException
     */
    public static function getInstance($name = 'db')
    {
        if(isset(self::$dbConnections[$name]))
            return self::$dbConnections[$name];
        else
            throw new DbException($name, 'Database connection not found');
    }
}