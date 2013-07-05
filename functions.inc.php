<?php

include_once('JsonRepository.class.php');

function printContent() {
    try {
        $step = 0;
        if (isset($_POST['step'])) {
            $step = intval($_POST['step'] + 1);
        }

        $repository = new JsonRepository('data.json');
        savePostToSession($repository->collection, $step);

        if ($step >= count($repository->collection)) {
            printResults();
        } else {
            printForm($repository, $step);
        }
    } catch(Exception $e) {
        echo 'Exception: ' . $e->getMessage();
    }
}

/**
 * @param $collection
 * @param $step
 * @throws Exception
 */
function savePostToSession($collection, $step) {
    session_start();
    if ($step > 0) {
        $step -= 1;
        $name = 'q-' . ($step) . '_priority';
        if (!isset($_POST[$name])) {
            throw new Exception('POST "' . $name . '" is not set.');
        }
        $_SESSION[$name] = $_POST[$name];
        unset($name);
        $question = $collection[$step];
        foreach ($question->answers as $answer) {
            $name = 'q-' . $step . '_' . $answer->partyId;
            if (!isset($_POST[$name])) {
                throw new Exception('POST "' . $name . '" is not set.');
            }
            $_SESSION[$name] = $_POST[$name];
        }
    }
}

/**
 * @param $repository
 * @param $step
 */
function printForm($repository, $step) {
    $collection = $repository->collection;
    $question = $collection[$step];
    $numberOfSteps = count($collection);
?>


<form action="index.php" method="post">
    <h2><?php echo 'Frage ' . ($step + 1) . '/' . $numberOfSteps . ': ' . $question->questionText; ?></h2>

    <ul>
        <?php foreach ($question->answers as $answer) { ?>
        <li>
            <span><?php echo $answer->text; ?></span>
            <label for="q-<?php echo $step; ?>_<?php echo $answer->partyId; ?>_like">like</label>
            <input
                id="q-<?php echo $step; ?>_<?php echo $answer->partyId; ?>_like"
                name="q-<?php echo $step; ?>_<?php echo $answer->partyId; ?>"
                type="radio"
                value="like"
                required="required" />
            <label for="q-<?php echo $step; ?>_<?php echo $answer->partyId; ?>_unlike">unlike</label>
            <input
                id="q-<?php echo $step; ?>_<?php echo $answer->partyId; ?>_unlike"
                name="q-<?php echo $step; ?>_<?php echo $answer->partyId; ?>"
                type="radio"
                value="unlike"
                required="required" />
        </li>
        <?php } ?>

        <li>
            <span>Priorität:</span>
            <label for="q-<?php echo $step; ?>_priority_low">Tief</label>
            <input
                id="q-<?php echo $step; ?>_priority_low"
                name="q-<?php echo $step; ?>_priority"
                type="radio"
                value="low"
                required="required" />
            <label for="q-<?php echo $step; ?>_priority_medium">Mittel</label>
            <input
                id="q-<?php echo $step; ?>_priority_medium"
                name="q-<?php echo $step; ?>_priority"
                type="radio"
                value="medium"
                checked="checked"
                required="required" />
            <label for="q-<?php echo $step; ?>_priority_high">Hoch</label>
            <input
                id="q-<?php echo $step; ?>_priority_high"
                name="q-<?php echo $step; ?>_priority"
                type="radio"
                value="high"
                required="required" />
        </li>
    </ul>

    <input id="step" name="step" type="hidden" value="<?php echo $step; ?>" />

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
    $step = 0;
    foreach ($collection as $question) {
        $name = 'q-' . $step . '_priority';
        if (!isset($_SESSION[$name])) {
            throw new Exception('POST "' . $name . '" is not set.');
        }
        $priority = $_SESSION[$name];
        $questionMultiplier = ($priority === 'low') ? 0.5 : (($priority === 'high') ? 2 : 1);
        unset($name);
        foreach ($question->answers as $answer) {
            if (!isset($results[$answer->party])) {
                $results[$answer->party] = 0;
            }
            $name = 'q-' . $step . '_' . $answer->partyId;
            if (!isset($_SESSION[$name])) {
                throw new Exception('POST "' . $name . '" is not set.');
            }
            $value = $_SESSION[$name];
            if ($value === 'like') {
                $results[$answer->party] += 1 * $questionMultiplier;
            } else if ($value === 'unlike') {
                $results[$answer->party] -= 1 * $questionMultiplier;
            }
        }
        $step++;
    }

    return $results;
}





















