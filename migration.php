<?php

require 'MyPDO.php';

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

    $dbh = MyPDO::getDBHandler();

    $dbh->exec("
            CREATE TABLE shortLinks($columns)
        ");
}

function down()
{
    $dbh = MyPDO::getDBHandler();

    $dbh->exec("
        DROP TABLE IF EXISTS shortLinks
    ");
}

function refresh()
{
    down();
    up();
}