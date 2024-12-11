<?php

function conectarDB() : mysqli {
    //Cambiamos la conexion a PDO
    $db = new mysqli('localhost', 'root', 'root', 'bienesraices_crud');

    if (!$db) {
        echo "Hubo un error al conectarse";
        exit;
    }
    return $db; 
}