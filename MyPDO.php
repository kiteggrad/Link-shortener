<?php

class MyPDO
{
    private static $dbh = null;

    public static function getDBHandler(string $pdoIni = 'settings.ini'): PDO
    {
        if(self::$dbh != null) {
            return self::$dbh;
        }

        $pdo_ini = parse_ini_file('settings.ini');

        $db_connection = $pdo_ini['DB_CONNECTION'];
        $db_host = $pdo_ini['DB_HOST'];
        $db_name = $pdo_ini['DB_DATABASE'];
        $db_user = $pdo_ini['DB_USERNAME'];
        $db_password = $pdo_ini['DB_PASSWORD'];

        $dbh = new PDO("$db_connection:host=$db_host;dbname=$db_name", $db_user, $db_password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$dbh = $dbh;

        return self::$dbh;
    }


//    public static function createTable(string $name, array $columns, $ifNotExists = true)
//    {
//        $dbh = self::getDBHandler();
//        $ifNotExists = $ifNotExists ? 'IF NOT EXISTS' : '';
//
//        $columns = implode(",\n", $columns);
//
//        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//        $createTable = $dbh->exec("
//            CREATE TABLE $ifNotExists $name($columns)
//        ");
//
//        return $createTable;
//    }

//    public static function insert(string $table, array $columns, array $values)
//    {
//        $dbh = self::getDBHandler();
//
//        $columns = implode(",\n", $columns);
//        $values = implode(",\n", $values);
//
//        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//        $dbh->exec("
//            INSERT INTO $table($columns) VALUES ($values)
//        ");
//
//        return $dbh->lastInsertId();
//    }
//
//    public static function dropTable(string $name, bool $ifExists = true)
//    {
//        $dbh = self::getDBHandler();
//        $ifExists = $ifExists ? 'IF EXISTS' : '';
//
//        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//        $dropTable = $dbh->exec("
//            DROP TABLE $ifExists $name
//        ");
//
//        return $dropTable;
//    }

}