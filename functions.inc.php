<?php

include_once('JsonRepository.class.php');

function printForm() {
    $repository = new JsonRepository('data.json');
    $collection = $repository->collection;
?>


<form action="index.php" method="post">

    <ol>
        <?php foreach ($collection as $question) { ?>
        <li>
            <h2><?php echo $question->questionText; ?></h2>

            <ul>
                <?php foreach ($question->answers as $answer) { ?>
                <li>
                    <span><?php echo $answer->text; ?></span>
                    <label for="q-<?php echo $question->id; ?>_<?php echo $answer->party; ?>_like">like</label>
                    <input
                        id="q-<?php echo $question->id; ?>_<?php echo $answer->party; ?>_like"
                        name="q-<?php echo $question->id; ?>_<?php echo $answer->party; ?>"
                        type="radio"
                        value="like"
                        required="required" />
                    <label for="q-<?php echo $question->id; ?>_<?php echo $answer->party; ?>_unlike">unlike</label>
                    <input
                        id="q-<?php echo $question->id; ?>_<?php echo $answer->party; ?>_unlike"
                        name="q-<?php echo $question->id; ?>_<?php echo $answer->party; ?>"
                        type="radio"
                        value="unlike"
                        required="required" />
                </li>
                <?php } ?>

                <li>
                    <span>Priorität:</span>
                    <label for="q-<?php echo $question->id; ?>_priority_low">Tief</label>
                    <input
                        id="q-<?php echo $question->id; ?>_priority_low"
                        name="q-<?php echo $question->id; ?>_priority"
                        type="radio"
                        value="low"
                        required="required" />
                    <label for="q-<?php echo $question->id; ?>_priority_medium">Mittel</label>
                    <input
                        id="q-<?php echo $question->id; ?>_priority_medium"
                        name="q-<?php echo $question->id; ?>_priority"
                        type="radio"
                        value="medium"
                        checked="checked"
                        required="required" />
                    <label for="q-<?php echo $question->id; ?>_priority_high">Hoch</label>
                    <input
                        id="q-<?php echo $question->id; ?>_priority_high"
                        name="q-<?php echo $question->id; ?>_priority"
                        type="radio"
                        value="high"
                        required="required" />
                </li>
            </ul>
        </li>
        <?php } ?>
    </ol>

    <input id="submit" name="submit" type="submit" value="submit" />

</form>

<?php
}

/**
 *
 */
function printResults() {
    $results = readResults();

    arsort($results);
?>

<ol>
    <?php  foreach($results as $key => $value) { ?>
    <li><?php echo $key . ': ' . $value ?></li>
    <?php  } ?>
</ol>


<?php
}

/**
 * @return array
 * @throws Exception
 */
function readResults() {
    $repository = new JsonRepository('data.json');
    $collection = $repository->collection;

    $results = array();
    foreach ($collection as $question) {
        $name = 'q-' . $question->id . '_priority';
        if (!isset($_POST[$name])) {
            throw new Exception('POST "' . $name . '" is not set.');
        }
        $priority = $_POST[$name];
        $questionMultiplier = ($priority === 'low') ? 0.5 : (($priority === 'high') ? 2 : 1);
        unset($name);
        foreach ($question->answers as $answer) {
            if (!isset($results[$answer->party])) {
                $results[$answer->party] = 0;
            }
            $name = 'q-' . $question->id . '_' . $answer->party;
            if (!isset($_POST[$name])) {
                throw new Exception('POST "' . $name . '" is not set.');
            }
            $value = $_POST[$name];
            if ($value === 'like') {
                $results[$answer->party] += 1 * $questionMultiplier;
            } else if ($value === 'unlike') {
                $results[$answer->party] -= 1 * $questionMultiplier;
            }
        }
    }

    return $results;
}





















