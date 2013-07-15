<?php
    session_start();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>neuwal.com walmanach. Die Wahlentscheidungshilfe. - neuwal.com Politik- und Wahljournal</title>

<?php include("includes/metatags.inc.php"); ?>

        <!-- JQUERY -->
        <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>

        <script>
<?php include("js/radiobutton-image.js"); ?>
        </script>

        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="css/at2013.css" />
        <link rel="stylesheet" type="text/css" href="css/wahlumfragen.css" media="all" />
        <link rel="stylesheet" type="text/css" href="css/wahlcheck.css" media="all" />
        <link rel="stylesheet" type="text/css" href="css/disqus.css" media="all" />

        <!-- FONTS -->
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans|Bitter' rel='stylesheet' type='text/css'>
    </head>
    <body>
<?php include("header.php"); ?>
<?php //include("slider.php"); ?>
        <article id="main">

<?php

include_once('functions.inc.php');

printContent();

?>

        </article>
<?php include("footer.php"); ?>
    </body>
</html>