<?php

require 'MyPDO.php';

class Shortener
{
    /**
     * Проверяет короткую ссылку и отправляет по ней
     *
     * @param $key
     * @throws Exception
     */
    public static function go($key)
    {
        $finded = self::getLink($key);
        if($finded) {
            self::redirect($finded['link']);
        } else {
            throw new Exception('ссылка не найдена');
        }
    }

    /**
     * Создаёт и возвращает новую короткую ссылку
     *
     * @param string $link
     * @return string
     * @throws Exception
     */
    public static function new(string $link): string
    {
        $id = self::saveLink($link);
        $key = self::generateKey($id);

        return $_SERVER['HTTP_HOST'] . "?go=$key";
    }

    /**
     * Перенаправляет на указанный url
     *
     * @param $url
     */
    private static function redirect($url)
    {
        header("location: $url");
        exit;
    }

    /**
     * Генерирует ключ из id записи
     *
     * @param $id
     * @return string
     */
    private static function generateKey($id): string
    {
        return base_convert($id, 10, 36);
    }

    /**
     * Сохраняет ссылку в базе данных
     * возвращет id записи
     *
     * @param string $url
     * @return int
     * @throws Exception
     */
    private static function saveLink(string $url): int
    {
        self::checkIsURL($url);
        $dbh = MyPDO::getDBHandler();
        $url = $dbh->quote($url);

        $finded = self::searchLink($url);

        if($finded) {
            return $finded['id'];
        } else {
            $dbh->exec("
                INSERT INTO shortlinks(link) VALUES ($url)
            ");

            $id = $dbh->lastInsertId();
        }

        return $id;
    }

    /**
     * Ищет ссылку в базе данных по ключу
     * если не находит возвращет false
     *
     * @param string $key
     * @return mixed
     */
    private static function getLink(string $key)
    {
        $id = intval($key, 36);

        $dbh = MyPDO::getDBHandler();

        $link = $dbh->query( "
            SELECT * FROM shortlinks WHERE id = $id
        ")->fetch();

        return $link;
    }

    /**
     * Ищет ссылку в базе данных
     * если не находит возвращет false
     *
     * @param string $url
     * @return mixed
     */
    private static function searchLink(string $url)
    {
        $dbh = MyPDO::getDBHandler();

        $link = $dbh->query( "
            SELECT * FROM shortlinks WHERE link = $url
        ")->fetch();

        return $link;
    }

    /**
     * Проверяет является ли строка ссылкой
     *
     * @param string $url
     * @throws Exception
     */
    private static function checkIsURL(string $url)
    {
        if(!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("$url не является ссылкой");
        }
        return ;
    }
}