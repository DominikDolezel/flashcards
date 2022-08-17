<?php
    session_start();
    if (isset($_SESSION["user_id"])) {
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
        
        $_SESSION["user"] = $data["users"][$index];

        header('Location: home.php');
    	die();
    } else {
        header('Location: register.php');
    	die();
    }
?>
