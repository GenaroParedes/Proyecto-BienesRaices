<?php
//Se incluye el archivo app.php, anteriormente habiamos dicho de utilizar include para incluir archivos, pero en este caso se utiliza require \
//ya que si no se encuentra el archivo app.php no tiene sentido que siga ejecutando el resto del codigo.
    require 'app.php'; //require lo utilizamos para importar las cosas más importantes.

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