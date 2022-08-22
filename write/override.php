<?php
    $to_add = "";
    $wrong = $_COOKIE["wrong"];
    $focus_on = $_COOKIE["focus_on"];
    do {
        $to_add = $wrong[-1] . $to_add;
        $wrong = substr($wrong, 0, -1);
        $focus_on = substr($focus_on, 0, -1);
    } while ($wrong[-1] != ",");

    $to_add = $wrong[-1] . $to_add;
    $wrong = substr($wrong, 0, -1);
    $focus_on = substr($focus_on, 0, -1);

    setcookie("wrong", $wrong, time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("correct", $_COOKIE["correct"] . $to_add, time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("focus_on", $focus_on, time() + (86400 * 30), "/"); // 86400 = 1 day

    $set_id = $_GET["set_id"];
    header("Location: select_card.php?set_id=" . (string)$set_id);
    exit();
?>
