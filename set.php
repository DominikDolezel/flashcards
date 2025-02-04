<?php session_start();
setcookie("correct", " ", time() + 86400 * 30, "/");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
    setcookie("wrong", " ", time() + 86400 * 30, "/");
    setcookie("focus_on", " ", time() + 86400 * 30, "/");
    setcookie("last_card_id", " ", time() + 86400 * 30, "/");
    $set_id = $_GET["set_id"];
    ($file = fopen("data.json", "r")) or die("Unable to open file!");
    $data_file = fread($file, filesize("data.json"));
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

    $try_index = 0;
    $already_tried = false;
    foreach ($data["users"][$index]["tries"] as $try) {
        if ((string) $try["set_id"] == (string) $set["id"]) {
            $already_tried = true;
            break;
        }
        $try_index = $try_index + 1;
    }

    if ($already_tried) {
        $maximum = 0;
        foreach ($data["users"][$index]["tries"][$try_index]["cards"] as $c) {
            if ($c["correct"] > $maximum) {
                $maximum = $c["correct"];
            }
        }

        foreach (
            $data["users"][$index]["tries"][$try_index]["cards"]
            as $key => $c
        ) {
            if ((int) $c["correct"] == $maximum) {
                setcookie(
                    "correct",
                    $_COOKIE["correct"] . ", " . $key,
                    time() + 86400 * 30,
                    "/"
                );
            }
        }
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title><?php echo $set["name"]; ?></title>
    <link rel="icon" href="https://i.pinimg.com/originals/50/07/d9/5007d95c2848abc9f9bc296c0f5f520e.png">
    <link href='https://fonts.googleapis.com/css?family=Raleway:800' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet" type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Work+Sans&display=swap" rel="stylesheet" type='text/css'>
	<link rel="stylesheet" type='text/css' href="../styles.css">
    <style>
    body{
    	font-family: 'Work Sans', sans-serif;
    }
    .nav-item{
    	padding-top: 5px;
    	padding-bottom: 5px;
    }
	.progress-title{
		padding-bottom:5px;
	}
	.line{
    	padding-top: 10px;
    }
    </style>
    <?php $back_arrow =
        "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-arrow-left' viewBox='0 0 20 20'><path fill-rule='evenodd' d='M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z'/></svg>"; ?>
    <?php
    if (
        ($key = array_search(
            (int) $set_id,
            $data["users"][$index]["studied"]
        )) !== false
    ) {
        unset($data["users"][$index]["studied"][$key]);
    }

    $normal_characters = [
        "a",
        "b",
        "c",
        "d",
        "e",
        "f",
        "g",
        "h",
        "i",
        "j",
        "k",
        "l",
        "m",
        "n",
        "o",
        "p",
        "q",
        "r",
        "s",
        "t",
        "u",
        "v",
        "w",
        "x",
        "y",
        "z",
        "A",
        "B",
        "C",
        "D",
        "E",
        "F",
        "G",
        "H",
        "I",
        "J",
        "K",
        "L",
        "M",
        "N",
        "O",
        "P",
        "Q",
        "R",
        "S",
        "T",
        "U",
        "V",
        "W",
        "X",
        "Y",
        "Z",
        " ",
        ".",
        "?",
        "!",
        ",",
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9",
        "0",
        "(",
        ")",
        "'",
        '"',
    ];
    $special_characters = "";
    foreach ($set["cards"] as $c) {
        foreach (mb_str_split($c["term"]) as $char) {
            if (
                !in_array($char, $normal_characters) and
                !in_array($char, mb_str_split($special_characters))
            ) {
                $special_characters .= $char;
            }
        }
    }
    setcookie(
        "special-characters",
        $special_characters,
        time() + 86400 * 1,
        "/"
    );

    array_push($data["users"][$index]["studied"], (int) $set_id);
    $_SESSION["user"] = $data["users"][$index];
    ($myfile = fopen("data.json", "w")) or die("Unable to open file!");
    fwrite($myfile, json_encode($data, JSON_PRETTY_PRINT));
    ?>
</head>
<body>
    <?php include "templates/header.html"; ?>

    <div class="d-flex flex-row bd-highlight d-flex justify-content-center">
        <div style="padding:2em;min-width:50%">
        	<div class="card">
    	        <div class="card-body">
        			<h2 style="font-family: Raleway, sans-serif;"><?php echo $set[
               "name"
           ]; ?></h2><hr>
        			<p><?php echo $set["description"]; ?></p>
        			<button type="button" class="btn btn-primary" onclick="location.href='write/select_card.php?set_id=<?php echo (string) $set_id; ?>';">Spustit</button>
        			<div style="padding-top:10px">
        			<hr>
        			<h6>Karty:</h6>
        			<table class="table">
            			<tbody>
        			  	<?php foreach ($set["cards"] as $card) {
                  echo "<tr><td>" .
                      $card["term"] .
                      "</td><td>" .
                      $card["definition"] .
                      "</td></tr>";
              } ?>
        			  </tbody>
        			</table>
        			</div>
        	  </div>
        	</div>
        </div>
        </div>
    </div>
</body>
</html>
