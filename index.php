<?php

require 'shortener.php';

$short = false;
$exception = false;

if(isset($_GET['go'])) {
    try {
        Shortener::go($_GET['go']);
    } catch (\Throwable $e) {
        $exception = $e->getMessage();
    }
} elseif (isset($_POST['link'])) {
    try {
        $short = Shortener::new($_POST['link']);
    } catch (\Throwable $e) {
        $exception = $e->getMessage();
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
                        <input type="text" name="link" placeholder="Ссылка для сокращения">
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