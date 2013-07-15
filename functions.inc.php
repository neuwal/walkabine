<?php

include_once('JsonRepository.class.php');

function printContent() {
    try {
        $step = 0;
        if (isset($_POST['step'])) {
            $step = intval($_POST['step']);
        } else {
            // Unset all of the session variables.
            $_SESSION = array();
        }

        $repository = new JsonRepository('data.json');

        if ($step > 0 && isset($_POST['submit']) && $_POST['submit'] === 'submit') {
            savePostToSession($repository->collection, $step);
        }

        if ($step >= count($repository->collection)) {
            printResults($step);
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

/**
 * @param $repository
 * @param $step
 */
function printForm($repository, $step) {
    $collection = $repository->collection;
    $question = $collection[$step];

    shuffle($question->answers);

    $numberOfSteps = count($collection);
?>


<form action="index.php" method="post">
    <p class="text-droid text-10em black">
        <!--<span class="text-bold text-10em black">Bildung</span><br />-->
        <span class="text-bold text-20em black"><?php echo $question->questionText; ?></span>
    </p>

    <table class="wahlcheck">
        <?php foreach ($question->answers as $answer) { ?>
        <tr>
            <td class="60%"><?php echo $answer->text; ?></td>
            <td class="20%" id="skin_4">
                <input
                    id="q-<?php echo $step; ?>_<?php echo $answer->partyId; ?>_like"
                    name="q-<?php echo $step; ?>_<?php echo $answer->partyId; ?>"
                    type="radio"
                    value="like"
                    <?php
                        $name = 'q-' . $step . '_' . $answer->partyId;
                        if (isset($_SESSION[$name]) && $_SESSION[$name] === 'like') {
                            echo 'checked="checked"';
                        }
                    ?>
                    required="required" />
            </td>
            <td class="20%" id="skin_6">
                <input
                    id="q-<?php echo $step; ?>_<?php echo $answer->partyId; ?>_unlike"
                    name="q-<?php echo $step; ?>_<?php echo $answer->partyId; ?>"
                    type="radio"
                    value="unlike"
                    <?php
                    if (isset($_SESSION[$name]) && $_SESSION[$name] === 'unlike') {
                        echo 'checked="checked"';
                    }
                    unset($name);
                    ?>
                    required="required" />
            </td>
        </tr>
        <?php } ?>
    </table>

    <div class="wahlumfragen-menu-subsub">
        <table class="wahlcheck-prio">
            <tr>
                <td width="25%"></td>
                <td width="25%" id="skin_7">
                    <input
                        id="q-<?php echo $step; ?>_priority_low"
                        name="q-<?php echo $step; ?>_priority"
                        type="radio"
                        value="low"
                        <?php
                        $name = 'q-' . $step . '_priority';
                        if (isset($_SESSION[$name]) && $_SESSION[$name] === 'low') {
                            echo 'checked="checked"';
                        }
                        ?>
                        required="required" />
                </td>
                <td width="25%" id="skin_8">
                    <input
                        id="q-<?php echo $step; ?>_priority_medium"
                        name="q-<?php echo $step; ?>_priority"
                        type="radio"
                        value="medium"
                        <?php
                        if ((isset($_SESSION[$name]) && $_SESSION[$name] === 'medium') || !isset($_SESSION[$name])) {
                            echo 'checked="checked"';
                        }
                        ?>
                        required="required" />
                </td>
                <td width="25%" id="skin_9">
                    <input
                        id="q-<?php echo $step; ?>_priority_high"
                        name="q-<?php echo $step; ?>_priority"
                        type="radio"
                        value="high"
                        <?php
                        if (isset($_SESSION[$name]) && $_SESSION[$name] === 'high') {
                            echo 'checked="checked"';
                        }
                        ?>
                        required="required" />
                </td>
            </tr>
            <tr>
                <td width="25%" class="white">Dieses Thema ist mir...</td>
                <td class="white"><label for="q-<?php echo $step; ?>_priority_low">Tief</label></td>
                <td class="white"><label for="q-<?php echo $step; ?>_priority_medium">Mittel</label></td>
                <td class="white"><label for="q-<?php echo $step; ?>_priority_high">Hoch</label></td>
            </tr>
        </table>
    </div>

    <input id="step" name="step" type="hidden" value="<?php echo $step + 1; ?>" />

    <div class="wahlumfragen-menu-subsub">
        <p class="text-droid white text-decoration-none text-18em text-center"><a href="#" onClick="submit();" class="text-droid text-20em white text-decoration-none">zur nächsten Frage</a></p>
    </div>

    <input id="submit" name="submit" type="submit" value="submit" />

</form>
<form action="index.php" method="post">
    <input id="step" name="step" type="hidden" value="<?php echo $step - 1; ?>" />

    <?php if ($step > 0) { ?>
        <input id="back" name="back" type="submit" value="back" />
    <?php } ?>
</form>

<?php
}

/**
 *
 */
function printResults($step) {
    $results = readResults();

    arsort($results);
?>

<ol>
    <?php  foreach($results as $key => $value) { ?>
    <li><?php echo $key . ': ' . $value ?></li>
    <?php  } ?>
</ol>

<form action="index.php" method="post">
    <input id="step" name="step" type="hidden" value="<?php echo $step - 1; ?>" />

    <?php if ($step > 0) { ?>
        <input id="back" name="back" type="submit" value="back" />
    <?php } ?>
</form>


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





















