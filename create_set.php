<?php
use PSpell\Dictionary;
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Vytvořit kvíz</title>
    <link rel="stylesheet" href="../styles.css" type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet" type='text/css'>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <title>Flashcards</title>
        <link rel="icon" href="https://i.pinimg.com/originals/50/07/d9/5007d95c2848abc9f9bc296c0f5f520e.png">
        <link href='https://fonts.googleapis.com/css?family=Raleway:800' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet" type='text/css'>
    	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Work+Sans&display=swap" rel="stylesheet" type='text/css'>
    	<link rel="stylesheet" type='text/css' href="../styles.css">
     <style>
     body{
     	font-family: 'Work Sans', sans-serif;
     }

     a.nocolor, a:hover.nocolor, a:focus.nocolor, a:active.nocolor {
     text-decoration: none;
     color: inherit;
}

    .object {
        padding-left: 2em;
        padding-right: 2em;
        padding-bottom: 1em;
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
    <?php function parse_data($cards)
    {
        $data = [];
        $cards = explode("\n", $cards);
        $number = 1;
        foreach ($cards as $card) {
            $images = [];
            if (str_contains($card, "--")) {
                $card = explode("--", $card);
                $images = explode(";", $card[1]);
                $card = $card[0];
            }
            $words = explode(";", $card);
            $data[$number] = [
                "id" => $number,
                "question" => "",
                "term" => $words[0],
                "definition" => $words[1],
                "images" => $images,
            ];
            $number++;
        }
        return $data;
    } ?>
</head>
<body>
<style>
    .line{
    padding-top: 10px;
    }
</style>
    <?php include "templates/header.html"; ?>
    <div class="d-flex justify-content-center align-items-center">
        <div class="card" style="width: 50%;">
            <div class="card-body">
                <h5 class="card-title">Vytvořit set</h5>
                <div class="card-text">Zadejte potřebné informace (všechna pole jsou povinná):
                    <form class="user" action="" method="post" novalidate>
                    	<div class="line">
                            <input type="text" id="name" name="name" class="form-control form-control-user" placeholder="Název kvízu">
                        </div>
                        <div class="line">
                            <input type="text" id="description" name="description" class="form-control form-control-user" placeholder="Popis">
                        </div>

                        <p class="line">
                        	Karty zedejte ve formátu: <b>slovíčko v cizím jazyce;překlad--url prvního obrázku;url druhého obrázku</b> atd.<br>
                        	pokud ke kartě nechcete přidávat obrázky, platí formát: <b>slovíčko v cizím jazyce;překlad</b><br>
                        	Každou kartu zadávejte na svůj řádek.
                        </p>
                        <div class="line">
                            <textarea id="cards" name="cards" class="form-control form-control-user" placeholder="Sem zadejte karty..."></textarea>
                        </div>
                        <div class="line">
                        	<button type="submit" class="btn btn-primary">Přidat</button>
                        </div>
                    </form>
                    <?php
                    // define variables and set to empty values
                    $type = $name = $link = "";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $name = test_input($_POST["name"]);
                        $description = test_input($_POST["description"]);
                        $cards = test_input($_POST["cards"]);

                        /*$file = fopen("cards_to_save.json", "r") or die("Unable to open file!");
							$data_file = fread($file, filesize("cards_to_save.json"));
							fclose($file);
							$data = json_decode($data_file, true);
							$to_add = array('name'=>$name, 'description'=>$description, 'cards'=>$cards, 'author_id'=>$_SESSION["user_id"]);
							array_push($data["to_save"], $to_add);
							$myfile = fopen("cards_to_save.json", "w") or die("Unable to open file!");
							fwrite($myfile, json_encode($data, JSON_PRETTY_PRINT));
							fclose($myfile);
                            $command = escapeshellcmd('/usr/bin/python save_cards.py');
                            $output = shell_exec($command);
                            echo $output;*/

                        ($file = fopen("data.json", "r")) or
                            die("Unable to open file!");
                        $data_file = fread($file, filesize("data.json"));
                        fclose($file);
                        $data = json_decode($data_file, true);

                        $index = 0;
                        foreach ($data["users"] as $u) {
                            if (
                                (string) $u["id"] ==
                                (string) $_SESSION["user_id"]
                            ) {
                                break;
                            }
                            $index = $index + 1;
                        }
                        $set_id = 1;

                        if (!empty($data["sets"])) {
                            $set_id = (int) end($data["sets"])["id"] + 1;
                        }

                        array_push($data["sets"], [
                            "id" => $set_id,
                            "cards" => parse_data($cards),
                            "description" => $description,
                            "name" => $name,
                            "author_id" => $_SESSION["user_id"],
                        ]);

                        array_push(
                            $data["users"][$index]["sets_created"],
                            $set_id
                        );
                        $_SESSION["user"] = $data["users"][$index];
                        ($myfile = fopen("data.json", "w")) or
                            die("Unable to open file!");
                        fwrite($myfile, json_encode($data, JSON_PRETTY_PRINT));
                        fclose($myfile);

                        echo "<script>location.href='set.php?set_id=" .
                            (string) $set_id .
                            "';</script>";
                    }

                    function test_input($data)
                    {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
