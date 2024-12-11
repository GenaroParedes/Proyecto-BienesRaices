<?php
//Este ahora se encarga de llamar funciones, base de datos, autoload, etc.
require 'funciones.php'; 
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

$db = conectarDB();
use App\Propiedad;
//De esta forma siempre utilizamos la misma instancia de la base de datos
Propiedad::setDb($db);