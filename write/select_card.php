<?php
	$set_id = $_GET["set_id"];
	$file = fopen("../data.json", "r") or die("Unable to open file!");
	$data_file = fread($file, filesize("../data.json"));
	fclose($file);
	$data = json_decode($data_file, true);
	foreach($data["sets"] as $s){
		if ((string)$s["id"] == (string)$set_id){
			$set = $s;
		}
	}
	if (!isset($_COOKIE["correct"])) {
		setcookie("correct", "", time() - 3600, "/");
	}
	if (!isset($_COOKIE["wrong"])) {
		setcookie("wrong", "", time() - 3600, "/");
	}
	if ((strlen($_COOKIE["correct"])/3 + strlen($_COOKIE["wrong"])/3) >= count($set["cards"])){
		if (strlen($_COOKIE["wrong"]) == 0){
			setcookie("correct", "", time() - 3600, "/");
			setcookie("wrong", "", time() - 3600, "/");
			header("Location: end.php?set_id=" . (string)$set_id);
			exit();
		} else {
			header("Location: part_end.php?set_id=" . (string)$set_id);
			exit();
		}
	}
	do {
		$card_id = $set["cards"][array_rand($set["cards"], 1)]["id"];
		if(count($set["cards"]) == ((strlen($_COOKIE["correct"])/3) + (strlen($_COOKIE["wrong"])/3) + 1) and !(strpos($_COOKIE["correct"], (string)$card_id)) and !(strpos($_COOKIE["wrong"], (string)$card_id))){
			break;
		}
	} while($card_id == $_COOKIE["last_card_id"] or strpos($_COOKIE["correct"], (string)$card_id) or strpos($_COOKIE["wrong"], (string)$card_id));
	setcookie("last_card_id", $card_id, time() + (86400 * 1), "/");
	header("Location: write.php?set_id=" . (string)$set_id . "&card_id=" . $card_id);
	exit();
?>
