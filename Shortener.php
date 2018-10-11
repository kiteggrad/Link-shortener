<?php

require_once 'DB.php';
require_once 'MyException.php';

class Shortener
{
    /**
     * Ищет ссылку по ключу и отправляет по ней
     *
     * @param string $key
     * @throws MyException
     */
    public static function go(string $key)
    {
        $id = self::decodeKey($key);
        $found = DB::getLink($id);

        if($found) {
            self::redirect($found['link']);
        } else {
            throw new MyException('Ссылка не найдена');
        }
    }

    /**
     * Создаёт и возвращает новую короткую ссылку
     *
     * @param string $link
     * @return string
     * @throws MyException
     */
    public static function new(string $link): string
    {
        $link = self::validateURL($link);
        $id = DB::saveLink($link);
        $key = self::generateKey($id);

        return $_SERVER['HTTP_HOST'] . "?go=$key";
    }

    /**
     * Перенаправляет на указанный url
     *
     * @param $url
     */
    private static function redirect(string $url)
    {
//        header("location: $url");
        echo "<script>self.location='$url';</script>";
        exit();
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
     * Декодирует ключ в id
     *
     * @param string $key
     * @return int
     */
    private static function decodeKey(string $key): int
    {
        return intval($key, 36);
    }

    /**
     * Валидирует ссылку до абсолютной
     *
     * @param string $url
     * @return string
     * @throws MyException
     */
    private static function validateURL(string $url)
    {
        $url = htmlentities($url);

        if(!preg_match('/^(https?:\/\/)?([\w\.]+)\.([a-z]{2,6}\.?)(\/[\w\.]*)*\/?$/' , $url)) {
            throw new MyException("$url не является ссылкой");
        }
        if(!preg_match('@(http\://)|(https\://)@', $url)) {
            return 'http://' . $url;
        } else {
            return $url;
        }
    }
}