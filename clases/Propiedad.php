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
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? 1; //Coloco un 1 momentaneamente hasta que retomemos con la parte
        //de los vendedores, para poder seleccionarlos desde el form.
    }

    public function guardar(){
        if (!is_null($this->id)){
            //Actualizando
            $this->actualizar();
        } else {
            //Creando
            $this->crear();
        }
    }

    public function crear() {
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
        //debuguear($resultado); //Si devuelve true se ejecutó correctamente
        if($resultado) {
            //Redireccionar al usuario cuando la propiedad se crea correctamente para que no aprete varias veces el boton
            header('Location: /admin?resultado=1'); 
            //resultado=1 es para que se muestre un mensaje de exito, este se va a mostrar en el index.php
            // en la parte de arriba, donde se hace la consulta de la queryString
        }
    }

    public function actualizar(){
        //Sanitizar los datos
        $abributos = $this->sanitizarDatos();
        //Todo lo siguiente lo hacemos para la query a base de datos
        $valores = [];
        foreach ($abributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }
        //El join convierte el array en un string, separando por coma los valores
        $query = "UPDATE propiedades SET "; 
        $query .= join(',', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);
        if($resultado) {
            //Redireccionar al usuario - Le pasamos como resultado un 2 ahora en vez de 1 como en la creacion
            header('Location: /admin?resultado=2'); 
        }
    }

    //Eliminamos una propiedad
    public function delete(){
        //self::$db->escape_string($this->id) esto lo hacemos para que el usuario no introduzca en la URL algo malicioso,
        //Sin intencion de eliminar sino de atacar, en caso de no pasar un int, el escape_string lo va a identificar.
        $query = "DELETE FROM propiedades WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        //Si hay resultado, redireccionamos a la misma pagina pero con un resultado=3 en la URL para tomar
        //ese valor y aplicar el mensaje de propiedad eliminada
        if ($resultado) {
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
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
            //Todas las referencias o lo relacionado a BD ahora se hace con "self::$db"
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
        /*Eliminar la imagen previa en caso de actualizacion de imagen - Comprobamos si existe un id en el objeto
        si existe id es porque estamos actualizando y no creando ya que el id se autoincrementa directamente en BD */
       if(!is_null($this->id)) {
            $this->borrarImagen();
       }
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Elimina archivo - Cuando eliminamos una propiedad, tambien tenemos que eliminar su imagen
    public function borrarImagen(){
        //esto nos da la ruta de la imagen que tenia el objeto.
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        //Si existe el archivo, lo eliminamos
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //Lista todas las propiedades
    public static function all(){
        //Consulta a realizar
        $query = "SELECT * from propiedades";
        
        //Llamamos la funcion que se encarga de iterar por cada registro
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Busca una propiedad por su id
    public static function find($id){
        //Consulta para obtener la propiedad con id pasada por la URL
        $query = "SELECT * FROM propiedades WHERE id = $id";
        $resultado = self::consultarSQL($query);
        //Devuelve el primer objeto del array, en este caso tenemos un solo resultado, 
        //pero lo hacemos para no devolver un array y devolver unicamente ese objeto
        return array_shift($resultado);
    }

    //Lo hago en una funcion aparte para poder reutilizar esta funcion (Consultar, actualizar, etc)
    public static function consultarSQL($query) {
        //Consultar la base de datos
        $resultado = self::$db->query($query);
        //Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            //Por cada registro llamamos la funcion crearObjeto para realizar la conversión, el array debe devolver un lista de objetos
            $array[] = self::crearObjeto($registro);
        }
        //debuguear($array); //Vamos a tener todos los registros de base de datos convertidos en objetos

        //Liberar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    //Es la funcion que vamos a utilizar para convertir los arreglos que nos devuelve la consulta a la BD en objetos.
    //La definimos como protected porque va a ser utilizada dentro de esta clase y no por fuera.
    protected static function crearObjeto($registro) {
        $objeto = new self; //Esto nos crea una instancia del objeto en el que nos encontramos
        //Recorro el registro y por cada llave ($key = nombreColumna) lo igualamos a su valor ($value = valor para ese registro)
        foreach ($registro as $key => $value ){
            if(property_exists($objeto, $key)){ //Verifica si el objeto $objeto tiene una propiedad con el nombre igual al valor de $key.
                $objeto -> $key = $value; //Cuando se cumpla que la $key exista, entonces se le asigna su $value
            }
        }
        return $objeto;
    }

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar( $args = []){
        foreach( $args as $key => $value){
            //Aca el $this hace referencia al objeto actual que está en el formulario de actualizacion
            if( property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
                //$key es cada uno de los atributos de la clase               
            }
        }
    }
}