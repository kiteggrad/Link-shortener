<?php

require 'DB.php';

switch ($argv[1]) {
    case '-up':
        up();
        echo "\n миграция произведена \n";
        break;
    case '':
        up();
        echo "\n миграция произведена \n";
        break;
    case '-down':
        down();
        echo "\n миграция удалена \n";
        break;
    case '-refresh':
        refresh();
        echo "\n миграция обновлена \n";
        break;
    default:
        throw new Exception("Неизвестный параметр $argv[1]");
}

function up()
{
    $columns = '
        id INT AUTO_INCREMENT PRIMARY KEY,
        link VARCHAR(1024) UNIQUE
    ';

    $pdo = DB::getPDO();
    $pdo->exec("CREATE TABLE links($columns)");
}

function down()
{
    $pdo = DB::getPDO();
    $pdo->exec("DROP TABLE IF EXISTS links");
}

function refresh()
{
    down();
    up();
}