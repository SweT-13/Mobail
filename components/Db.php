<?php

class Db
{
    public static function getConnection()
    {
        $paramsPath = ROOT.'/config/db_params.php';
        $params = include($paramsPath);
        try {
            $dsn="mysql:host={$params['host']}; dbname={$params['dbname']}";
            $db = new PDO($dsn, $params['user'], $params['password']);
            // set the PDO error mode to exception
            $db->exec("set names utf-8");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
        catch (PDOException $e) {
            echo 'Ошибка подключения к БД '
                . $e->getMessage(), $e->getCode()
                . '<br>';
            die();
        }

        return $db;
    }

}