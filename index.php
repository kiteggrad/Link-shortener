<?php

require_once 'Shortener.php';
require_once 'MyException.php';
require_once 'Logger.php';

$short = false;
$exception = false;

if(isset($_GET['go'])) {
    try {
        Shortener::go($_GET['go']);
    } catch (\MyException $e) {
        $exception = $e->getMessage();
    } catch (\Throwable $e) {
        $exception = 'Ошибка на стороне сервера';
        Logger::logException($e);
    }
} elseif (isset($_POST['link'])) {
    try {
        $short = Shortener::new($_POST['link']);
    } catch (\MyException $e) {
        $exception = $e->getMessage();
    } catch (\Throwable $e) {
        $exception = 'Ошибка на стороне сервера';
        Logger::logException($e);
    }
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Link Shortener</title>
    </head>
    <body>
        <div class="container">
            <form action="/" method="post">
                <?php if (!$exception) : ?>
                    <?php if (!$short) : ?>
                        <input type="text" name="link" placeholder="Ссылка для сокращения" maxlength="1023">
                        <input type="submit">
                    <?php else: ?>
                        <p>Укороченная ссылка:</p>
                        <p><?php echo $short; ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p><?php echo $exception; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </body>
</html>