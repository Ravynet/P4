<?php

/**
 * Class DBFactory
 */
class DBFactory
{
    /**
     * @return PDO
     */
    public static function getMysqlConnexionWithPDO()
    {
        $db = new PDO('mysql:host=mysql-jean-forteroche.alwaysdata.net;dbname=jean-forteroche_blog;charset=utf8', '147224', 'jeanF');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }

    /**
     * @return MySQLi
     */
    public static function getMysqlConnexionWithMySQLi()
    {
        return new MySQLi('localhost', 'root', '', 'blog');
    }
}
