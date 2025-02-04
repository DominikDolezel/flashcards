<?php
session_start();
$set_id = $_GET["set_id"];
($file = fopen("../data.json", "r")) or die("Unable to open file!");
$data_file = fread($file, filesize("../data.json"));
fclose($file);
$data = json_decode($data_file, true);
foreach ($data["sets"] as $s) {
    if ((string) $s["id"] == (string) $set_id) {
        $set = $s;
    }
}
$index = 0;
foreach ($data["users"] as $u) {
    if ((string) $u["id"] == (string) $_SESSION["user_id"]) {
        break;
    }
    $index = $index + 1;
}
setcookie("user_index", $index, time() + 86400 * 30, "/");

$found = false;
$set_index = 0;
foreach ($data["users"][(int) $index]["tries"] as $try) {
    if ((int) $try["set_id"] == (int) $set_id) {
        $found = true;
        break;
    }
    $set_index = $set_index + 1;
}

if (!$found) {
    array_push($data["users"][$index]["tries"], [
        "set_id" => $set["id"],
        "cards" => [],
    ]);

    foreach ($set["cards"] as $card) {
        $data["users"][(int) $index]["tries"][$set_index]["cards"][
            (int) $card["id"]
        ] = ["correct" => 0, "wrong" => 0];
    }
}

setcookie("set_index_in_tries", $set_index, time() + 86400 * 30, "/");

($myfile = fopen("../data.json", "w")) or die("Unable to open file!");
fwrite($myfile, json_encode($data, JSON_PRETTY_PRINT));
fclose($myfile);

if (!isset($_COOKIE["correct"])) {
    setcookie("correct", "", time() + 86400 * 30, "/");
}
if (!isset($_COOKIE["wrong"])) {
    setcookie("wrong", "", time() + 86400 * 30, "/");
}
if (
    substr_count($_COOKIE["correct"], ",") +
        substr_count($_COOKIE["wrong"], ",") >=
    count($set["cards"])
) {
    if (strlen($_COOKIE["wrong"]) == 0) {
        setcookie("correct", "", time() - 3600, "/");
        setcookie("wrong", "", time() - 3600, "/");
        header("Location: end.php?set_id=" . (string) $set_id);
        exit();
    } else {
        header("Location: part_end.php?set_id=" . (string) $set_id);
        exit();
    }
}
do {
    $card_id = $set["cards"][array_rand($set["cards"], 1)]["id"];
    if (
        count($set["cards"]) ==
            substr_count($_COOKIE["correct"], ",") +
                substr_count($_COOKIE["wrong"], ",") and
        !str_contains($_COOKIE["correct"], ", " . (string) $card_id) and
        !str_contains($_COOKIE["wrong"], ", " . (string) $card_id)
    ) {
        break;
    }
} while (
    $card_id == $_COOKIE["last_card_id"] and
        substr_count($_COOKIE["correct"], ",") != count($set["cards"]) - 1 or
    str_contains($_COOKIE["correct"], ", " . (string) $card_id) or
    str_contains($_COOKIE["wrong"], ", " . (string) $card_id)
);
setcookie("last_card_id", $card_id, time() + 86400 * 1, "/");
header(
    "Location: write.php?set_id=" . (string) $set_id . "&card_id=" . $card_id
);
exit();
?>
