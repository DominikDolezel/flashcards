<?php
    $to_add = "";
    $wrong = $_COOKIE["wrong"];
    do {
        $to_add = $wrong[-1] . $to_add;
        echo $to_add;
        $wrong = substr($wrong, 0, -1);
        echo "\n" . $wrong . "\n";
    } while ($wrong[-1] != ",");

    $to_add = $wrong[-1] . $to_add;
    echo $to_add;
    $wrong = substr($wrong, 0, -1);
    echo "\n" . $wrong . "\n";

    setcookie("wrong", $wrong, time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("correct", $_COOKIE["correct"] . $to_add, time() + (86400 * 30), "/"); // 86400 = 1 day

    $set_id = $_GET["set_id"];
    header("Location: select_card.php?set_id=" . (string)$set_id);
    exit();
?>
