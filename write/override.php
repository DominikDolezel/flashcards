<?php
$to_add = "";
$wrong = $_COOKIE["wrong"];
$focus_on = $_COOKIE["focus_on"];
$card_id = $_GET["card_id"];
do {
    $to_add = $wrong[-1] . $to_add;
    $wrong = substr($wrong, 0, -1);
    $focus_on = substr($focus_on, 0, -1);
} while ($wrong[-1] != ",");

$to_add = $wrong[-1] . $to_add;
$wrong = substr($wrong, 0, -1);
$focus_on = substr($focus_on, 0, -1);

setcookie("wrong", $wrong, time() + 86400 * 30, "/"); // 86400 = 1 day
setcookie("correct", $_COOKIE["correct"] . $to_add, time() + 86400 * 30, "/"); // 86400 = 1 day
setcookie("focus_on", $focus_on, time() + 86400 * 30, "/"); // 86400 = 1 day

($file = fopen("../data.json", "r")) or die("Unable to open file!");
$data_file = fread($file, filesize("../data.json"));
fclose($file);
$data = json_decode($data_file, true);

$data["users"][(int) $_COOKIE["user_index"]]["tries"][
    (int) $_COOKIE["set_index_in_tries"]
]["cards"][(string) $card_id]["wrong"] -= 1;

$data["users"][(int) $_COOKIE["user_index"]]["tries"][
    (int) $_COOKIE["set_index_in_tries"]
]["cards"][(string) $card_id]["correct"] += 1;

($myfile = fopen("../data.json", "w")) or die("Unable to open file!");
fwrite($myfile, json_encode($data, JSON_PRETTY_PRINT));
fclose($myfile);

$set_id = $_GET["set_id"];
header("Location: select_card.php?set_id=" . (string) $set_id);
exit();
?>
