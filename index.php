<?php
    session_start();
    if (isset($_SESSION["user_id"])) {
        header('Location: home.php');
    	die();
    } else {
        header('Location: register.php');
    	die();
    }
?>
