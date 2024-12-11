<?php

namespace App;

class Propiedad {
    // Base de datos - Lo hacemos estatico para tener una unica instancia de la BD
    protected static $db;
    //Creamos un arreglo con los nombre de las columnas en base de datos - Esto nos permite mapear el objeto
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;


    public static function setDb($database) {
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function guardar() {
        //Sanitizar los datos
        $abributos = $this->sanitizarDatos();

        //Insertar en la base de datos - El Join es para unir los valores de un arreglo, de esta forma podemos
        //unir los nombres de las columnas con los valores de las columnas
        $query = "INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($abributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($abributos));
        $query .= " ') ";

        //Se usa self cuando el atributo es estatico / se usa this cuando es un atributo publico
        $resultado = self::$db->query($query);
        return $resultado;
        //debuguear($resultado); //Si devuelve true se ejecutó correctamente
    }

    //Identificar y unir los atributos de la clase con las columnas de la BD
    public function atributos(){
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarDatos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            //echo $key; //Se imprime el nombre de la columna
            //echo $value; //Se imprime el valor de la columna
            //Sanitizar los datos antes de enviarlos a la BD
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Validacion
    public static function getErrores(){
        return self::$errores;
    }

    public function validar(){
        //Validar toda la informacion
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if (!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
        }

        if (strlen($this->descripcion) < 50) {
            self::$errores[] = "La descripción es obligatoria y debe contener más de 50 caracteres";
        }

        if (!$this->habitaciones) {
            self::$errores[] = "El número de habitaciones es obligatorio";
        }

        if (!$this->wc) {
            self::$errores[] = "El número de baños es obligatorio";
        }

        if (!$this->estacionamiento) {
            self::$errores[] = "El número de estacionamientos es obligatorio";
        }

        if (!$this->vendedorId) {
            self::$errores[] = "Elige un vendedor";
        }
        //Validacion de archivo - Si el campo name esta vacio o si hay un error (por tamaño), entonces no se sube la imagen
        //Estos 
       if(!$this->imagen) { 
            self::$errores[] = "La imagen es obligatoria";
        }

       
        return self::$errores;
    }

    public function setImagen($imagen) {
        if($imagen) {
            $this->imagen = $imagen;
        }
    }
}