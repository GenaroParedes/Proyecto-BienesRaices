<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', 'root', 'bienesraices_crud');

    if (!$db) {
        echo "Hubo un error al conectarse";
        exit;
    }
    return $db; 
}