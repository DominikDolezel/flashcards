<?php
    if (isset($_SESSION["user_id"])) {
        header('Location: home.php');
    	die();
    } else {
        session_start();
        header('Location: register.php');
    	die();
    }
?>
