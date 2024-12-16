<?php
//Este ahora se encarga de llamar funciones, base de datos, autoload, etc.
require 'funciones.php'; 
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

$db = conectarDB();
use App\ClasePrincipal; //Lo modifico porque ahora vamos a tener la misma referencia a la base de datos en la clase padre
//para no estar abriendo la conexion en cada clase hija.
//De esta forma siempre utilizamos la misma instancia de la base de datos
ClasePrincipal::setDb($db);