<?php

include_once('JsonRepository.class.php');

function printForm() {
    $repository = new JsonRepository('data.json');

    $collection = $repository->collection;

    $question = $collection[0];

    /*echo '<pre>';
    print_r($repository->collection);
    echo '</pre>';*/

?>


<form>

    <h2><?php echo $question->questionText; ?></h2>

    <ul>
        <?php foreach ($question->answers as $answer) { ?>
        <li><?php echo $answer->text; ?></li>
        <?php } ?>
    </ul>

</form>

<?php
}