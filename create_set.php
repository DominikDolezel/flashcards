<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Vytvořit kvíz</title>
    <link rel="stylesheet" href="../styles.css" type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet" type='text/css'>
</head>
<body>
<style>
    .line{
    padding-top: 10px;
    }
</style>
<?php echo $_SESSION["user_id"]; ?>
    <div class="d-flex justify-content-center align-items-center" style="height:100vh">
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
							$file = fopen("cards_to_save.json", "r") or die("Unable to open file!");
							$data_file = fread($file, filesize("cards_to_save.json"));
							fclose($file);
							$data = json_decode($data_file, true);
							$to_add = array('name'=>$name, 'description'=>$description, 'cards'=>$cards, 'author_id'=>$_SESSION["user_id"]);
							array_push($data["to_save"], $to_add);
							$myfile = fopen("cards_to_save.json", "w") or die("Unable to open file!");
							fwrite($myfile, json_encode($data, JSON_PRETTY_PRINT));
							fclose($myfile);
                            $command = escapeshellcmd('/usr/bin/python /home/xdolez01/public_html/flashcards/save_cards.py');
                            $output = shell_exec($command);
                            echo $output;

                            $file = fopen("data.json", "r") or die("Unable to open file!");
							$data_file = fread($file, filesize("data.json"));
							fclose($file);
							$data = json_decode($data_file, true);
                            $index = 0;
                            foreach ($data["users"] as $u) {
                                if ((string)$u["id"] == (string)$_SESSION["user_id"]) {
                                    break;
                                }
                                $index = $index + 1;
                            }
                            $set_id = 1;

                            if ($data["sets"] != []) {
                                $set_id = (int)$data["sets"][-1]["id"] + 1;
                            }
                            array_push($data["users"][$index]["sets_created"], $set_id);
                            $_SESSION["user"] = $data["users"][$index];
                            $myfile = fopen("data.json", "w") or die("Unable to open file!");
							fwrite($myfile, json_encode($data, JSON_PRETTY_PRINT));
							fclose($myfile);



							header('Location: set.php?set_id=' . (string)$set_id);
							die();
						}

						function test_input($data) {
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
