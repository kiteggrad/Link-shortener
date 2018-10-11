<?php

class Logger
{
    public static function logException(\Throwable $throwable)
    {
        $time = date('d.m.y h:i:s');
        $message = $throwable->getMessage();
        $file = $throwable->getFile();
        $line = $throwable->getLine();
        $code = $throwable->getCode();

        $text = "[$time]\n    Message: $message\n    File: $file\n    Line: $line\n    Code: $code\n\n";

        self::writeInLog($text);
    }

    public static function log(string $text)
    {
        $time = date('d.m.y h:i:s');
        self::writeInLog("[$time]\n    $text\n\n");
    }

    private static function writeInLog(string $text, string $path = 'exceptions.log')
    {
        $fp = fopen($path, 'a');
        fwrite($fp, $text);
        fclose($fp);
    }
}