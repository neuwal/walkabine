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

if (isset($_POST['submit']) && $_POST['submit'] === 'submit') {
    try {
        printResults();
    } catch(Exception $e) {
        echo 'Exception' . $e->getMessage();
    }
} else {
    try {
        printForm();
    } catch(Exception $e) {
        echo 'Exception' . $e->getMessage();
    }
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