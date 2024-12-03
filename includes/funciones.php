<?php
//Se incluye el archivo app.php, anteriormente habiamos dicho de utilizar include para incluir archivos, pero en este caso se utiliza require \
//ya que si no se encuentra el archivo app.php no tiene sentido que siga ejecutando el resto del codigo.
    require 'app.php'; //require lo utilizamos para importar las cosas más importantes.

function incluirTemplate(string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/$nombre.php";
}