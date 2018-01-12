<?php

class DBFactory
{
    public static function getMysqlConnexionWithPDO()
    {
        $db = new PDO('mysql:host=mysql-jean-forteroche.alwaysdata.net;dbname=jean-forteroche_blog;charset=utf8', '147224', 'Chat9288');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }

    public static function getMysqlConnexionWithMySQLi()
    {
        return new MySQLi('localhost', 'root', '', 'blog');
    }
}
