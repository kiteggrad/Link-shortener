<?php

class DB
{
    private static $pdo = null;
    private static $config = null;

    /**
     * Возвращает PDO
     *
     * @param string $dbini
     * @return PDO
     */
    public static function getPDO(string $dbini = 'db.ini'): PDO
    {
        if(self::$pdo != null) {
            return self::$pdo;
        }

        $pdo_ini = self::config('db.ini');

        $db_connection = $pdo_ini['DB_CONNECTION'];
        $db_host = $pdo_ini['DB_HOST'];
        $db_name = $pdo_ini['DB_DATABASE'];
        $db_user = $pdo_ini['DB_USERNAME'];
        $db_password = $pdo_ini['DB_PASSWORD'];

        $pdo = new PDO("$db_connection:host=$db_host;dbname=$db_name", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$pdo = $pdo;

        return self::$pdo;
    }

    /**
     * Возвращает массив настроек бд
     *
     * @param string $file
     * @return array
     */
    public static function config(string $file): array
    {
        if(!self::$config) {
            self::$config = parse_ini_file($file);
        }

        return self::$config;
    }

    /**
     * Сохраняет ссылку в базе данных
     * возвращет id записи
     *
     * @param string $url
     * @return int
     */
    public static function saveLink(string $url): int
    {
        $pdo = self::getPDO();

        $finded = self::searchLink($url);

        if($finded) {
            return $finded['id'];
        }

        $stmt = $pdo->prepare('INSERT INTO links(link) VALUES (:url)');
        $stmt->execute([':url' => $url]);
        $id = $pdo->lastInsertId();

        return $id;
    }


    /**
     * Ищет ссылку в базе данных
     *
     * @param string $url
     * @return bool|array
     */
    public static function searchLink(string $url)
    {
        $pdo = self::getPDO();

        $stmt = $pdo->prepare('SELECT * FROM links WHERE link = :url');
        $stmt->execute([':url' => $url]);
        $link = $stmt->fetch($pdo::FETCH_ASSOC);

        return $link;
    }

    /**
     * Ищет ссылку в базе данных по id
     *
     * @param int $id
     * @return bool|array
     */
    public static function getLink(int $id)
    {
        $pdo = self::getPDO();

        $stmt = $pdo->prepare('SELECT * FROM links WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $link = $stmt->fetch($pdo::FETCH_ASSOC);

        return $link;
    }
}