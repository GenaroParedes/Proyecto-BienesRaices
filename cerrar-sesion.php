<?php
    session_start(); //Siempre debemos iniciar session para poder utilizar el $_SESSION.
    $_SESSION = [];
    header('Location: /');
?>