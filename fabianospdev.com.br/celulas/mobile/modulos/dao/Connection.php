<?php
namespace mobile\modulos\dao;

use PDO;

final class Connection
{

    public static $instance;

    private static $dbtype = "mysql";      //mysql

    private static $host = "localhost";    //sql246.main-hosting.eu

    private static $port = "3306";         //3306

    private static $user = "u564016761_root";         //u564016761_root

    private static $password = "5jard#secret";        //5jard#secret

    private static $db = "celulasdb";     //u564016761_celulasDB

    /*
     * Metodos que trazem o conteudo da variavel desejada
     * @return $xxx = conteudo da variavel solicitada
     */
    private static function getDBType()
    {
        return self::$dbtype;
    }

    private static function getHost()
    {
        return self::$host;
    }

    private static function getPort()
    {
        return self::$port;
    }

    private static function getUser()
    {
        return self::$user;
    }

    private static function getPassword()
    {
        return self::$password;
    }

    private static function getDB()
    {
        return self::$db;
    }

    function __construct()
    {}

    public static function getInstance()
    {
        if (! isset(self::$instance)) {
            self::$instance = new PDO(self::getDBType() . ":host=" . self::getHost() . ";port=" . self::getPort() . ";charset=UTF8;dbname=" . self::getDB(), self::getUser(), self::getPassword());
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        }

        return self::$instance;
    }

    private function __clone()
    {}

    private function __wakeup()
    {}
}