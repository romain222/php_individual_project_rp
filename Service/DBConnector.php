<?php

namespace Service;

class DBConnector
{
    private static $config;

    private static $connection;

    public static function setConfig($config)
    {
        self::$config = $config;
    }

    private static function createConnection()
    {
        $dsn = sprintf('%s:host=%s;dbname=%s', self::$config['driver'], self::$config['host'], self::$config['dbname']);
        
        self::$connection = new \PDO(
            $dsn, 
            self::$config['dbuser'], 
            self::$config['dbpass']
            );
    }

    public static function getConnection()
    {
        if (!self::$connection) {
            self::createConnection();
        }
        return self::$connection;
    }
}