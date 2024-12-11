<?php

//Superglobales, son como constantes que podemos utilizar en vez de utilizar la ruta
define('TEMPLATES_URL', __DIR__ . '/templates'); 
define('FUNCIONES_URL', __DIR__ . '/funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/$nombre.php";
}

function estaAutenticado(): bool {
    session_start(); //Iniciar sesion para guardar el usuario, para poder utilizar $_SESSION se debe inciar sesion
    $auth = $_SESSION['login']; //Guardamos un valor booleano para saber si el usuario esta logueado o no. Este valor viene del login.php
    if($auth){
        return true; //Si el login es true entonces es porque el usuario esta logueado
    }
    return false;
}

//Funcion para ver los valores que devuelven las variables/objetos/arrays
function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}