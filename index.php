<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>walkabine</title>
    </head>
    <body>
        <header>
            <h1>walkabine</h1>
        </header>
        <article id="main">

<?php

include_once('functions.inc.php');

try {
    printForm();
} catch(Exception $e) {
    echo 'Exception' . $e->getMessage();
}

?>

        </article>
        <footer>
            <a href="http://neuwal.com">
                neuwal.com
            </a>
        </footer>
    </body>
</html>